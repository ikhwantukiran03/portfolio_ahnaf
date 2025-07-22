<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(10);
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $tags = Portfolio::TAGS;
        return view('admin.portfolios.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'client' => 'nullable|string|max:255',
            'tag' => 'required|in:' . implode(',', Portfolio::TAGS),
        ]);

        $portfolio = new Portfolio($request->except('file'));
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $portfolio->file_type = $file->getClientMimeType();
            $portfolio->portfolio_file = file_get_contents($file->getRealPath());
        }

        $portfolio->save();

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio created successfully.');
    }

    public function edit(Portfolio $portfolio)
    {
        $tags = Portfolio::TAGS;
        return view('admin.portfolios.edit', compact('portfolio', 'tags'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'client' => 'nullable|string|max:255',
            'tag' => 'required|in:' . implode(',', Portfolio::TAGS),
        ]);

        $portfolio->fill($request->except('file'));

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $portfolio->file_type = $file->getClientMimeType();
            $portfolio->portfolio_file = file_get_contents($file->getRealPath());
        }

        $portfolio->save();

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();
        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio deleted successfully.');
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