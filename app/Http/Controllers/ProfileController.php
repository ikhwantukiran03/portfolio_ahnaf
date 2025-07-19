<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::latest()->paginate(10);
        return view('admin.profile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profile.create');
    }

    /**
     * Display the image for a profile
     */
    public function showImage(Profile $profile)
    {
        if (!$profile->hasImage()) {
            abort(404);
        }

        return response($profile->image)
            ->header('Content-Type', $profile->image_mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $profile->image_original_name . '"');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'description']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = file_get_contents($image->getRealPath());
            $data['image_mime_type'] = $image->getMimeType();
            $data['image_original_name'] = $image->getClientOriginalName();
        }

        Profile::create($data);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return view('admin.profile.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        return view('admin.profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'description']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = file_get_contents($image->getRealPath());
            $data['image_mime_type'] = $image->getMimeType();
            $data['image_original_name'] = $image->getClientOriginalName();
        } elseif ($request->has('remove_image')) {
            // Remove image if checkbox is checked
            $data['image'] = null;
            $data['image_mime_type'] = null;
            $data['image_original_name'] = null;
        }

        $profile->update($data);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }
}