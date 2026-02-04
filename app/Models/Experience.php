<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'position',
        'company',
        'duration',
    ];

    /**
     * Relation Many-to-One avec Profile
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}