<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'MiFire')</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f5f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">

    {{-- Wrapper --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f5f7; padding: 30px 0;">
        <tr>
            <td align="center">

                {{-- Container --}}
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #DC2626; background: linear-gradient(135deg, #DC2626, #B91C1C); padding: 28px 40px; text-align: center;">
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <td style="vertical-align: middle; padding-right: 12px;">
                                        <div style="width: 42px; height: 42px; background-color: #ffffff; border-radius: 50%; text-align: center; line-height: 42px;">
                                            <span style="color: #DC2626; font-size: 20px; font-weight: 800;">🔥</span>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 1px;">MiFire</h1>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin: 8px 0 0; color: rgba(255,255,255,0.85); font-size: 13px; font-weight: 400;">Soluções de Combate a Incêndio</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px 40px 32px;">
                            @yield('content')
                        </td>
                    </tr>

                    {{-- Divider --}}
                    <tr>
                        <td style="padding: 0 40px;">
                            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 0;">
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 28px 40px; text-align: center;">
                            {{-- Company Info --}}
                            <p style="margin: 0 0 6px; color: #DC2626; font-size: 16px; font-weight: 700;">
                                MiFire - Soluções de Combate a Incêndio
                            </p>
                            <p style="margin: 0 0 16px; color: #6b7280; font-size: 13px; line-height: 1.5;">
                                {{ config('mifire.company.address', '') }}
                            </p>

                            {{-- Social Links --}}
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 auto 20px;">
                                <tr>
                                    @if(config('mifire.company.facebook'))
                                    <td style="padding: 0 6px;">
                                        <a href="{{ config('mifire.company.facebook') }}" target="_blank" style="display: inline-block; width: 32px; height: 32px; background-color: #DC2626; border-radius: 50%; text-align: center; line-height: 32px; color: #ffffff; text-decoration: none; font-size: 14px;" title="Facebook">f</a>
                                    </td>
                                    @endif
                                    @if(config('mifire.company.instagram'))
                                    <td style="padding: 0 6px;">
                                        <a href="{{ config('mifire.company.instagram') }}" target="_blank" style="display: inline-block; width: 32px; height: 32px; background-color: #DC2626; border-radius: 50%; text-align: center; line-height: 32px; color: #ffffff; text-decoration: none; font-size: 14px;" title="Instagram">ig</a>
                                    </td>
                                    @endif
                                    @if(config('mifire.company.linkedin'))
                                    <td style="padding: 0 6px;">
                                        <a href="{{ config('mifire.company.linkedin') }}" target="_blank" style="display: inline-block; width: 32px; height: 32px; background-color: #DC2626; border-radius: 50%; text-align: center; line-height: 32px; color: #ffffff; text-decoration: none; font-size: 14px;" title="LinkedIn">in</a>
                                    </td>
                                    @endif
                                    @if(config('mifire.company.youtube'))
                                    <td style="padding: 0 6px;">
                                        <a href="{{ config('mifire.company.youtube') }}" target="_blank" style="display: inline-block; width: 32px; height: 32px; background-color: #DC2626; border-radius: 50%; text-align: center; line-height: 32px; color: #ffffff; text-decoration: none; font-size: 14px;" title="YouTube">yt</a>
                                    </td>
                                    @endif
                                    @if(config('mifire.company.whatsapp'))
                                    <td style="padding: 0 6px;">
                                        <a href="https://wa.me/{{ config('mifire.company.whatsapp') }}" target="_blank" style="display: inline-block; width: 32px; height: 32px; background-color: #25D366; border-radius: 50%; text-align: center; line-height: 32px; color: #ffffff; text-decoration: none; font-size: 14px;" title="WhatsApp">wa</a>
                                    </td>
                                    @endif
                                </tr>
                            </table>

                            {{-- Developer Signature --}}
                            <p style="margin: 0; color: #9ca3af; font-size: 11px; line-height: 1.6;">
                                Este email foi enviado pelo sistema <strong>MiFire CMS</strong><br>
                                Desenvolvido por <strong>George Marcelo</strong> - <a href="https://www.kdkhost.com.br" target="_blank" style="color: #DC2626; text-decoration: none;">KDKHost Soluções</a> (www.kdkhost.com.br)
                            </p>
                        </td>
                    </tr>

                </table>
                {{-- /Container --}}

            </td>
        </tr>
    </table>
    {{-- /Wrapper --}}

</body>
</html>
