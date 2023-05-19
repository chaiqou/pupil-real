<!DOCTYPE html>
<html lang="hu" xmlns:v="urn:schemas-microsoft-com:vml">
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
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&display=swap" rel="stylesheet" media="screen">
  <style>
    @media (max-width: 600px) {
      .button {
        width: 100% !important;
        text-align: center !important;
      }
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
<body class="page_bodyClass" style="word-break: break-word; -webkit-font-smoothing: antialiased; margin: 0; width: 100%; padding: 0">
  <div role="article" aria-roledescription="email" aria-label="" lang="hu">
    <table class="email-wrapper" style="width: 100%; background-color: #F2F4F6; font-family: 'Nunito Sans', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" style="width: 100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td align="center">
                <table style="width: 75%; max-width: 300px" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td align="center" style="padding: 15px; vertical-align: top" valign="top">
                      <a href="https://pupilpay.hu" target="_blank">
                        <img class="dark-h-fit" src="https://pupilpay.hu/resc/img/pupilpay-white-white.png" alt="PupilPay" style="height: 0">
                        <img class="dark-h-0" src="https://pupilpay.hu/resc/img/pupilpay-black-color.png" alt="PupilPay" style="height: fit-content">
                      </a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td class="email-body" style="width: 100%">
                <table align="center" class="email-body_inner sm-w-11-12" style="margin-left: auto; margin-right: auto; width: 570px; border-radius: 6px; background-color: #fff" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td style="padding: 45px">
                      <div style="font-size: 16px">
                        <h1 style="margin-top: 0; text-align: left; font-size: 24px; font-weight: 700; color: #333333">Meghívást kaptál a PupilPay-hez!</h1>
                        <p style="margin-top: 6px; margin-bottom: 5px; font-size: 16px; line-height: 24px; color: #51545E">
                            A {{$invite->school->short_name}} iskolában a PupilPay-t használják az iskolai fizetések és az ebéd kezelésére!<br>
                          Használd az alábbi gombot, hogy létrehozd a fiókodat:
                        </p>
                        <table align="center" style="margin: 30px auto; width: 100%; text-align: center" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table style="width: 100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td align="center" style="font-size: 16px">
                                    <a href="{{route('merchant-setup.account', ['uniqueID' => $invite->uniqueID])}}" target="_blank" style="display: inline-block; color: #fff; text-decoration-line: none; background-color: #3869D4; border-color: #3869d4; border-style: solid; border-width: 10px 18px; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16)">Fiók létrehozása</a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p style="margin-top: 6px; margin-bottom: 5px; font-size: 16px; line-height: 24px; color: #51545E">
                          A PupilPay segítségével online tudsz fizetni és rendelni ebédet, kezelheted az egyenlegeidet, megtekintheted a tranzakcióelőzményeidet, és bármi mást elvégezhetsz, amire szükséged lehet az iskolai fizetésekkel kapcsolatban.
                          <br><strong>További információkat találhatsz rólunk a <a href="https://pupilpay.hu/">pupilpay.hu</a> oldalon!</strong><br><br>
                          Ha bármilyen kérdésed van a PupilPay-vel kapcsolatban, válaszolhatsz erre az e-mailre, és amint lehet, visszajelzünk!
                        </p>
                        <p style="margin-top: 6px; margin-bottom: 5px; font-size: 16px; line-height: 24px; color: #51545E">
                          Nagyon örülünk, ha velünk tartasz,
                          <br>A PupilPay Csapata
                        </p>
                        <table style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #eaeaec" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td>
                              <p style="margin-top: 6px; margin-bottom: 5px; font-size: 12px; line-height: 24px; color: #51545E">Ha gondod van a fenti gombbal, próbáld meg megnyitni, vagy másold és illeszd be az alábbi URL-t a webböngésződbe.</p>
                              <p style="margin-top: 6px; margin-bottom: 5px; font-size: 12px; line-height: 24px; color: #51545E"><a target="_blank" href="{{route('merchant-setup.account', ['uniqueID' => $invite->uniqueID])}}" style="color: #3869D4">{{route('merchant-setup.account', ['uniqueID' => $invite->uniqueID])}}</a></p>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table align="center" class="email-footer" style="margin-left: auto; margin-right: auto; width: 570px; text-align: center" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td align="center" style="padding: 45px; font-size: 16px">
                      <p style="margin-top: 6px; margin-bottom: 20px; text-align: center; font-size: 12px; line-height: 24px; color: #A8AAAF">&copy; {{ date('Y') }} PupilPay. Minden jog fenntartva HU.</p>
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