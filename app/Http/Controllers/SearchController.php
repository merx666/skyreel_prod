<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Display the search page.
     */
    public function index(Request $request): View
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all'); // all, operators, jobs
        $location = $request->get('location', '');
        $budget_min = $request->get('budget_min');
        $budget_max = $request->get('budget_max');

        $operators = collect();
        $jobs = collect();

        if ($query || $location || $budget_min || $budget_max) {
            if ($type === 'all' || $type === 'operators') {
                $operators = $this->searchOperators($query, $location);
            }

            if ($type === 'all' || $type === 'jobs') {
                $jobs = $this->searchJobs($query, $location, $budget_min, $budget_max);
            }
        }

        return view('search.index', compact('operators', 'jobs', 'query', 'type', 'location', 'budget_min', 'budget_max'));
    }

    /**
     * Search for operators.
     */
    private function searchOperators(string $query, string $location = '')
    {
        $search = User::search($query)
            ->where('role', 'operator');

        if ($location) {
            $search->where('location', 'LIKE', "%{$location}%");
        }

        return $search->get()->load('profile');
    }

    /**
     * Search for jobs.
     */
    private function searchJobs(string $query, string $location = '', $budget_min = null, $budget_max = null)
    {
        $search = Job::search($query)
            ->where('status', 'open');

        if ($location) {
            $search->where('location', 'LIKE', "%{$location}%");
        }

        if ($budget_min) {
            $search->where('budget', '>=', $budget_min);
        }

        if ($budget_max) {
            $search->where('budget', '<=', $budget_max);
        }

        return $search->get()->load('client');
    }

    /**
     * API endpoint for search suggestions.
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $operators = User::search($query)
            ->where('role', 'operator')
            ->take(5)
            ->get(['id', 'name'])
            ->map(function ($user) {
                return [
                    'type' => 'operator',
                    'id' => $user->id,
                    'name' => $user->name,
                    'url' => route('profile.show', $user)
                ];
            });

        $jobs = Job::search($query)
            ->where('status', 'open')
            ->take(5)
            ->get(['id', 'title'])
            ->map(function ($job) {
                return [
                    'type' => 'job',
                    'id' => $job->id,
                    'name' => $job->title,
                    'url' => route('jobs.show', $job->id)
                ];
            });

        return response()->json($operators->concat($jobs));
    }
}