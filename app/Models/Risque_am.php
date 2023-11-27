<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risque_am extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nom',
        'processus_id',
        'poste_id',
    ];

    public function processus()
    {
        return $this->belongsTo(Processuse::class, 'processus_id');
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }
}
