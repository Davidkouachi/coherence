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
        'lieu',
        'detecteur',
        'non_conformite',
        'consequence',
        'cause',
        'choix_select',
        'nature',
        'commentaire',
        'action_id',
    ];

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }
}
