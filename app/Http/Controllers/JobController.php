<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $jobs = Job::with(['client.profile', 'proposals.operator.profile'])
                   ->withCount('proposals')
                   ->open()
                   ->recent()
                   ->paginate(12);

        return view('jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        $job->load(['client.profile', 'proposals.operator.profile']);
        
        $userProposal = null;
        if (Auth::check() && Auth::user()->isOperator()) {
            $userProposal = $job->proposals()
                               ->where('operator_id', Auth::id())
                               ->first();
        }

        return view('jobs.show', compact('job', 'userProposal'));
    }

    public function create()
    {
        $this->authorize('create', Job::class);
        
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Job::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
        ]);

        $job = Job::create([
            'client_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'budget' => $validated['budget'],
            'status' => 'open',
        ]);

        return redirect()->route('jobs.show', $job)
                        ->with('success', 'Zlecenie zostało utworzone pomyślnie!');
    }

    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:open,in_progress,completed,closed',
        ]);

        $job->update($validated);

        return redirect()->route('jobs.show', $job)
                        ->with('success', 'Zlecenie zostało zaktualizowane!');
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return redirect()->route('jobs.index')
                        ->with('success', 'Zlecenie zostało usunięte!');
    }

    public function myJobs()
    {
        $user = Auth::user();
        
        if ($user->isClient()) {
            $jobs = Job::where('client_id', $user->id)
                       ->with(['proposals.operator'])
                       ->recent()
                       ->paginate(10);
        } else {
            $jobs = Job::whereHas('proposals', function ($query) use ($user) {
                        $query->where('operator_id', $user->id);
                    })
                    ->with(['client', 'proposals' => function ($query) use ($user) {
                        $query->where('operator_id', $user->id);
                    }])
                    ->recent()
                    ->paginate(10);
        }

        return view('jobs.my-jobs', compact('jobs'));
    }

    public function submitProposal(Request $request, Job $job)
    {
        $this->authorize('submitProposal', $job);

        // Check if user already has a proposal for this job
        $existingProposal = JobProposal::where('job_listing_id', $job->id)
                                      ->where('operator_id', Auth::id())
                                      ->first();

        if ($existingProposal) {
            return back()->with('error', 'Już złożyłeś ofertę dla tego zlecenia!');
        }

        $validated = $request->validate([
            'proposal_text' => 'required|string',
            'proposed_fee' => 'required|numeric|min:0',
        ]);

        JobProposal::create([
            'job_listing_id' => $job->id,
            'operator_id' => Auth::id(),
            'proposal_text' => $validated['proposal_text'],
            'proposed_fee' => $validated['proposed_fee'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Twoja oferta została złożona pomyślnie!');
    }

    public function acceptProposal(JobProposal $proposal)
    {
        $this->authorize('acceptProposal', $proposal->job);

        // Reject all other proposals for this job
        JobProposal::where('job_listing_id', $proposal->job_listing_id)
                   ->where('id', '!=', $proposal->id)
                   ->update(['status' => 'rejected']);

        // Accept this proposal
        $proposal->update(['status' => 'accepted']);

        // Update job status
        $proposal->job->update(['status' => 'in_progress']);

        return back()->with('success', 'Oferta została zaakceptowana!');
    }

    public function rejectProposal(JobProposal $proposal)
    {
        $this->authorize('rejectProposal', $proposal->job);

        $proposal->update(['status' => 'rejected']);

        return back()->with('success', 'Oferta została odrzucona.');
    }

    public function markCompleted(Job $job)
    {
        $this->authorize('markCompleted', $job);

        $job->update(['status' => 'completed']);

        return back()->with('success', 'Zlecenie zostało oznaczone jako zakończone!');
    }
}