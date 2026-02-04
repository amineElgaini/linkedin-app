<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    /**
     * Stocker une nouvelle formation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'year_obtained' => 'required|integer|min:1950|max:' . date('Y'),
        ]);

        // Vérifier que l'utilisateur a un profil
        if (!Auth::user()->profile) {
            Auth::user()->profile()->create([
                'title' => null,
                'specialty' => null,
            ]);
        }

        Auth::user()->profile->educations()->create($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Formation ajoutée avec succès!');
    }

    /**
     * Mettre à jour une formation
     */
    public function update(Request $request, Education $education)
    {
        // Vérifier que la formation appartient à l'utilisateur
        if ($education->profile->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'year_obtained' => 'required|integer|min:1950|max:' . date('Y'),
        ]);

        $education->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Formation mise à jour avec succès!');
    }

    /**
     * Supprimer une formation
     */
    public function destroy(Education $education)
    {
        // Vérifier que la formation appartient à l'utilisateur
        if ($education->profile->user_id !== Auth::id()) {
            abort(403);
        }

        $education->delete();

        return redirect()->route('profile.show')
            ->with('success', 'Formation supprimée avec succès!');
    }
}