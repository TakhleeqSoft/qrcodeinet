@php
    $languages_array = getAllLanguages(true)
@endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <title>{{__('system.environment.menu')}} | {{ config('app.name') }}</title>
    @php
        function adjustBrightness($hex, $steps) {
            // Steps should be between -255 (darker) and 255 (lighter)
            $steps = max(-255, min(255, $steps));

            // Remove `#` if it exists
            $hex = str_replace('#', '', $hex);

            // Convert to RGB
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            // Adjust brightness
            $r = max(0, min(255, $r + $steps));
            $g = max(0, min(255, $g + $steps));
            $b = max(0, min(255, $b + $steps));

            // Convert back to hex
            return sprintf("#%02X%02X%02X", $r, $g, $b);
        }

        $hoverColor = adjustBrightness($restaurant->button_color, -30);
    @endphp
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
        }

        .content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .language-bar {
            width: 100%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .language-bar .container-fluid {
            padding: 0;
        }
        
        .language-bar a {
            flex: 1;
            text-align: center;
            padding: 0px;
            background: {{$restaurant->button_color}};
            color: white;
            font-size: 16px;
            text-decoration: none;
        }

        .language-bar a:hover {
            background: {{$hoverColor}};
            color: white;
        }

        .footer-icons{
            position: absolute;
            bottom: 5%;
        }
        @media only screen and (max-width: 600px) {
          .footer-icons{
               bottom: 15%;
          }
        }
        .footer-icons .icon{
            display: flex;
            gap: 15px;
        }

        .footer-icons .icon a {
            background: {{$restaurant->button_color}};
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            width: 35px;
            height: 35px;
        }
        .footer-icons .icon a:hover{
            background: {{$hoverColor}};
        }

        .feedback-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: {{$restaurant->button_color}};
            padding: 10px 15px;
            border-radius: 20px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .feedback-button:hover {
            color: #fff;
            background: {{$hoverColor}};
        }
        #exampleModal .modal-content {
            background: {{$hoverColor}};
            color: #fff
        }

        #exampleModal .card .card-body {
            background: {{$restaurant->button_color}};
            color: #fff;
            border: 1.5px solid #fff;
            border-radius: 4px;
        }

        .rate {
            border-bottom-right-radius: 12px;
            border-bottom-left-radius: 12px
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center
        }

        .rating > input {
            display: none
        }

        .rating > label {
            position: relative;
            width: 1em;
            font-size: 30px;
            font-weight: 300;
            color: #FFD600;
            cursor: pointer
        }

        .rating > label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .rating > label:hover:before,
        .rating > label:hover ~ label:before {
            opacity: 1 !important
        }

        .rating > input:checked ~ label:before {
            opacity: 1
        }

        .rating:hover > input:checked ~ label:before {
            opacity: 0.4
        }

        .buttons {
            top: 36px;
            position: relative
        }

        .rating-submit {
            border-radius: 8px;
            color: #fff;
            height: auto
        }

        .rating-submit:hover {
            color: #fff
        }

    </style>
</head>
<body>
@php
    $videoUrl = asset('assets/default.mp4');
    if (!empty($restaurant->default_video)) {
//        if (file_exists('storage/' . $restaurant->default_video)) {
//
//        }
            $videoUrl = asset('storage/' . $restaurant->default_video);
    }
@endphp
<div class="video-container">
    <video autoplay muted loop playsinline >
        <source src="{{$videoUrl}}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
<div class="overlay"></div>

