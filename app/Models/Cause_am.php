<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cause_am extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nom',
        'risque_id',
    ];

    public function risque()
    {
        return $this->belongsTo(Risque::class, 'risque_id');
    }
}
