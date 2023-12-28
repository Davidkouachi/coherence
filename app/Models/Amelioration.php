<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amelioration extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'date_fiche',
        'date_cloture1',
        'lieu',
        'detecteur',
        'non_conformite',
        'consequence',
        'cause',
        'choix_select',
        'statut',
        'date_validation',
    ];

}
