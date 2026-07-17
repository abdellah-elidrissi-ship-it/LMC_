@php
    $clientName = $clientName ?? 'Client non défini';
    $clientLogo = $clientLogo ?? null;
    $clientSize = $clientSize ?? 'medium';

    $sizes = [
        'small' => [
            'logo' => '34px',
            'font' => '0.82rem',
            'radius' => '8px',
        ],
        'medium' => [
            'logo' => '46px',
            'font' => '0.95rem',
            'radius' => '11px',
        ],
        'large' => [
            'logo' => '58px',
            'font' => '1.1rem',
            'radius' => '14px',
        ],
    ];

    $selectedSize = $sizes[$clientSize] ?? $sizes['medium'];

    $initial = mb_strtoupper(
        mb_substr(trim($clientName ?: 'C'), 0, 1)
    );
@endphp

<span
    class="client-logo-name"
    style="
        --client-logo-size: {{ $selectedSize['logo'] }};
        --client-name-font: {{ $selectedSize['font'] }};
        --client-logo-radius: {{ $selectedSize['radius'] }};
    "
>
    @if(!empty($clientLogo))
        <span class="client-logo-name__box">
            <img
                src="{{ $clientLogo }}"
                alt="Logo {{ $clientName }}"
                class="client-logo-name__image"
                loading="lazy"
                onerror="
                    this.parentElement.style.display='none';
                    this.parentElement.nextElementSibling.style.display='flex';
                "
            >
        </span>

        <span
            class="client-logo-name__fallback"
            style="display:none;"
        >
            {{ $initial }}
        </span>
    @else
        <span class="client-logo-name__fallback">
            {{ $initial }}
        </span>
    @endif

    <span class="client-logo-name__text">
        {{ $clientName }}
    </span>
</span>