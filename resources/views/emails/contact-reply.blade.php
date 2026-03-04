@extends('emails.layout')

@section('title', 'Resposta à sua mensagem')

@section('content')
    <h2 style="margin: 0 0 8px; color: #111827; font-size: 22px; font-weight: 700;">
        Respondemos sua mensagem
    </h2>
    <p style="margin: 0 0 28px; color: #6b7280; font-size: 15px; line-height: 1.6;">
        Olá <strong style="color: #111827;">{{ $contact->name }}</strong>, segue nossa resposta ao seu contato:
    </p>

    {{-- Reply Content --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f0fdf4; border-radius: 8px; border-left: 4px solid #16a34a; margin-bottom: 28px;">
        <tr>
            <td style="padding: 24px;">
                <p style="margin: 0 0 6px; color: #15803d; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                    Nossa Resposta
                </p>
                <div style="margin: 0; color: #374151; font-size: 15px; line-height: 1.7;">{!! nl2br(e($replyText)) !!}</div>
            </td>
        </tr>
    </table>

    {{-- Original Message --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; border-left: 4px solid #d1d5db; margin-bottom: 28px;">
        <tr>
            <td style="padding: 20px 24px;">
                <p style="margin: 0 0 4px; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                    Sua mensagem original
                </p>
                <p style="margin: 0 0 6px; color: #6b7280; font-size: 12px;">
                    Enviada em {{ $contact->created_at->format('d/m/Y \à\s H:i') }}
                </p>
                <p style="margin: 0 0 4px; color: #111827; font-size: 14px; font-weight: 600;">
                    {{ $contact->subject }}
                </p>
                <p style="margin: 0; color: #4b5563; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{{ $contact->message }}</p>
            </td>
        </tr>
    </table>

    {{-- Info --}}
    <p style="margin: 0 0 20px; color: #6b7280; font-size: 14px; line-height: 1.6;">
        Caso precise de mais informações ou tenha outras dúvidas, não hesite em nos contatar novamente respondendo a este email ou através do nosso site.
    </p>

    <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
        Atenciosamente,<br>
        <strong style="color: #111827;">Equipe MiFire</strong>
    </p>
@endsection
