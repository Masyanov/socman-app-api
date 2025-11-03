<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Спасибо за заявку</title>
    <style>
        /* General resets */
        body { margin:0; padding:0; background-color:#0b1220; -webkit-font-smoothing:antialiased; }
        table { border-collapse:collapse; }
        img { border:0; display:block; }

        /* Responsive */
        @media only screen and (max-width:600px) {
            .container { width:100% !important; padding:20px !important; }
            .two-col { display:block !important; width:100% !important; }
            .col { display:block !important; width:100% !important; }
            .hero-title { font-size:28px !important; line-height:34px !important; text-align:left !important; }
            .cta { width:100% !important; box-sizing:border-box; }
            .screenshot { display:none !important; }
        }
    </style>
</head>
<body>
<!-- main wrapper -->
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" aria-hidden="true">
    <tr>
        <td align="center" style="padding:40px 16px;background:linear-gradient(180deg,#07101a 0,#0b1220 100%);">
            <!-- container -->
            <table class="container" width="680" cellpadding="0" cellspacing="0" role="presentation" style="width:680px; max-width:680px; background:transparent;">
                <tr>
                    <td style="padding:20px 0;">
                        <!-- hero block -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:18px;">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <!-- left column: title + text + CTA -->
                                            <td class="col" valign="middle" style="width:50%; padding:28px 24px 28px 0; color:#fff;">
                                                <!-- big title -->
                                                <div class="hero-title" style="font-family:Helvetica,Arial,sans-serif; font-weight:700; font-size:36px; line-height:42px; color:#ffffff; margin-bottom:12px;">
                                                    Управляй спортивной командой с<br>
                                                    <span>SportControl</span>
                                                </div>

                                                <!-- short description -->
                                                <p style="margin:0 0 18px 0; font-family:Helvetica,Arial,sans-serif; color:#9aa6bb; font-size:14px; line-height:20px; max-width:320px;">
                                                    Спасибо за заявку — ваша подписка: <strong style="color:#ffffff;">{{ $order->subscription_type }}</strong>.
                                                    Зарегистрируйтесь, чтобы начать пользоваться приложением и управлять командой прямо сейчас.
                                                </p>

                                                <!-- CTA button -->
                                                <table cellpadding="0" cellspacing="0" role="presentation" style="margin-top:18px;">
                                                    <tr>
                                                        <td align="left">
                                                            <a href="https://load-control.ru/register" target="_blank"
                                                               class="cta"
                                                               style="display:inline-block; padding:12px 18px; background:linear-gradient(180deg,#7b6bff,#6e56ff); color:#fff; text-decoration:none; border-radius:8px; font-family:Helvetica,Arial,sans-serif; font-weight:600; font-size:15px;">
                                                                Зарегистрироваться
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <!-- support link -->
                                                <p style="margin:16px 0 0 0; font-family:Helvetica,Arial,sans-serif; color:#98a0b0; font-size:13px;">
                                                    Есть вопросы? <a href="https://t.me/masyanov" target="_blank" style="color:#9ec1ff; text-decoration:none;">Написать в Telegram</a>
                                                </p>
                                            </td>

                                            <!-- right column: screenshot card -->
                                            <td class="screenshot" valign="middle" style="width:50%; padding-left:18px;">
                                                <!-- card background to mimic site panel -->
                                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#0f1720; border-radius:12px; border:1px solid rgba(255,255,255,0.03); box-shadow:0 8px 24px rgba(2,6,23,0.6);">
                                                    <tr>
                                                        <td style="padding:12px;">
                                                            <!-- image: use embedded screenshot or fallback asset -->
                                                            <img src="https://load-control.ru/images/screen.jpg"
                                                                 alt="App preview" style="width:100%; border-radius:8px; display:block;">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- main message box (white-on-dark card) -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:22px;">
                            <tr>
                                <td align="center">
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#0b1220; border-radius:8px; border:1px solid rgba(255,255,255,0.02);">
                                        <tr>
                                            <td style="padding:18px; color:#9aa6bb; font-family:Helvetica,Arial,sans-serif; font-size:14px; line-height:20px;">
                                                <p style="margin:0 0 8px 0; color:#cfe3ff;">Здравствуйте, <strong style="color:#ffffff;">{{ $order->name }}</strong>!</p>

                                                <p style="margin:0 0 8px 0;">
                                                    Спасибо за заявку на подписку «<strong style="color:#ffffff;">{{ $order->subscription_type }}</strong>».
                                                    Теперь вы можете зарегистрироваться в системе и пользоваться приложением.
                                                </p>

                                                <p style="margin:0 0 12px 0;">
                                                    <a href="https://load-control.ru/register" target="_blank" style="color:#9ec1ff; text-decoration:none;">ЗАРЕГИСТРИРОВАТЬСЯ</a>
                                                </p>

                                                <p style="margin:0;">
                                                    Если у вас остались вопросы — напишите в поддержку:
                                                    <a href="https://t.me/masyanov" target="_blank" style="color:#9ec1ff; text-decoration:none;">Написать в телеграм</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- footer -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:20px;">
                            <tr>
                                <td align="center" style="color:#5f6b7a; font-family:Helvetica,Arial,sans-serif; font-size:12px;">
                                    © {{ date('Y') }} SportControl — Все права защищены<br>
                                    <a href="https://load-control.ru" target="_blank" style="color:#4f9eff; text-decoration:none;">load-control.ru</a>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
            <!-- /container -->
        </td>
    </tr>
</table>
</body>
</html>
