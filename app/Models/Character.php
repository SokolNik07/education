<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'biography',
        'obituary',
        'status',
        'fraction_id',
        'user_id',
        'image',
    ];

    public function fraction()
    {
        return $this->belongsTo(Fraction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
