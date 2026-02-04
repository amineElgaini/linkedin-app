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

    public function update(Request $request, Experience $experience)
    {
        $this->authorize('update', $experience);

        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
        ]);

        $experience->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Expérience mise à jour avec succès!');
    }


    public function destroy(Experience $experience)
    {
        $this->authorize('delete', $experience);

        $experience->delete();

        return redirect()->route('profile.show')
            ->with('success', 'Expérience supprimée avec succès!');
    }
}