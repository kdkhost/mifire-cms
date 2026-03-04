@extends('emails.layout')

@section('title', 'Bem-vindo ao MiFire CMS')

@section('content')
    {{-- Badge --}}
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
        <tr>
            <td style="background-color: #FEF2F2; color: #DC2626; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                🎉 Novo Acesso
            </td>
        </tr>
    </table>

    <h2 style="margin: 0 0 8px; color: #111827; font-size: 22px; font-weight: 700;">
        Bem-vindo ao MiFire CMS!
    </h2>
    <p style="margin: 0 0 24px; color: #6b7280; font-size: 15px; line-height: 1.6;">
        Olá <strong style="color: #111827;">{{ $user->name }}</strong>, sua conta de administrador foi criada com sucesso.
    </p>

    <p style="margin: 0 0 28px; color: #374151; font-size: 15px; line-height: 1.7;">
        Abaixo estão suas credenciais de acesso ao painel administrativo. Por segurança, recomendamos que altere sua senha no primeiro acesso.
    </p>

    {{-- Credentials Box --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 28px;">
        <tr>
            <td style="padding: 24px;">
                <p style="margin: 0 0 16px; color: #DC2626; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                    🔐 Credenciais de Acesso
                </p>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px;">E-mail:</span><br>
                            <span style="color: #111827; font-size: 15px; font-weight: 600;">{{ $user->email }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0;">
                            <span style="color: #6b7280; font-size: 13px;">Senha:</span><br>
                            <code style="background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 4px 10px; color: #111827; font-size: 15px; font-weight: 600; font-family: 'Courier New', monospace;">{{ $plainPassword }}</code>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Security Warning --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #FFFBEB; border-radius: 8px; margin-bottom: 28px;">
        <tr>
            <td style="padding: 16px 20px;">
                <p style="margin: 0; color: #92400E; font-size: 13px; line-height: 1.6;">
                    ⚠️ <strong>Importante:</strong> Por segurança, altere sua senha após o primeiro acesso. Não compartilhe estas credenciais com terceiros.
                </p>
            </td>
        </tr>
    </table>

    {{-- CTA Button --}}
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="background-color: #DC2626; border-radius: 6px;">
                <a href="{{ url('/admin') }}" target="_blank" style="display: inline-block; padding: 14px 32px; color: #ffffff; font-size: 15px; font-weight: 600; text-decoration: none;">
                    Acessar Painel Administrativo →
                </a>
            </td>
        </tr>
    </table>
@endsection
