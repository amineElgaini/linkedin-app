<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Stocker une nouvelle expérience
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
        ]);

        // Vérifier que l'utilisateur a un profil
        if (!Auth::user()->profile) {
            Auth::user()->profile()->create([
                'title' => null,
                'specialty' => null,
            ]);
        }

        Auth::user()->profile->experiences()->create($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Expérience ajoutée avec succès!');
    }

    /**
     * Mettre à jour une expérience
     */
    public function update(Request $request, Experience $experience)
    {
        // Vérifier que l'expérience appartient à l'utilisateur
        if ($experience->profile->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
        ]);

        $experience->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Expérience mise à jour avec succès!');
    }

    /**
     * Supprimer une expérience
     */
    public function destroy(Experience $experience)
    {
        // Vérifier que l'expérience appartient à l'utilisateur
        if ($experience->profile->user_id !== Auth::id()) {
            abort(403);
        }

        $experience->delete();

        return redirect()->route('profile.show')
            ->with('success', 'Expérience supprimée avec succès!');
    }
}