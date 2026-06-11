<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'pokemon_id',
        'nickname',
        'level',
    ];
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
