@extends('emails.layout')

@section('title', 'Nova mensagem de contato')

@section('content')
    {{-- Badge --}}
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
        <tr>
            <td style="background-color: #FEF2F2; color: #DC2626; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                📩 Nova Mensagem
            </td>
        </tr>
    </table>

    <h2 style="margin: 0 0 8px; color: #111827; font-size: 22px; font-weight: 700;">
        Nova mensagem de contato recebida
    </h2>
    <p style="margin: 0 0 28px; color: #6b7280; font-size: 15px; line-height: 1.6;">
        Uma nova mensagem foi enviada através do formulário de contato do site.
    </p>

    {{-- Contact Details Table --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; margin-bottom: 28px;">
        <tr>
            <td style="padding: 24px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Nome</span><br>
                            <span style="color: #111827; font-size: 15px; font-weight: 500;">{{ $contact->name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">E-mail</span><br>
                            <a href="mailto:{{ $contact->email }}" style="color: #DC2626; font-size: 15px; text-decoration: none;">{{ $contact->email }}</a>
                        </td>
                    </tr>
                    @if($contact->phone)
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Telefone</span><br>
                            <span style="color: #111827; font-size: 15px;">{{ $contact->phone }}</span>
                        </td>
                    </tr>
                    @endif
                    @if($contact->company)
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Empresa</span><br>
                            <span style="color: #111827; font-size: 15px;">{{ $contact->company }}</span>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Assunto</span><br>
                            <span style="color: #111827; font-size: 15px; font-weight: 500;">{{ $contact->subject }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Mensagem</span><br>
                            <p style="margin: 6px 0 0; color: #374151; font-size: 15px; line-height: 1.7; white-space: pre-wrap;">{{ $contact->message }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Metadata --}}
    <p style="margin: 0 0 24px; color: #9ca3af; font-size: 12px;">
        Recebido em {{ $contact->created_at->format('d/m/Y \à\s H:i') }} | IP: {{ $contact->ip_address ?? 'N/A' }}
    </p>

    {{-- CTA Button --}}
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="background-color: #DC2626; border-radius: 6px;">
                <a href="{{ url('/admin/contacts/' . $contact->id) }}" target="_blank" style="display: inline-block; padding: 14px 32px; color: #ffffff; font-size: 15px; font-weight: 600; text-decoration: none;">
                    Responder Mensagem →
                </a>
            </td>
        </tr>
    </table>
@endsection
