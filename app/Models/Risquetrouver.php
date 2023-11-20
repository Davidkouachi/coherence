<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risquetrouver extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'amelioration_id',
        'risque_id',
    ];

    public function amelioration()
    {
        return $this->belongsTo(Amelioration::class, 'amelioration_id');
    }
    public function risque()
    {
        return $this->belongsTo(Risque::class, 'risque_id');
    }
}
