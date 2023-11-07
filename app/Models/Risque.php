<?php

namespace App\Models;

use App\Models\Processus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risque extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nom',
        'vraisemblence',
        'gravite',
        'evaluation',
        'cout',
        'vraisemblence_residuel',
        'gravite_residuel',
        'evaluation_residuel',
        'cout_residuel',
        'date_validation',
        'processus_id',
        'statut',
        'traitement',
    ];

    public function processus()
    {
        return $this->belongsTo(Processus::class, 'processus_id');
    }
}
