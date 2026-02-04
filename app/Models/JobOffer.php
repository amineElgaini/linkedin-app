<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'title',
        'description',
        'contract_type',
        'image',
        'status',
    ];

    // ============================================
    // RELATIONS
    // ============================================

    /**
     * Relation Many-to-One avec User (recruteur)
     */
    public function recruiter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation Many-to-Many avec User via Applications
     * Les candidats qui ont postulé
     */
    public function applicants()
    {
        return $this->belongsToMany(User::class, 'applications')
            ->withPivot('status')
            ->withTimestamps();
    }

    /**
     * Toutes les candidatures pour cette offre
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope pour les offres ouvertes
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope pour les offres fermées
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function close(): void
    {
        $this->update(['status' => 'closed']);
    }
}