<div class="content">
    <div class="language-bar">
        <div class="container-fluid">
            <div class="row mx-lg-5 mx-2">
                @php
                    $i = 0;
                @endphp
                @forelse($languages_array as $key => $lang)
                    <div class="col-6 text-center mb-3">
                        <a class="btn w-100" href="{{route('frontend.restaurant.language-change',['restaurant'=>$restaurant->slug,'lang'=>$key])}}">{{$lang}}</a>
                    </div>
                    @php
                        $i++;
                    @endphp
                @empty
                @endforelse
            </div>
        </div>
    </div>

    <div class="footer-icons">
        <div class="icon">
            @if(!empty($restaurant->facebook_url))
                @php
                    $facebookUrl = $restaurant->facebook_url;
                    if (!str_starts_with($facebookUrl, 'https://')) {
                        $facebookUrl = 'https://' . $facebookUrl;
                    }
                @endphp
                <a target="_blank" href="{{ $facebookUrl }}" class="text-white"><i class="bi bi-facebook"></i></a>
            @endif

            @if(!empty($restaurant->instagram_url))
                @php
                    $instagramUrl = $restaurant->instagram_url;
                    if (!str_starts_with($instagramUrl, 'https://')) {
                        $instagramUrl = 'https://' . $instagramUrl;
                    }
                @endphp
                <a target="_blank" href="{{ $instagramUrl }}" class="text-white"><i class="bi bi-instagram"></i></a>
            @endif

            @if(!empty($restaurant->twitter_url))
                @php
                    $twitterUrl = $restaurant->twitter_url;
                    if (!str_starts_with($twitterUrl, 'https://')) {
                        $twitterUrl = 'https://' . $twitterUrl;
                    }
                @endphp
                <a target="_blank" href="{{ $twitterUrl }}" class="text-white"><i class="bi bi-twitter"></i></a>
            @endif

            @if(!empty($restaurant->tiktok_url))
                @php
                    $tiktokUrl = $restaurant->tiktok_url;
                    if (!str_starts_with($tiktokUrl, 'https://')) {
                        $tiktokUrl = 'https://' . $tiktokUrl;
                    }
                @endphp
                <a target="_blank" href="{{ $tiktokUrl }}" class="text-white"><i class="bi bi-tiktok"></i></a>
            @endif
            @if(!empty($restaurant->snapchat_url))
                @php
                    $snapchatUrl = $restaurant->snapchat_url;
                    if (!str_starts_with($snapchatUrl, 'https://')) {
                        $snapchatUrl = 'https://' . $snapchatUrl;
                    }
                @endphp
                <a target="_blank" href="{{ $snapchatUrl }}" class="text-white"><i class="bi bi-snapchat"></i></a>
            @endif
            @if(!empty($restaurant->map_url))
                @php
                    $mapUrl = $restaurant->map_url;
                    if (!str_starts_with($mapUrl, 'https://')) {
                        $mapUrl = 'https://' . $mapUrl;
                    }
                @endphp
                <a target="_blank" href="{{ $mapUrl }}" class="text-white"><i class="bi bi-geo-alt"></i></a>
            @endif
        </div>
        <div style="display: flex;margin-top: 10px;gap: 20px;align-items: center;justify-content: center">
            <p style="color: gray;font-size: small;margin: 0">Powered by</p>
            <div>
                <a target="_blank" href="{{url('/')}}">
                    <img style="width: 30px;height: auto" src="{{ asset(config('app.dark_sm_logo')) }}" alt="">
                </a>
            </div>
        </div>
    </div>

    <a href="#" class="feedback-button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
            class="bi bi-chat-dots"></i> {{__('custom.feedback')}}</a>
