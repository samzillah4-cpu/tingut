<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * Display the specified custom page.
     */
    public function show($slug)
    {
        $page = CustomPage::active()->where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('page'));
    }

    /**
     * Display the contact form.
     */
    public function showContact()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Send email to admin
        try {
            $contactEmail = config('settings.contact_email', 'admin@bytte2.no');

            Mail::raw(
                "New Contact Form Submission\n\n" .
                "Name: {$request->name}\n" .
                "Email: {$request->email}\n" .
                "Subject: {$request->subject}\n\n" .
                "Message:\n{$request->message}\n\n" .
                "Sent from: " . config('app.url'),
                function ($message) use ($request, $contactEmail) {
                    $message->to($contactEmail)
                            ->subject('New Contact Form Submission: ' . $request->subject)
                            ->replyTo($request->email, $request->name);
                }
            );

            return back()->with('success', 'Thank you for your message! We will get back to you soon.');
        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error sending your message. Please try again later.')->withInput();
        }
    }
}
