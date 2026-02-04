<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\FriendshipController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes publiques - Offres d'emploi
Route::get('/job-offers', [JobOfferController::class, 'index'])->name('job-offers.index');
Route::get('/job-offers/{jobOffer}', [JobOfferController::class, 'show'])->name('job-offers.show');

// Routes authentifiées
Route::middleware('auth')->group(function () {
    
    // ==========================================
    // PROFIL UTILISATEUR
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profils publics et recherche
    Route::get('/search', [ProfileController::class, 'search'])->name('users.search');
    Route::get('/users/{user}', [ProfileController::class, 'showPublic'])->name('users.show');
    
    // ==========================================
    // GESTION CV (Expériences, Formations, Compétences)
    // ==========================================
    Route::middleware('role:job_seeker')->group(function () {
        // Expériences
        Route::post('/experiences', [ExperienceController::class, 'store'])->name('experiences.store');
        Route::put('/experiences/{experience}', [ExperienceController::class, 'update'])->name('experiences.update');
        Route::delete('/experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experiences.destroy');
        
        // Formations
        Route::post('/educations', [EducationController::class, 'store'])->name('educations.store');
        Route::put('/educations/{education}', [EducationController::class, 'update'])->name('educations.update');
        Route::delete('/educations/{education}', [EducationController::class, 'destroy'])->name('educations.destroy');
        
        // Compétences
        Route::post('/skills/attach', [SkillController::class, 'attach'])->name('skills.attach');
        Route::delete('/skills/{skill}/detach', [SkillController::class, 'detach'])->name('skills.detach');
        Route::get('/skills/search', [SkillController::class, 'search'])->name('skills.search');
    });
    
    // ==========================================
    // ROUTES RECRUTEUR
    // ==========================================
    Route::middleware('role:recruiter')->group(function () {
        // Gestion des offres
        Route::get('/job-offers/create', [JobOfferController::class, 'create'])->name('job-offers.create');
        Route::post('/job-offers', [JobOfferController::class, 'store'])->name('job-offers.store');
        Route::get('/job-offers/{jobOffer}/edit', [JobOfferController::class, 'edit'])->name('job-offers.edit');
        Route::put('/job-offers/{jobOffer}', [JobOfferController::class, 'update'])->name('job-offers.update');
        Route::delete('/job-offers/{jobOffer}', [JobOfferController::class, 'destroy'])->name('job-offers.destroy');
        Route::patch('/job-offers/{jobOffer}/close', [JobOfferController::class, 'close'])->name('job-offers.close');
        
        // Consultation des candidatures
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
    });
    
    // ==========================================
    // ROUTES CHERCHEUR D'EMPLOI
    // ==========================================
    Route::middleware('role:job_seeker')->group(function () {
        // Candidatures
        Route::post('/job-offers/{jobOffer}/apply', [ApplicationController::class, 'apply'])->name('applications.apply');
        Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my');
        Route::delete('/applications/{application}', [ApplicationController::class, 'withdraw'])->name('applications.withdraw');
        
        // Gestion des amitiés
        Route::post('/friends/{user}/request', [FriendshipController::class, 'sendRequest'])->name('friends.request');
        Route::post('/friends/{friendship}/accept', [FriendshipController::class, 'accept'])->name('friends.accept');
        Route::post('/friends/{friendship}/reject', [FriendshipController::class, 'reject'])->name('friends.reject');
        Route::delete('/friends/{friendship}', [FriendshipController::class, 'remove'])->name('friends.remove');
        Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
        Route::get('/friends/requests', [FriendshipController::class, 'requests'])->name('friends.requests');
    });
});

require __DIR__.'/auth.php';