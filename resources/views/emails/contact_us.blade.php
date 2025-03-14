@extends('emails.layout')

@section('body')
    <table style="color: #000; width: 100%;" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table style="color: #000; width: 100%;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="text-align: left; padding: 40px 30px;">
                            <h2 style="font-size: 24px; font-weight: 700;margin: 0 0 20px;text-align: left;">Hello Admin,</h2>
                            <p style="font-size: 14px; line-height: 22px;margin: 0 0 20px;text-align: left;">You received an email for help.</p>

                            <hr style="margin-bottom: 20px;" />
                            <!--Login Details -->
                            <h3 style="font-size: 16px; font-weight: normal;margin: 0 0 10px;"><b>Name</b>: {{ $name }}</h3>
                            <h3 style="font-size: 16px; font-weight: normal;margin: 0 0 10px;"><b>Email</b>: {{ $email }}</h3>
                            <h3 style="font-size: 16px; font-weight: normal;margin: 0 0 10px;"><b>Message</b>: {{ $user_message }}</h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
