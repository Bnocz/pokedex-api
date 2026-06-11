<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
    ];
    public function pokemon()
    {
        return $this->hasMany(Pokemon::class);
    }
}
