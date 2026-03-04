<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of email templates.
     */
    public function index()
    {
        $templates = EmailTemplate::orderBy('name')->get();

        return view('admin.email-templates.index', compact('templates'));
    }

    /**
     * Show the form for editing an email template.
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    /**
     * Update the specified email template.
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'subject'   => ['required', 'string', 'max:255'],
            'body'      => ['required', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $emailTemplate->update($validated);

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Template atualizado com sucesso.');
    }

    /**
     * Preview a rendered email template.
     */
    public function preview(EmailTemplate $emailTemplate)
    {
        // Build sample data from the template's declared variables
        $sampleData = [];
        if ($emailTemplate->variables) {
            foreach ($emailTemplate->variables as $variable) {
                $sampleData[$variable] = "[{$variable}]";
            }
        }

        $rendered = $emailTemplate->render($sampleData);

        return response($rendered);
    }
}
