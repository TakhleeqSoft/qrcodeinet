<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;700&display=swap" rel="stylesheet">
    <title>{{config('app.name')}}</title>
</head>
<body style="margin: 0;background-color: #f9f9f9;">
<table style="font-family: 'Mulish', sans-serif; max-width: 600px; width: 100%;margin: 0 auto; color: #000;" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: center; padding: 25px 15px; background-color: #25303d;">
            <a href="{{url('')}}" title="{{config('app.name')}}">
                <img src="{{URL::asset(config('app.dark_sm_logo'))}}" alt="" style="height: 60px; margin: 0 auto;">
            </a>
        </td>
    </tr>
    <tr>
        <td style="background-color: #fff;">
            @yield('body')
        </td>
    </tr>
    <tr>
        <td style="padding: 20px;">
            <table style="color: #000; width: 100%;" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="text-align: center;">
                        <p style="font-size: 12px; line-height: 22px;">{{trans('system.email_messages.email_bottom_content')}} {{config('app.name')}}.© {{date('Y')}}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
