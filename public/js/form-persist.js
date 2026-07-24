/**
 * Sauvegarde automatique (brouillon) des formulaires de l'app dans sessionStorage,
 * pour ne pas perdre une saisie en cours quand on quitte la page puis qu'on y revient.
 *
 * Convention (aucune config requise pour un formulaire "normal") :
 * - Un formulaire contenant un input[type=password] n'est jamais persisté (sécurité).
 * - Un formulaire sans aucun champ "utile" (juste _token/_method/boutons) est ignoré.
 * - `data-no-persist` sur un <form> désactive explicitement la persistance
 *   (utilisé pour les modales de type "Modifier X" réutilisées pour plusieurs
 *   enregistrements différents, où la persistance créerait un mélange de données
 *   entre deux enregistrements).
 * - `data-persist-key="xxx"` sur un <form> force la clé de stockage (utile quand
 *   la même balise <form> sert à la fois pour une création et pour l'édition de
 *   plusieurs enregistrements différents : la page doit alors mettre à jour cet
 *   attribut en JS avant d'afficher le formulaire, ex: 'creation' vs 'edit-42').
 * - `data-persist-cancel` sur un bouton/lien à l'intérieur (ou en dehors, avec la
 *   valeur = id du form ciblé) efface le brouillon quand l'utilisateur annule
 *   explicitement sa saisie.
 * - La sauvegarde est effacée automatiquement à la soumission du formulaire.
 */
(function () {
    'use strict';

    var PREFIX = 'formpersist::';
    var DEBOUNCE_MS = 300;
    var FIELD_TAGS = ['INPUT', 'SELECT', 'TEXTAREA'];
    var IGNORED_TYPES = ['file', 'password', 'hidden', 'submit', 'button', 'reset', 'image'];

    function storageKey(form) {
        var id = form.dataset.persistKey || form.id || form.getAttribute('name') ||
            form.getAttribute('action') || 'form';
        return PREFIX + location.pathname + '::' + id;
    }

    function getFields(form) {
        return Array.prototype.filter.call(form.elements, function (el) {
            if (FIELD_TAGS.indexOf(el.tagName) === -1) return false;
            if (el.disabled) return false;
            if (!el.name && !el.id) return false;
            var type = (el.type || '').toLowerCase();
            return IGNORED_TYPES.indexOf(type) === -1;
        });
    }

    function fieldKey(el) {
        return el.name || el.id;
    }

    function groupsOf(form) {
        var groups = {};
        getFields(form).forEach(function (el) {
            var key = fieldKey(el);
            (groups[key] = groups[key] || []).push(el);
        });
        return groups;
    }

    function isPersistable(form) {
        if (form.hasAttribute('data-no-persist')) return false;
        if (form.querySelector('input[type="password" i]')) return false;
        return getFields(form).length > 0;
    }

    function fireEvents(el) {
        el.dispatchEvent(new Event('input', { bubbles: true }));
        el.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function serialize(form) {
        var data = {};
        var groups = groupsOf(form);
        Object.keys(groups).forEach(function (key) {
            var els = groups[key];
            var type = (els[0].type || '').toLowerCase();
            if (type === 'checkbox' && els.length > 1) {
                data[key] = els.filter(function (e) { return e.checked; }).map(function (e) { return e.value; });
            } else if (type === 'checkbox') {
                data[key] = els[0].checked;
            } else if (type === 'radio') {
                var checked = els.filter(function (e) { return e.checked; })[0];
                data[key] = checked ? checked.value : null;
            } else if (els[0].tagName === 'SELECT' && els[0].multiple) {
                data[key] = Array.prototype.filter.call(els[0].options, function (o) { return o.selected; })
                    .map(function (o) { return o.value; });
            } else {
                data[key] = els[0].value;
            }
        });
        return data;
    }

    function restore(form, data) {
        var groups = groupsOf(form);
        Object.keys(data).forEach(function (key) {
            var els = groups[key];
            if (!els || !els.length) return;
            var val = data[key];
            var type = (els[0].type || '').toLowerCase();
            if (type === 'checkbox' && els.length > 1) {
                var arr = Array.isArray(val) ? val : [];
                els.forEach(function (e) { e.checked = arr.indexOf(e.value) !== -1; fireEvents(e); });
            } else if (type === 'checkbox') {
                els[0].checked = !!val;
                fireEvents(els[0]);
            } else if (type === 'radio') {
                els.forEach(function (e) { e.checked = (e.value === val); });
                var matched = els.filter(function (e) { return e.checked; })[0];
                if (matched) fireEvents(matched);
            } else if (els[0].tagName === 'SELECT' && els[0].multiple) {
                var arr2 = Array.isArray(val) ? val : [];
                Array.prototype.forEach.call(els[0].options, function (o) { o.selected = arr2.indexOf(o.value) !== -1; });
                fireEvents(els[0]);
            } else if (typeof val === 'string') {
                els[0].value = val;
                fireEvents(els[0]);
            }
        });
    }

    function readStorage(key) {
        try {
            var raw = sessionStorage.getItem(key);
            return raw ? JSON.parse(raw) : null;
        } catch (e) {
            return null;
        }
    }

    function writeStorage(key, data) {
        try {
            sessionStorage.setItem(key, JSON.stringify(data));
        } catch (e) {
            // sessionStorage indisponible (navigation privée stricte, quota...) : on ignore.
        }
    }

    function clearStorage(key) {
        try {
            sessionStorage.removeItem(key);
        } catch (e) {
            // idem
        }
    }

    function attach(form) {
        var timer = null;

        function scheduleSave() {
            clearTimeout(timer);
            timer = setTimeout(function () {
                writeStorage(storageKey(form), serialize(form));
            }, DEBOUNCE_MS);
        }

        var saved = readStorage(storageKey(form));
        if (saved) restore(form, saved);

        form.addEventListener('input', scheduleSave);
        form.addEventListener('change', scheduleSave);
        form.addEventListener('submit', function () {
            clearTimeout(timer);
            clearStorage(storageKey(form));
        });
    }

    function initCancelButtons() {
        document.querySelectorAll('[data-persist-cancel]').forEach(function (el) {
            el.addEventListener('click', function () {
                var targetId = el.getAttribute('data-persist-cancel');
                var form = targetId ? document.getElementById(targetId) : el.closest('form');
                if (form) clearStorage(storageKey(form));
            });
        });
    }

    function init() {
        Array.prototype.forEach.call(document.forms, function (form) {
            if (isPersistable(form)) attach(form);
        });
        initCancelButtons();

        window.FormPersist = {
            clear: function (form) { if (form) clearStorage(storageKey(form)); },
            save: function (form) { if (form) writeStorage(storageKey(form), serialize(form)); },
            // À appeler manuellement après avoir changé form.dataset.persistKey (formulaires
            // réutilisés pour plusieurs enregistrements, ex: une modale "créer OU modifier"),
            // pour recharger le brouillon correspondant à la nouvelle clé.
            restore: function (form) {
                if (!form) return;
                var saved = readStorage(storageKey(form));
                if (saved) restore(form, saved);
            },
        };
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
