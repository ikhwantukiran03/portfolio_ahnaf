<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the admin's profile or show form to create one
     */
    public function show()
    {
        $profile = Profile::first(); // Get the first (and only) profile
        
        if (!$profile) {
            // If no profile exists, redirect to create
            return redirect()->route('admin.profile.create');
        }
        
        return view('admin.profile.show', compact('profile'));
    }

    /**
     * Show the form for creating the admin profile
     */
    public function create()
    {
        // Check if profile already exists
        if (Profile::exists()) {
            return redirect()->route('admin.profile.show')->with('error', 'Profile already exists. You can edit it instead.');
        }
        
        return view('admin.profile.create');
    }

    /**
     * Display the image for the admin profile
     */
    public function showImage()
    {
        $profile = Profile::first();
        
        if (!$profile || !$profile->hasImage()) {
            abort(404);
        }

        return response($profile->image)
            ->header('Content-Type', $profile->image_mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $profile->image_original_name . '"');
    }

    /**
     * Store the newly created admin profile
     */
    public function store(Request $request)
    {
        // Ensure only one profile can be created
        if (Profile::exists()) {
            return redirect()->route('admin.profile.show')->with('error', 'Profile already exists.');
        }
        
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

        return redirect()->route('admin.profile.show')->with('success', 'Profile created successfully.');
    }

    /**
     * Show the form for editing the admin profile
     */
    public function edit()
    {
        $profile = Profile::first();
        
        if (!$profile) {
            return redirect()->route('admin.profile.create');
        }
        
        return view('admin.profile.edit', compact('profile'));
    }

    /**
     * Update the admin profile
     */
    public function update(Request $request)
    {
        $profile = Profile::first();
        
        if (!$profile) {
            return redirect()->route('admin.profile.create');
        }
        
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

        return redirect()->route('admin.profile.show')->with('success', 'Profile updated successfully.');
    }
}