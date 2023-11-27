<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action_am extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'action',
        'poste_id',
        'risque_id',
        'risque_id_am',
    ];

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    public function risque()
    {
        return $this->belongsTo(Risque_am::class, 'risque_id');
    }

    public function risque_am()
    {
        return $this->belongsTo(Risque_am::class, 'risque_id_am');
    }
}
