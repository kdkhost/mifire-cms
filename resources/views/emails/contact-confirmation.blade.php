@extends('emails.layout')

@section('title', 'Recebemos sua mensagem!')

@section('content')
    <h2 style="margin: 0 0 8px; color: #111827; font-size: 22px; font-weight: 700;">
        Recebemos sua mensagem! ✅
    </h2>
    <p style="margin: 0 0 24px; color: #6b7280; font-size: 15px; line-height: 1.6;">
        Olá <strong style="color: #111827;">{{ $contact->name }}</strong>,
    </p>

    <p style="margin: 0 0 12px; color: #374151; font-size: 15px; line-height: 1.7;">
        Agradecemos por entrar em contato conosco. Sua mensagem foi recebida com sucesso e nossa equipe já foi notificada.
    </p>

    <p style="margin: 0 0 28px; color: #374151; font-size: 15px; line-height: 1.7;">
        Retornaremos o mais breve possível, geralmente em até <strong style="color: #DC2626;">24 horas úteis</strong>.
    </p>

    {{-- Message Summary --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; border-left: 4px solid #DC2626; margin-bottom: 28px;">
        <tr>
            <td style="padding: 20px 24px;">
                <p style="margin: 0 0 4px; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                    Resumo da sua mensagem
                </p>
                <p style="margin: 0 0 8px; color: #111827; font-size: 15px; font-weight: 600;">
                    {{ $contact->subject }}
                </p>
                <p style="margin: 0; color: #374151; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{{ Str::limit($contact->message, 300) }}</p>
            </td>
        </tr>
    </table>

    {{-- Info Box --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #FEF2F2; border-radius: 8px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 16px 20px;">
                <p style="margin: 0; color: #991B1B; font-size: 13px; line-height: 1.6;">
                    💡 <strong>Dica:</strong> Se sua solicitação for urgente, entre em contato diretamente pelo nosso WhatsApp ou telefone disponíveis no site.
                </p>
            </td>
        </tr>
    </table>

    <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
        Atenciosamente,<br>
        <strong style="color: #111827;">Equipe MiFire</strong>
    </p>
@endsection
