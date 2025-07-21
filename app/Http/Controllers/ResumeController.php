<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Profile;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ResumeController extends Controller
{
    public function index()
    {
        $workExperiences = Experience::where('type', 'work')
            ->where('status', 'active')
            ->get()
            ->map(function ($experience) {
                $startYear = Carbon::parse($experience->start_date)->format('Y');
                $endYear = $experience->end_date 
                    ? Carbon::parse($experience->end_date)->format('Y')
                    : 'Present';
                
                return array_merge($experience->toArray(), [
                    'formatted_start_date' => $startYear,
                    'formatted_end_date' => $endYear,
                    'is_current' => !$experience->end_date,
                    'sort_date' => $experience->end_date ?? '9999-12-31' // Use far future date for current positions
                ]);
            })
            ->sortBy([
                ['is_current', 'desc'], // Present positions first
                ['sort_date', 'desc'],  // Then by end date (most recent first)
                ['start_date', 'desc']  // If same end date, sort by start date
            ])
            ->values(); // Reset array keys after sorting

        $educationExperiences = Experience::where('type', 'education')
            ->where('status', 'active')
            ->get()
            ->map(function ($experience) {
                $startYear = Carbon::parse($experience->start_date)->format('Y');
                $endYear = $experience->end_date 
                    ? Carbon::parse($experience->end_date)->format('Y')
                    : 'Present';
                
                return array_merge($experience->toArray(), [
                    'formatted_start_date' => $startYear,
                    'formatted_end_date' => $endYear,
                    'is_current' => !$experience->end_date,
                    'sort_date' => $experience->end_date ?? '9999-12-31' // Use far future date for current positions
                ]);
            })
            ->sortBy([
                ['is_current', 'desc'], // Present positions first
                ['sort_date', 'desc'],  // Then by end date (most recent first)
                ['start_date', 'desc']  // If same end date, sort by start date
            ])
            ->values(); // Reset array keys after sorting

        $profile = Profile::first();

        return view('resume', compact('workExperiences', 'educationExperiences', 'profile'));
    }
} 