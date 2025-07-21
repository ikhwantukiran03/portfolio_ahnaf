<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Certificate;
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
                    'sort_date' => $experience->end_date ?? '9999-12-31'
                ]);
            })
            ->sortBy([
                ['is_current', 'desc'],
                ['sort_date', 'desc'],
                ['start_date', 'desc']
            ])
            ->values();

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
                    'sort_date' => $experience->end_date ?? '9999-12-31'
                ]);
            })
            ->sortBy([
                ['is_current', 'desc'],
                ['sort_date', 'desc'],
                ['start_date', 'desc']
            ])
            ->values();

        // Get all certificates - keep as objects, don't convert to array
        $certificates = Certificate::where('status', 'active')
            ->orderByDesc('year')
            ->get();

        $profile = Profile::first();

        // Debug: Add some logging to see what's happening
        \Log::info('Certificates count: ' . $certificates->count());
        \Log::info('Certificates data: ', $certificates->toArray());

        return view('resume', compact('workExperiences', 'educationExperiences', 'certificates', 'profile'));
    }
}