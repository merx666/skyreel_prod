<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class JobProposalController extends Controller
{
    /**
     * Store a new job proposal
     */
    public function store(Request $request, Job $job)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany aby składać oferty.');
        }

        // Check if user is an operator
        if (Auth::user()->role !== 'operator') {
            return redirect()->back()->with('error', 'Tylko operatorzy mogą składać oferty.');
        }

        // Check if job is open for proposals
        if (!$job->canReceiveProposals()) {
            return redirect()->back()->with('error', 'To zlecenie nie przyjmuje już ofert.');
        }

        // Check if user already has a proposal for this job
        if ($job->hasProposalFrom(Auth::user())) {
            return redirect()->back()->with('error', 'Już złożyłeś ofertę dla tego zlecenia.');
        }

        $validated = $request->validate([
            'proposal_text' => 'required|string|min:50|max:2000',
            'proposed_fee' => 'required|numeric|min:0|max:999999.99',
        ], [
            'proposal_text.required' => 'Opis oferty jest wymagany.',
            'proposal_text.min' => 'Opis oferty musi mieć co najmniej 50 znaków.',
            'proposal_text.max' => 'Opis oferty nie może przekraczać 2000 znaków.',
            'proposed_fee.required' => 'Proponowana kwota jest wymagana.',
            'proposed_fee.numeric' => 'Proponowana kwota musi być liczbą.',
            'proposed_fee.min' => 'Proponowana kwota nie może być ujemna.',
            'proposed_fee.max' => 'Proponowana kwota jest zbyt wysoka.',
        ]);

        JobProposal::create([
            'job_listing_id' => $job->id,
            'operator_id' => Auth::id(),
            'proposal_text' => $validated['proposal_text'],
            'proposed_fee' => $validated['proposed_fee'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Twoja oferta została wysłana pomyślnie!');
    }

    /**
     * Accept a job proposal
     */
    public function accept(JobProposal $proposal)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany.');
        }

        $job = $proposal->job;

        // Check if user is the job owner
        Gate::authorize('update', $job);

        // Check if job is still open
        if (!$job->canReceiveProposals()) {
            return redirect()->back()->with('error', 'To zlecenie nie jest już otwarte.');
        }

        // Check if proposal is still pending
        if (!$proposal->isPending()) {
            return redirect()->back()->with('error', 'Ta oferta została już rozpatrzona.');
        }

        // Accept the proposal
        $proposal->update(['status' => 'accepted']);

        // Update job status to in_progress
        $job->update(['status' => 'in_progress']);

        // Reject all other pending proposals for this job
        $job->proposals()
            ->where('id', '!=', $proposal->id)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Oferta została zaakceptowana! Zlecenie jest teraz w trakcie realizacji.');
    }

    /**
     * Reject a job proposal
     */
    public function reject(JobProposal $proposal)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany.');
        }

        $job = $proposal->job;

        // Check if user is the job owner
        Gate::authorize('update', $job);

        // Check if proposal is still pending
        if (!$proposal->isPending()) {
            return redirect()->back()->with('error', 'Ta oferta została już rozpatrzona.');
        }

        // Reject the proposal
        $proposal->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Oferta została odrzucona.');
    }
}
