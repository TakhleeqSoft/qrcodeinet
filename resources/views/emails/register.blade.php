@extends('emails.layout')

@section('body')
    <table style="color: #000; width: 100%;" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table style="color: #000; width: 100%;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="text-align: left; padding: 40px 30px;">

                            <h2 style="font-size: 24px; font-weight: 700;margin: 0 0 20px;text-align: left;"> Hi Admin,</h2>

                            <p> A user has reached out to you through website with the following information:</p>
                            <p style="font-size: 18px;">Name: {!! $name !!}</p>
                            <p style="font-size: 18px;">Email: {!! $email !!}</p>
                            <p style="font-size: 18px;">Message: {!! $user_message !!}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
