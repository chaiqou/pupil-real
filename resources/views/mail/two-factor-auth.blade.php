<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&display=swap" rel="stylesheet"
        media="screen">
    <style>
        .body-sub {
            margin-top: 25px;
            border-top-width: 1px;
            padding-top: 25px;
            border-top-color: #EAEAEC;
            border-top-style: solid;
        }

        @media (prefers-color-scheme: dark) {

            body,
            .email-body,
            .email-body_inner,
            .email-content,
            .email-wrapper,
            .email-footer {
                background-color: #333333 !important;
                color: #fff !important;
            }

            p,
            ul,
            ol,
            blockquote,
            h1,
            h2,
            h3 {
                color: #fff !important;
            }

            .attributes_content {
                background-color: #222222 !important;
            }
        }

        @media (max-width: 600px) {
            .sm-w-11-12 {
                width: 91.666667% !important;
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark-h-fit {
                height: fit-content !important;
            }

            .dark-h-0 {
                height: 0 !important;
            }
        }
    </style>
</head>

<body class="page_bodyClass"
    style="word-break: break-word; -webkit-font-smoothing: antialiased; margin: 0; width: 100%; padding: 0">
    <div role="article" aria-roledescription="email" aria-label="" lang="en">
        <table class="email-wrapper"
            style="width: 100%; background-color: #F2F4F6; font-family: 'Nunito Sans', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif"
            cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td>
                    <table class="email-content" style="width: 100%" cellpadding="0" cellspacing="0"
                        role="presentation">
                        <tr>
                            <td align="center">
                                <table style="width: 75%; max-width: 300px" cellpadding="0" cellspacing="0"
                                    role="presentation">
                                    <tr>
                                        <td align="center" style="padding: 15px; vertical-align: top" valign="top">
                                            <a href="https://pupilpay.hu" target="_blank">
                                                <img class="dark-h-fit"
                                                    src="https://pupilpay.hu/resc/img/pupilpay-white-white.png"
                                                    alt="PupilPay" style="height: 0">
                                                <img class="dark-h-0"
                                                    src="https://pupilpay.hu/resc/img/pupilpay-black-color.png"
                                                    alt="PupilPay" style="height: fit-content">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="email-body" style="width: 100%">
                                <table class="email-body_inner sm-w-11-12"
                                    style="margin-left: auto; margin-right: auto; width: 570px; border-radius: 6px; background-color: #fff"
                                    cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td style="padding: 45px">
                                            <div style="font-size: 16px">
                                                <h1
                                                    style="margin-top: 0; text-align: left; font-size: 24px; font-weight: 700; color: #333333">
                                                    Hi {{ $name }},</h1>
                                                <p
                                                    style="margin-top: 6px; margin-bottom: 21px; font-size: 16px; line-height: 24px; color: #51545E">
                                                    You recently logged in to your PupilPay account. As your account has
                                                    strong security enabled, you will have to <strong>enter the code
                                                        below to log in.</strong></p>
                                                <table style="margin-bottom: 21px; width: 100%" cellpadding="0"
                                                    cellspacing="0" role="presentation">
                                                    <tr style="display: grid; justify-content: center">
                                                        <td align="center" class="attributes_content">
                                                            <table
                                                                style="width: fit-content; background-color: #F4F4F7; padding: 16px"
                                                                cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <td align="center"
                                                                        style="text-align: center; font-family: ui-monospace, Menlo, Consolas, monospace; font-size: 30px; font-weight: 700; letter-spacing: .3em; color: #374151">
                                                                        {{ $code }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <p
                                                    style="margin-top: 6px; margin-bottom: 5px; font-size: 16px; line-height: 24px; color: #51545E">
                                                    This request was received from an {{ $operating_system }}
                                                    device using {{ $browser_name }}.
                                                    If you did not try logging in, consider updating your password or <a
                                                        target="_blank" href="https://pupilpay.hu/elérhetőségek/"
                                                        style="color: #3869D4">contact support</a> if you have
                                                    questions.
                                                </p>
                                                <p
                                                    style="margin-top: 6px; margin-bottom: 5px; font-size: 16px; line-height: 24px; color: #51545E">
                                                    Thanks,
                                                    <br>The PupilPay Team
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table align="center" class="email-footer"
                                    style="margin-left: auto; margin-right: auto; width: 570px; text-align: center"
                                    cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td align="center" style="padding: 45px; font-size: 16px">
                                            <p
                                                style="margin-top: 6px; margin-bottom: 20px; text-align: center; font-size: 12px; line-height: 24px; color: #A8AAAF">
                                                &copy; {{ replace . year }} PupilPay. All rights reserved.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
