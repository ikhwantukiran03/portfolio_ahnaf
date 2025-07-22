<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Profile;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $selectedTag = $request->get('tag');
        
        $query = Portfolio::query();
        
        if ($selectedTag) {
            $query->where('tag', $selectedTag);
        }
        
        $portfolios = $query->latest()->get();
        $tags = Portfolio::TAGS;
        $profile = Profile::first();
        
        return view('portfolio', compact('portfolios', 'tags', 'selectedTag', 'profile'));
    }

    public function showFile(Portfolio $portfolio)
    {
        if (!$portfolio->portfolio_file) {
            abort(404);
        }

        $headers = [
            'Content-Type' => $portfolio->file_type,
            'Content-Disposition' => 'inline; filename="portfolio.' . ($portfolio->file_type === 'application/pdf' ? 'pdf' : 'jpg') . '"'
        ];

        return response($portfolio->portfolio_file, 200, $headers);
    }
} 