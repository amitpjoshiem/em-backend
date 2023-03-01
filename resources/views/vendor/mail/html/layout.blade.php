<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <style>
        table,
        td,
        div,
        h1,
        p {
            font-family: Arial, sans-serif;
        }
        p, h1{
            margin: 0;
        }
        @media only screen and (max-width: 400px) {
            img {
                max-width: 250px;
            }

            .plate {
                font-size:16px !important;
            }
        }
    </style>
</head>

<body style="margin:0;padding:0;">
<table role="presentation"
       style="max-width:650px;background:#ffffff;border-collapse:collapse;border:0;border-spacing:0; margin: 0 auto;">
    <tbody style="
    margin-left: 50px;
    margin-right: 50px;
">
    <tr>
        <td align="center" style="padding:0;">
            <table role="presentation"
                   style="text-align:left;border-collapse:collapse;border:1px solid #073763;border-spacing:0;margin-bottom: 30px;">
                <tr>
                    <td align="center" style="background:#073763;">
                        <img src="{{ asset('assets/img/SWD_horizontal.png') }}" alt="iris-logo" width="290" />
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 21px; text-align: center; padding-top: 25px;">
                        <img src="{{ asset('assets/img/IRIS_logo_standard.png') }}" alt="iris-logo" width="366" />
                    </td>
                </tr>
                <tr>
                    <td style="padding:25px 25px 25px 25px;">
                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                            {!! $slot !!}
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #282828;padding:25px 25px 25px 25px;">
                        <p style="font-size: 9px;font-style: italic; color: #ffffff; padding-bottom: 10px;">
                            Investment Advisory Serves offered througn Strategic Wealth Investment Group, LLC, a Registered Investment Adviser.
                        </p>
                        <p style="font-size: 9px;font-style: italic; color: #ffffff; padding-bottom: 10px;">
                            You are receiving this email because you have connected with Strategic Wealth Designers in the past and we fell this
                            information would be beneficial to you. If for any resson, you do not wish to receive these types of communications
                            from us in the future, you can <a href="#" style="color: #13A7FF">manage your email subscription preferences ...</a>
                        </p>
                        <p style="font-size: 9px;font-style: italic; color: #ffffff;">
                            Strategic Wealth Designers, 500 N. Hurstbourne Pkwy.. Suite 120, Louisville, KY 40222. United States
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
