<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensibilisation extends Model
{
    protected $fillable = ['projet_id', 'theme', 'photo_path', 'jours_prevus', 'date_realisation'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
