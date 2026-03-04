<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\EmailTemplate;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index(): View
    {
        $addresses = Address::active()->orderBy('sort_order')->get();

        return view('site.contact', compact('addresses'));
    }

    /**
     * Validate and store a contact message, then send notification emails.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contact = Contact::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        // Send notification email to admin
        $this->sendAdminNotification($contact);

        // Send confirmation email to user
        $this->sendUserConfirmation($contact);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
    }

    /**
     * Send notification email to the admin.
     */
    protected function sendAdminNotification(Contact $contact): void
    {
        $template = EmailTemplate::active()->where('slug', 'contact-notification')->first();

        if (!$template) {
            return;
        }

        $adminEmail = Setting::get('admin_email', config('mail.from.address'));
        $siteName = Setting::get('site_name', config('app.name'));

        $body = $template->render([
            'name'    => $contact->name,
            'email'   => $contact->email,
            'phone'   => $contact->phone ?? '—',
            'company' => $contact->company ?? '—',
            'subject' => $contact->subject,
            'message' => nl2br(e($contact->message)),
        ]);

        Mail::html($body, function ($mail) use ($template, $adminEmail, $contact, $siteName) {
            $mail->to($adminEmail)
                ->replyTo($contact->email, $contact->name)
                ->subject($template->subject ?: "Nova mensagem de contato – {$siteName}");
        });
    }

    /**
     * Send confirmation email to the user.
     */
    protected function sendUserConfirmation(Contact $contact): void
    {
        $template = EmailTemplate::active()->where('slug', 'contact-confirmation')->first();

        if (!$template) {
            return;
        }

        $siteName = Setting::get('site_name', config('app.name'));

        $body = $template->render([
            'name'      => $contact->name,
            'subject'   => $contact->subject,
            'site_name' => $siteName,
        ]);

        Mail::html($body, function ($mail) use ($template, $contact, $siteName) {
            $mail->to($contact->email, $contact->name)
                ->subject($template->subject ?: "Recebemos sua mensagem – {$siteName}");
        });
    }
}
