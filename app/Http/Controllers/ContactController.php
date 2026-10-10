<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        $profile = Profile::first();
        return view('contact', compact('profile'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $recipient = config('mail.contact_recipient.address') ?: config('mail.from.address');

        try {
            Mail::to($recipient)->send(new ContactFormMail(
                $data['name'],
                $data['email'],
                $data['subject'],
                $data['message'],
            ));
        } catch (\Throwable $e) {
            Log::error('Contact form email failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors(['send' => 'Sorry, your message could not be sent right now. Please try again later.']);
        }

        return redirect()->back()->with('success', 'Thank you for your message. I will get back to you soon!');
    }
}
