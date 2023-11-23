<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suivi_amelioration extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'efficacite',
        'commentaire',
        'date_action',
        'date_suivi',
        'delai',
        'statut',
        'amelioration_id',
    ];

    public function amelioration()
    {
        return $this->belongsTo(Amelioration::class, 'amelioration_id');
    }

}
