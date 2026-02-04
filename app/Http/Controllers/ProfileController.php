<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur connecté
     */
    public function show()
    {
        $user = Auth::user()->load([
            'profile.educations',
            'profile.experiences',
            'profile.skills'
        ]);

        return view('profile.show', compact('user'));
    }

    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Mettre à jour le profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // 2MB max
            'title' => ['nullable', 'string', 'max:255'],
            'specialty' => ['nullable', 'string', 'max:255'],
        ]);

        // Upload de la photo de profil
        if ($request->hasFile('profile_photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $validated['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        // Mettre à jour les informations de base
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'bio' => $validated['bio'] ?? null,
            'profile_photo' => $validated['profile_photo'] ?? $user->profile_photo,
        ]);

        // Mettre à jour le profil pour les chercheurs d'emploi
        if ($user->role === 'job_seeker') {
            if (!$user->profile) {
                $user->profile()->create([
                    'title' => $validated['title'] ?? null,
                    'specialty' => $validated['specialty'] ?? null,
                ]);
            } else {
                $user->profile->update([
                    'title' => $validated['title'] ?? $user->profile->title,
                    'specialty' => $validated['specialty'] ?? $user->profile->specialty,
                ]);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Afficher le profil public d'un utilisateur
     */
    public function showPublic($id)
    {
        $user = User::with([
            'profile.educations',
            'profile.experiences',
            'profile.skills'
        ])->findOrFail($id);

        return view('profile.public', compact('user'));
    }

    /**
     * Rechercher des utilisateurs
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $specialty = $request->input('specialty');

        $users = User::query()
            ->where('role', 'job_seeker')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->when($specialty, function ($q) use ($specialty) {
                $q->whereHas('profile', function ($query) use ($specialty) {
                    $query->where('specialty', 'like', "%{$specialty}%");
                });
            })
            ->with('profile')
            ->paginate(12);

        return view('users.search', compact('users', 'query', 'specialty'));
    }

    /**
     * Supprimer le compte utilisateur
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}