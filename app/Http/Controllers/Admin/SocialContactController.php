<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialContact;
use Illuminate\Http\Request;

class SocialContactController extends Controller
{
    /**
     * Display a listing of social contacts
     */
    public function index()
    {
        $contacts = SocialContact::ordered()->get()->groupBy('effective_type');
        $contactTypes = SocialContact::getContactTypes();
        
        return view('admin.social-contacts.index', compact('contacts', 'contactTypes'));
    }

    /**
     * Show the form for creating a new social contact
     */
    public function create()
    {
        $contactTypes = SocialContact::getContactTypes();
        return view('admin.social-contacts.create', compact('contactTypes'));
    }

    /**
     * Store a newly created social contact
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(SocialContact::getContactTypes())),
            'custom_type' => 'required_if:type,other|nullable|string|max:50',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_primary' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        // Validate email format for email type
        if ($request->type === 'email') {
            $request->validate([
                'value' => 'email'
            ]);
        }

        // Validate URL format for social media types and 'other' type
        $urlTypes = ['linkedin', 'github', 'twitter', 'facebook', 'instagram', 'website', 'behance', 'dribbble', 'youtube'];
        if (in_array($request->type, $urlTypes) || ($request->type === 'other' && filter_var($request->value, FILTER_VALIDATE_URL))) {
            $request->validate([
                'value' => 'url'
            ], [
                'value.url' => 'Please enter a valid URL (e.g., https://example.com)'
            ]);
        }

        $data = $request->all();
        
        // Set default icon if not provided
        if (!$data['icon']) {
            $contactTypes = SocialContact::getContactTypes();
            $data['icon'] = $contactTypes[$request->type]['icon'];
        }

        SocialContact::create($data);

        return redirect()->route('admin.social-contacts.index')
            ->with('success', 'Social contact created successfully.');
    }

    /**
     * Show the form for editing the specified social contact
     */
    public function edit(SocialContact $socialContact)
    {
        $contactTypes = SocialContact::getContactTypes();
        return view('admin.social-contacts.edit', compact('socialContact', 'contactTypes'));
    }

    /**
     * Update the specified social contact
     */
    public function update(Request $request, SocialContact $socialContact)
    {
        $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(SocialContact::getContactTypes())),
            'custom_type' => 'required_if:type,other|nullable|string|max:50',
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_primary' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        // Validate email format for email type
        if ($request->type === 'email') {
            $request->validate([
                'value' => 'email'
            ]);
        }

        // Validate URL format for social media types and 'other' type
        $urlTypes = ['linkedin', 'github', 'twitter', 'facebook', 'instagram', 'website', 'behance', 'dribbble', 'youtube'];
        if (in_array($request->type, $urlTypes) || ($request->type === 'other' && filter_var($request->value, FILTER_VALIDATE_URL))) {
            $request->validate([
                'value' => 'url'
            ], [
                'value.url' => 'Please enter a valid URL (e.g., https://example.com)'
            ]);
        }

        $data = $request->all();
        
        // Set default icon if not provided
        if (!$data['icon']) {
            $contactTypes = SocialContact::getContactTypes();
            $data['icon'] = $contactTypes[$request->type]['icon'];
        }

        $socialContact->update($data);

        return redirect()->route('admin.social-contacts.index')
            ->with('success', 'Social contact updated successfully.');
    }

    /**
     * Remove the specified social contact
     */
    public function destroy(SocialContact $socialContact)
    {
        $socialContact->delete();

        return redirect()->route('admin.social-contacts.index')
            ->with('success', 'Social contact deleted successfully.');
    }

    /**
     * Update the order of social contacts
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'contacts.*' => 'required|integer|exists:social_contacts,id'
        ]);

        foreach ($request->contacts as $index => $id) {
            SocialContact::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

    /**
     * Toggle primary status
     */
    public function togglePrimary(SocialContact $socialContact)
    {
        $socialContact->update(['is_primary' => !$socialContact->is_primary]);

        return redirect()->route('admin.social-contacts.index')
            ->with('success', 'Primary status updated successfully.');
    }

    /**
     * Toggle public visibility
     */
    public function togglePublic(SocialContact $socialContact)
    {
        $socialContact->update(['is_public' => !$socialContact->is_public]);

        return redirect()->route('admin.social-contacts.index')
            ->with('success', 'Visibility updated successfully.');
    }

    /**
     * Get public contacts for frontend display
     */
    public function getPublicContacts()
    {
        $contacts = SocialContact::active()
            ->public()
            ->ordered()
            ->get()
            ->groupBy('type');

        return response()->json($contacts);
    }
}