<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccesAuditLog extends Model
{
    const UPDATED_AT = null;

    protected $table = 'acces_audit_log';

    protected $fillable = [
        'user_id',
        'action',
        'performed_by',
        'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
