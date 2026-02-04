<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'specialty',
    ];

    // ============================================
    // RELATIONS
    // ============================================

    /**
     * Relation One-to-One inverse avec User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation One-to-Many avec Education
     */
    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Relation One-to-Many avec Experience
     */
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Relation Many-to-Many avec Skill
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'profile_skill')
            ->withTimestamps();
    }
}