</div>
<div class="modal fade" id="exampleModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" style="border: none">
                <a href="#" data-bs-dismiss="modal" aria-label="Close" style="font-size: 30px;color: #fff"><i
                        class="bi bi-arrow-left"></i></a>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h2 class="text-white">{{__('custom.feedback')}}</h2>
                    <hr>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="text-white">{{__('custom.Staff')}}</h3>
                            <hr>
                            <div class=" d-flex justify-content-center ">
                                <div class=" text-center">
                                    <div class="rating">
                                        <input type="radio" name="staff" value="5" id="staff-5">
                                        <label for="staff-5">☆</label>
                                        <input type="radio" name="staff" value="4" id="staff-4" checked>
                                        <label for="staff-4">☆</label>
                                        <input type="radio" name="staff" value="3" id="staff-3">
                                        <label for="staff-3">☆</label>
                                        <input type="radio" name="staff" value="2" id="staff-2">
                                        <label for="staff-2">☆</label>
                                        <input type="radio" name="staff" value="1" id="staff-1">
                                        <label for="staff-1">☆</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="text-white">{{__('custom.Service')}}</h3>
                            <hr>
                            <div class=" d-flex justify-content-center">
                                <div class=" text-center">
                                    <div class="rating">
                                        <input type="radio" name="service" value="5" id="service-5">
                                        <label for="service-5">☆</label>
                                        <input type="radio" name="service" value="4" id="service-4" checked>
                                        <label for="service-4">☆</label>
                                        <input type="radio" name="service" value="3" id="service-3">
                                        <label for="service-3">☆</label>
                                        <input type="radio" name="service" value="2" id="service-2">
                                        <label for="service-2">☆</label>
                                        <input type="radio" name="service" value="1" id="service-1">
                                        <label for="service-1">☆</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="text-white">{{__('custom.Hygiene')}}</h3>
                            <hr>
                            <div class=" d-flex justify-content-center">
                                <div class=" text-center">
                                    <div class="rating">
                                        <input type="radio" name="hygiene" value="5" id="hygiene-5">
                                        <label for="hygiene-5">☆</label>
                                        <input type="radio" name="hygiene" value="4" id="hygiene-4" checked>
                                        <label for="hygiene-4">☆</label>
                                        <input type="radio" name="hygiene" value="3" id="hygiene-3">
                                        <label for="hygiene-3">☆</label>
                                        <input type="radio" name="hygiene" value="2" id="hygiene-2">
                                        <label for="hygiene-2">☆</label>
                                        <input type="radio" name="hygiene" value="1" id="hygiene-1">
                                        <label for="hygiene-1">☆</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="text-white">{{__('custom.How was overall experience?')}}</h3>
                            <hr>
                            <div class=" d-flex justify-content-center">
                                <div class=" text-center">
                                    <div class="rating">
                                        <input type="radio" name="overall" value="5" id="overall-5">
                                        <label for="overall-5">☆</label>
                                        <input type="radio" name="overall" value="4" id="overall-4" checked>
                                        <label for="overall-4">☆</label>
                                        <input type="radio" name="overall" value="3" id="overall-3">
                                        <label for="overall-3">☆</label>
                                        <input type="radio" name="overall" value="2" id="overall-2" >
                                        <label for="overall-2">☆</label>
                                        <input type="radio" name="overall" value="1" id="overall-1">
                                        <label for="overall-1">☆</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="text-white">{{__('custom.Contact')}}</h3>
                            <hr>
                            <input type="text" id="phone-number" style="text-align: center;background: transparent;border: none;height: 50px;color: #fff" class="form-control" placeholder="{{__('custom.Phone number')}}">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="text-white">{{__('custom.Any additional comment?')}}</h3>
                            <hr>
                            <input type="text" style="text-align: center;background: transparent;border: none;height: 50px;color: #fff" class="form-control" placeholder="{{__('custom.Click here to type comment')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border: none">
                <button class="btn w-100" id="send" style="background: {{$restaurant->button_color}};color: #fff">{{__('custom.Send')}}</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function (){
        $("#phone-number").on("keypress", function (event) {
            let char = String.fromCharCode(event.which);
            let value = $(this).val();

            // Allow numbers (0-9) and only one '+' at the beginning
            if (!/^[0-9+]$/.test(char) || (char === "+" && value.length > 0)) {
                event.preventDefault();
            }
        });

        $("#phone-number").on("paste", function (event) {
            event.preventDefault(); // Prevent pasting non-numeric characters
        });

        $('#send').click(function (){
            let staff = $('input[name="staff"]:checked').val();
            let service = $('input[name="service"]:checked').val();
            let hygiene = $('input[name="hygiene"]:checked').val();
            let overall = $('input[name="overall"]:checked').val();
            let phone = $('#phone-number').val();
            let comment = $('input[type="text"]').eq(1).val();
            if(staff == undefined || service == undefined || hygiene == undefined || overall == undefined || phone == '' || comment == ''){
                Swal.fire({
                    icon: 'error',
                    title: '{{__('custom.Please fill all fields')}}',
                    showConfirmButton: false,
                    timer: 1500
                })
                return;
            }
            $.ajax({
                url: '{{route('frontend.feedbackStore',['restaurant'=>$restaurant->slug])}}',
                type: 'POST',
                data: {
                    staff: staff,
                    service: service,
                    hygiene: hygiene,
                    overall: overall,
                    phone: phone,
                    comment: comment,
                    '_token': '{{csrf_token()}}'
                },
                success: function (response){
                    if (response.status == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: '{{__('custom.Thank you for your feedback')}}',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('input[type="text"]').val('');
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: '{{__('custom.Something went wrong')}}',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    $('#exampleModal').modal('hide');
                }
            })
        })
    })
</script>
</body>
</html>
