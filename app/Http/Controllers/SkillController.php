<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{

    public function attach(Request $request)
    {
        $validated = $request->validate([
            'skill_name' => 'required|string|max:255',
        ]);

        if (!Auth::user()->profile) {
            Auth::user()->profile()->create([
                'title' => null,
                'specialty' => null,
            ]);
        }

        $skill = Skill::firstOrCreate([
            'name' => $validated['skill_name']
        ]);

        if (!Auth::user()->profile->skills->contains($skill->id)) {
            Auth::user()->profile->skills()->attach($skill->id);

            return redirect()->route('profile.show')
                ->with('success', 'Compétence ajoutée avec succès!');
        }

        return redirect()->route('profile.show')
            ->with('info', 'Cette compétence existe déjà dans votre profil.');
    }

    public function detach(Skill $skill)
    {
        if (!Auth::user()->profile) {
            abort(404);
        }

        Auth::user()->profile->skills()->detach($skill->id);

        return redirect()->route('profile.show')
            ->with('success', 'Compétence retirée avec succès!');
    }

   
    public function search(Request $request)
    {
        $query = $request->input('query');

        $skills = Skill::where('name', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($skills);
    }
}