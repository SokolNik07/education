<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'banner',
        'description',
        'founder',
    ];

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
