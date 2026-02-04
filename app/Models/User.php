<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'bio',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ============================================
    // RELATIONS
    // ============================================

    /**
     * Relation One-to-One avec Profile
     * Un chercheur d'emploi a un profil
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Relation One-to-Many avec JobOffer
     * Un recruteur peut créer plusieurs offres d'emploi
     */
    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class);
    }

    /**
     * Relation Many-to-Many avec JobOffer via Applications
     * Un candidat peut postuler à plusieurs offres
     */
    public function applications()
    {
        return $this->belongsToMany(JobOffer::class, 'applications')
            ->withPivot('status')
            ->withTimestamps();
    }

    /**
     * Demandes d'amitié envoyées
     */
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    /**
     * Demandes d'amitié reçues
     */
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    /**
     * Tous les amis acceptés
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public function isRecruiter(): bool
    {
        return $this->role === 'recruiter';
    }

    public function isJobSeeker(): bool
    {
        return $this->role === 'job_seeker';
    }

    /**
     * Vérifier si l'utilisateur a déjà postulé à une offre
     */
    public function hasAppliedTo(JobOffer $jobOffer): bool
    {
        return $this->applications()->where('job_offer_id', $jobOffer->id)->exists();
    }

    /**
     * Vérifier si deux utilisateurs sont amis
     */
    public function isFriendWith(User $user): bool
    {
        return $this->friends()->where('friend_id', $user->id)->exists()
            || $user->friends()->where('friend_id', $this->id)->exists();
    }

    /**
     * Vérifier s'il y a une demande d'amitié en attente
     */
    public function hasPendingFriendRequestWith(User $user): bool
    {
        return Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $this->id)->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('friend_id', $this->id);
        })->where('status', 'pending')->exists();
    }
}