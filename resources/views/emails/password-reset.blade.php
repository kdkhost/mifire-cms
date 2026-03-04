@extends('emails.layout')

@section('title', 'Redefinição de Senha')

@section('content')
    <h2 style="margin: 0 0 8px; color: #111827; font-size: 22px; font-weight: 700;">
        Redefinição de Senha
    </h2>
    <p style="margin: 0 0 24px; color: #6b7280; font-size: 15px; line-height: 1.6;">
        Olá <strong style="color: #111827;">{{ $user->name }}</strong>,
    </p>

    <p style="margin: 0 0 12px; color: #374151; font-size: 15px; line-height: 1.7;">
        Recebemos uma solicitação para redefinir a senha da sua conta no <strong>MiFire CMS</strong>.
    </p>

    <p style="margin: 0 0 28px; color: #374151; font-size: 15px; line-height: 1.7;">
        Clique no botão abaixo para criar uma nova senha:
    </p>

    {{-- CTA Button --}}
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 auto 28px;">
        <tr>
            <td style="background-color: #DC2626; border-radius: 6px;">
                <a href="{{ $resetUrl }}" target="_blank" style="display: inline-block; padding: 16px 40px; color: #ffffff; font-size: 16px; font-weight: 600; text-decoration: none;">
                    🔑 Redefinir Minha Senha
                </a>
            </td>
        </tr>
    </table>

    {{-- Expiration Notice --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #FEF2F2; border-radius: 8px; margin-bottom: 28px;">
        <tr>
            <td style="padding: 16px 20px;">
                <p style="margin: 0; color: #991B1B; font-size: 13px; line-height: 1.6;">
                    ⏰ <strong>Este link expira em 60 minutos.</strong> Após esse período, será necessário solicitar uma nova redefinição de senha.
                </p>
            </td>
        </tr>
    </table>

    {{-- Fallback URL --}}
    <p style="margin: 0 0 24px; color: #6b7280; font-size: 13px; line-height: 1.6;">
        Se o botão não funcionar, copie e cole o link abaixo no seu navegador:<br>
        <a href="{{ $resetUrl }}" style="color: #DC2626; font-size: 12px; word-break: break-all; text-decoration: none;">{{ $resetUrl }}</a>
    </p>

    {{-- Disclaimer --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px;">
        <tr>
            <td style="padding: 16px 20px;">
                <p style="margin: 0; color: #6b7280; font-size: 13px; line-height: 1.6;">
                    🛡️ <strong>Não foi você?</strong> Se você não solicitou a redefinição de senha, ignore este email. Sua senha permanecerá inalterada e nenhuma ação será necessária.
                </p>
            </td>
        </tr>
    </table>
@endsection
