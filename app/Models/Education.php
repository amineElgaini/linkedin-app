<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $table = 'educations';

    protected $fillable = [
        'profile_id',
        'degree',
        'school',
        'year_obtained',
    ];

    /**
     * Relation Many-to-One avec Profile
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}