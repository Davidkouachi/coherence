<?php

namespace App\Models;

use App\Models\Risque;
use App\Models\Resva;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'action',
        'delai',
        'type',
        'statut',
        'responsable_id',
        'risque_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function risque()
    {
        return $this->belongsTo(Risque::class, 'risque_id');
    }
}
