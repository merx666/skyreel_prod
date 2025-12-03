<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['reviewer', 'reviewee', 'job'])
            ->where('reviewee_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $job = Job::findOrFail($request->job_id);
        
        // Require job to be completed before allowing reviews
        if ($job->status !== 'completed') {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'Recenzje są dostępne dopiero po zakończeniu zlecenia.');
        }

        // Ensure there is an accepted proposal
        $accepted = $job->getAcceptedProposal();
        if (!$accepted) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'Recenzja jest możliwa tylko dla zleceń z zaakceptowaną ofertą.');
        }

        // Check if user is authorized to review this job
        if ($job->client_id !== Auth::id() && $accepted->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized to review this job.');
        }

        // Check if review already exists
        $existingReview = Review::where('job_listing_id', $job->id)
            ->where('reviewer_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already reviewed this job.');
        }

        // Determine who is being reviewed
        $reviewee = Auth::id() === $job->client_id 
            ? $accepted->operator 
            : $job->client;

        return view('reviews.create', compact('job', 'reviewee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $job = Job::findOrFail($request->job_id);
        
        // Require job to be completed before allowing reviews
        if ($job->status !== 'completed') {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'Recenzje są dostępne dopiero po zakończeniu zlecenia.');
        }

        // Ensure there is an accepted proposal
        $accepted = $job->getAcceptedProposal();
        if (!$accepted) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'Recenzja jest możliwa tylko dla zleceń z zaakceptowaną ofertą.');
        }

        // Check if user is authorized to review this job
        if ($job->client_id !== Auth::id() && $accepted->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized to review this job.');
        }

        // Check if review already exists
        $existingReview = Review::where('job_listing_id', $job->id)
            ->where('reviewer_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already reviewed this job.');
        }

        Review::create([
            'job_listing_id' => $request->validated()['job_id'],
            'reviewer_id' => Auth::id(),
            'reviewee_id' => $request->validated()['reviewee_id'],
            'rating' => $request->validated()['rating'],
            'comment' => $request->validated()['comment'],
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Review submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load(['reviewer', 'reviewee', 'job']);
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        // Only allow reviewer to edit their own review
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Unauthorized to edit this review.');
        }

        $job = $review->job;
        $reviewee = $review->reviewee;

        return view('reviews.edit', compact('review', 'job', 'reviewee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Only allow reviewer to update their own review
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Unauthorized to update this review.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('jobs.show', $review->job)
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Only allow reviewer to delete their own review
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Unauthorized to delete this review.');
        }

        $job = $review->job;
        $review->delete();

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Review deleted successfully!');
    }
}
