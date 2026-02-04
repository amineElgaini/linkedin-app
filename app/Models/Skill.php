<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Relation Many-to-Many avec Profile
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_skill')
            ->withTimestamps();
    }
}