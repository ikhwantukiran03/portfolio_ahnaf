<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::ordered()->get();
        return view('admin.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'status' => 'required|in:active,inactive'
        ]);

        $certificate = new Certificate($request->except('certificate_file'));
        
        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            $certificate->file_type = $file->getClientMimeType();
            // Read file contents as binary
            $certificate->certificate_file = file_get_contents($file->getRealPath());
        }

        $certificate->save();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate created successfully.');
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'status' => 'required|in:active,inactive'
        ]);

        $certificate->fill($request->except('certificate_file'));

        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            $certificate->file_type = $file->getClientMimeType();
            // Read file contents as binary
            $certificate->certificate_file = file_get_contents($file->getRealPath());
        }

        $certificate->save();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'certificates' => 'required|array',
            'certificates.*' => 'exists:certificates,id'
        ]);

        foreach ($request->certificates as $index => $id) {
            Certificate::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

    public function showFile(Certificate $certificate)
    {
        if (!$certificate->certificate_file) {
            abort(404);
        }

        $headers = [
            'Content-Type' => $certificate->file_type,
            'Content-Disposition' => 'inline; filename="certificate.' . ($certificate->file_type === 'application/pdf' ? 'pdf' : 'jpg') . '"'
        ];

        return response($certificate->certificate_file, 200, $headers);
    }
} 