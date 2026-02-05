<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query'); // search by title
        $company = $request->input('company'); // search by company

        $jobOffers = JobOffer::query()
            ->when($query, fn($q) => $q->where('title', 'like', "%{$query}%"))
            ->when($company, fn($q) => $q->where('company_name', 'like', "%{$company}%"))
            ->latest()
            ->paginate(12);

        return view('job-offers.index', compact('jobOffers', 'query', 'company'));
    }

    /**
     * Show the form for creating a new job offer
     */
    public function create()
    {
        return view('job-offers.create');
    }

    /**
     * Store a newly created job offer in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required|string',
            'contract_type' => 'required|in:CDI,CDD,Freelance,Stage,Alternance',
            'image' => 'nullable|url', // Assuming simple URL for now, or file upload logic
        ]);

        $request->user()->jobOffers()->create([
            'title' => $validated['title'],
            'company_name' => $validated['company_name'],
            'description' => $validated['description'],
            'contract_type' => $validated['contract_type'],
            'image' => $validated['image'] ?? 'https://placehold.co/600x400', // Default image or handle upload
            'status' => 'open',
        ]);

        return redirect()->route('job-offers.index')->with('success', 'Offre d\'emploi créée avec succès!');
    }

    /**
     * Remove the specified job offer from storage
     */
    public function destroy(JobOffer $jobOffer)
    {
        // Add authorization check
        if ($jobOffer->user_id !== auth()->id()) {
            abort(403);
        }

        $jobOffer->delete();

        return redirect()->back()->with('success', 'Offre d\'emploi supprimée.');
    }

    /**
     * Close the job offer
     */
    public function close(JobOffer $jobOffer)
    {
        if ($jobOffer->user_id !== auth()->id()) {
            abort(403);
        }

        $jobOffer->close();

        return redirect()->back()->with('success', 'Offre d\'emploi clôturée.');
    }
}
