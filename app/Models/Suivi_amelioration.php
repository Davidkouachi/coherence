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
        'nature',
        'type',
        'commentaire',
        'trouve',
        'commentaire_am',
        'date_action',
        'date_suivi',
        'delai',
        'statut',
        'amelioration_id',
        'action_id',
        'processus_id',
        'risque_id',
        'cause_id',
    ];

    public function amelioration()
    {
        return $this->belongsTo(Amelioration::class, 'amelioration_id');
    }

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }

    public function processus()
    {
        return $this->belongsTo(Processus::class, 'processus_id');
    }

    public function risque()
    {
        return $this->belongsTo(Risque::class, 'risque_id');
    }

    public function cause()
    {
        return $this->belongsTo(Cause::class, 'cause_id');
    }

}
