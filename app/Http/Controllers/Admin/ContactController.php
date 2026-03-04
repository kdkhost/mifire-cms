<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->has('is_read')) {
            $query->where('is_read', $request->boolean('is_read'));
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->latest()->paginate(20)->withQueryString();

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Display a single contact (marks as read).
     */
    public function show(Contact $contact)
    {
        $contact->markAsRead();

        $templates = EmailTemplate::active()->get();

        return view('admin.contacts.show', compact('contact', 'templates'));
    }

    /**
     * Send a reply to the contact.
     */
    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'subject'     => ['required', 'string', 'max:255'],
            'message'     => ['required', 'string'],
            'template_id' => ['nullable', 'exists:email_templates,id'],
        ]);

        $body = $validated['message'];

        // If a template was selected, render it with contact data
        if (! empty($validated['template_id'])) {
            $template = EmailTemplate::findOrFail($validated['template_id']);
            $body = $template->render([
                'name'    => $contact->name,
                'email'   => $contact->email,
                'message' => $validated['message'],
            ]);
        }

        Mail::html($body, function ($mail) use ($contact, $validated) {
            $mail->to($contact->email, $contact->name)
                 ->subject($validated['subject']);
        });

        $contact->update(['replied_at' => now()]);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Resposta enviada com sucesso.');
    }

    /**
     * Remove the specified contact.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contato excluído com sucesso.');
    }

    /**
     * Export contacts to CSV.
     */
    public function export(Request $request)
    {
        $contacts = Contact::latest()->get();

        $filename = 'contatos_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($contacts) {
            $file = fopen('php://output', 'w');
            // BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['ID', 'Nome', 'E-mail', 'Telefone', 'Empresa', 'Assunto', 'Mensagem', 'Lido', 'Respondido em', 'Data']);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->name,
                    $contact->email,
                    $contact->phone,
                    $contact->company,
                    $contact->subject,
                    $contact->message,
                    $contact->is_read ? 'Sim' : 'Não',
                    $contact->replied_at?->format('d/m/Y H:i'),
                    $contact->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
