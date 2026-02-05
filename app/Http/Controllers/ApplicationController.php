<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Apply to a job offer
     */
    public function apply(JobOffer $jobOffer)
    {
        $user = Auth::user();

        // Check if user already applied
        if (Application::where('user_id', $user->id)
            ->where('job_offer_id', $jobOffer->id)
            ->exists()) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        // Create new application
        Application::create([
            'user_id' => $user->id,
            'job_offer_id' => $jobOffer->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Votre candidature a été envoyée avec succès!');
    }

    /**
     * Show all applications for the logged-in user (Job Seeker)
     */
    public function myApplications()
    {
        $applications = Auth::user()
            ->applications()
            ->with('jobOffer')
            ->latest()
            ->paginate(10);

        return view('applications.my-applications', compact('applications'));
    }

    /**
     * Show all applications received for the logged-in recruiter's offers
     */
    public function index()
    {
        $user = Auth::user();

        // Get IDs of job offers created by this recruiter
        $jobOfferIds = $user->jobOffers()->pluck('id');

        // Get applications for these job offers
        $applications = Application::whereIn('job_offer_id', $jobOfferIds)
            ->with(['jobOffer', 'user.profile']) // Eager load relationships
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    /**
     * Update the status (for admin/recruiter)
     */
    public function updateStatus(Request $request, Application $application)
    {
        // Optional: Add policy check if only recruiters can update
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Statut mis à jour avec succès!');
    }

    /**
     * Cancel an application (for the candidate)
     */
    public function destroy(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $application->delete();

        return redirect()->back()->with('success', 'Votre candidature a été annulée.');
    }
}
