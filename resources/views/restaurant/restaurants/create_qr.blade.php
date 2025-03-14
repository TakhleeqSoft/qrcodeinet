@extends('layouts.app')
@section('title', __('system.qr_code.menu'))
@push('page_css')
    <style>
        .section-to-print{
            margin-bottom: 30px;
        }
        @media only screen and (min-width: 320px) and (max-width: 700px) {
            label[for="profile_image"] {
                display: block;
            }
        }

        @media print {
            body * {
                visibility: hidden;
                margin: 0px 30px;
            }

            .section-to-print,
            .section-to-print * {
                visibility: visible;
            }

            .section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="tab-content">

                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <h4 class="card-title">{{ __('system.qr_code.menu') }}</h4>
                                <div class="page-title-box pb-0 d-sm-flex">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a
                                                    href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a>
                                            </li>
                                            <li class="breadcrumb-item active">{{ __('system.qr_code.menu') }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="blog-post ">
                                                    <div id="loader">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" class="d-block m-auto"
                                                             width="150px" height="150px" viewBox="0 0 100 100"
                                                             preserveAspectRatio="xMidYMid">
                                                            <g transform="rotate(0 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-1.6374269005847952s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(24 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-1.5204678362573099s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(48 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-1.4035087719298245s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(72 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-1.286549707602339s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(96 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-1.1695906432748537s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(120 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-1.0526315789473684s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(144 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-0.935672514619883s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(168 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-0.8187134502923976s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(192 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-0.7017543859649122s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(216 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-0.5847953216374269s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(240 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-0.4678362573099415s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(264 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-0.3508771929824561s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(288 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-0.23391812865497075s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(312 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="-0.11695906432748537s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                            <g transform="rotate(336 50 50)">
                                                                <rect x="47.5" y="13" rx="2.5" ry="5.76" width="5" height="16"
                                                                      fill="#1c84ee">
                                                                    <animate attributeName="opacity" values="1;0" keyTimes="0;1"
                                                                             dur="1.7543859649122806s" begin="0s"
                                                                             repeatCount="indefinite"></animate>
                                                                </rect>
                                                            </g>
                                                        </svg>
                                                    </div>

                                                </div>
                                                <div id="QRDisplay" class="text-center overflow-hidden" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="col-lg-8 col-md-6">
                                <form autocomplete="off" action="" id='QRData' enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    {{ __('system.fields.image') }}
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label
                                                                class="form-label"> {{ __('system.fields.select_image') }}</label>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if (($restaurant->qr_details['logo'] ?? null) != null)
                                                                            <img
                                                                                class="avatar-xl rounded-circle img-thumbnail preview-image "
                                                                                src="{{ getFileUrl($restaurant->qr_details['logo']) }}"/>
                                                                            <input type="hidden" name="logo" value="true"
                                                                                   class="remove-logo">
                                                                        @else
                                                                            <img
                                                                                class="avatar-xl rounded-circle img-thumbnail preview-image"
                                                                                style="display: none;"/>
                                                                        @endif

                                                                        <input type="file" name="image" id="profile_image"
                                                                               class="d-none my-preview qr-genarte" accept="image/*"
                                                                               data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower('image')]) }}"
                                                                               data-preview='.preview-image'>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="profile_image" class="mb-0">
                                                                            <div for="profile-image"
                                                                                 class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                                                                {{ __('system.fields.select_image') }}
                                                                            </div>
                                                                        </label>
                                                                        <button type="button"
                                                                                class="btn btn-danger remove-image preview-image"
                                                                                @if (($restaurant->qr_details['logo'] ?? null) == null) style="display: none;" @endif>
                                                                            {{ __('system.fields.remove_image') }}
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="mb-3 preview-image"
                                                                 @if (($restaurant->qr_details['logo'] ?? null) == null) style="display: none;" @endif>

                                                                <div class="w-75">
                                                                    <input type="hidden" name="logo_size" value="0.25">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">

                                                                <label
                                                                    class="form-label">{{ __('system.fields.select_qr_size') }}</label>
                                                                <div class="w-75">
                                                                    <input type="range" min="100" max="325" name="size"
                                                                           value="{{ $restaurant->qr_details['size'] ?? '325' }}"
                                                                           step="10" class="form-range qr-genarte">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>





                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    {{ __('system.fields.color') }}
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label">{{ __('system.fields.select_color_type') }}</label>
                                                        <select name="gradient_method" id=""
                                                                class="form-select qr-genarte w-75">
                                                            <option
                                                                value="">{{ __('system.fields.only_one_color') }}</option>
                                                            @foreach (['vertical' => 'Vertical', 'horizontal' => 'Horizontal', 'diagonal' => 'Diagonal', 'inverse_diagonal' => 'Inverse Diagonal', 'radial' => 'Radial'] as $key => $value)
                                                                <option
                                                                    value="{{ $key }}" {{ ($restaurant->qr_details['gradient_method'] ?? '') == $key ? 'selected' : '' }}> {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mt-3 one-colors-div">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-label">{{ __('system.fields.select_color') }}</label>
                                                                <input type="color" name="color"
                                                                       class="form-control form-control-color mw-100 qr-genarte"
                                                                       value="{{ $restaurant->qr_details['color'] ?? '#000000' }}"
                                                                       title="Choose your color">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-label">{{ __('system.fields.color_transparent') }}</label>
                                                                <div class="w-75">
                                                                    <input type="range" min="25" max="100"
                                                                           name="color_transparent"
                                                                           value="{{ $restaurant->qr_details['color_transparent'] ?? '100' }}"
                                                                           class="form-range qr-genarte">
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="mt-3 gradient-colors-div">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-label">{{ __('system.fields.select_color_one') }}</label>
                                                                <input type="color" name="gradient_color1"
                                                                       class="form-control form-control-color mw-100 qr-genarte"
                                                                       value="{{ $restaurant->qr_details['gradient_color1'] ?? '#000000' }}"
                                                                       title="Choose your color">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-label">{{ __('system.fields.select_color_two') }}</label>

                                                                <input type="color" name="gradient_color2"
                                                                       class="form-control form-control-color mw-100 qr-genarte"
                                                                       value="{{ $restaurant->qr_details['gradient_color2'] ?? '#000000' }}"
                                                                       title="Choose your color">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-label">{{ __('system.fields.select_background_color') }}</label>
                                                                <input type="color" name="back_color"
                                                                       class="form-control form-control-color mw-100 qr-genarte"
                                                                       value="{{ $restaurant->qr_details['back_color'] ?? '#ffffff' }}"
                                                                       title="Choose your color">
                                                            </div>
                                                            <div class="col-md-6 select_background_transparent">

                                                                <label
                                                                    class="form-label">{{ __('system.fields.select_background_transparent') }}</label>
                                                                <div class="w-75">
                                                                    <input type="range" min="0" max="100"
                                                                           id="back_color_transparent"
                                                                           name="back_color_transparent"
                                                                           value="{{ $restaurant->qr_details['back_color_transparent'] ?? '1' }}"
                                                                           class="form-range qr-genarte">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    {{ __('system.fields.style') }}
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label">{{ __('system.fields.select_qr_style') }}</label>
                                                        <div class="w-75">
                                                            <select name="qr_style" id=""
                                                                    class="form-select qr-genarte">
                                                                @foreach (['square' => 'Square', 'dot' => 'Dot', 'round' => 'Round'] as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ ($restaurant->qr_details['qr_style'] ?? '') == $key ? 'selected' : '' }}> {{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label">{{ __('system.fields.select_eye_style') }}</label>
                                                        <div class="w-75">

                                                            <select name="eye_style" id=""
                                                                    class=" form-select qr-genarte">
                                                                @foreach (['square' => 'Square', 'circle' => 'Circle'] as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ ($restaurant->qr_details['eye_style'] ?? '') == $key ? 'selected' : '' }}> {{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="mt-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-label">{{ __('system.fields.select_eye_inner_color') }}</label>

                                                                <input type="color" name="eye_inner_color"
                                                                       class="form-control form-control-color mw-100 qr-genarte"
                                                                       value="{{ $restaurant->qr_details['eye_inner_color'] ?? '#000000' }}"
                                                                       title="Choose your color">
                                                            </div>


                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-label">{{ __('system.fields.select_eye_outer_color') }}</label>

                                                                <input type="color" name="eye_outer_color"
                                                                       class="form-control form-control-color mw-100 qr-genarte"
                                                                       value="{{ $restaurant->qr_details['eye_outer_color'] ?? '#000000' }}"
                                                                       title="Choose your color">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <div class="my-4 hstack gap-3">
                                                <button type="submit"
                                                        class="btn btn-primary w-25">{{ __('system.crud.save') }}</button>
                                                <a href="{{ route('restaurant.create.QR') }}"
                                                   class="btn btn-outline-danger ">{{ __('system.crud.reset') }}</a>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>


    </div>

@endsection

@push('page_scripts')
    <script>
        var request

        function GetQR(save = 0) {
            if (request) {
                request.abort();
            }
            var data = $('#QRData')[0];
            data = new FormData(data);
            var types = ['application/octet-stream', 'image/gif', 'image/png', 'image/jpeg',];
            var f_type = data.get('image').type
            if (!types.includes(f_type)) {
                if (f_type != "")
                    alertify.error('{{ __('validation.allow_only_jpg_png_gif_error') }}');
                data.delete('image');
                $('#profile_image').val('');
                $(".preview-image").hide() -
                $(".remove-logo").remove();
            }

            request = $.ajax({

                    url: '{{ route('restaurant.genarteQR', ['restaurant' => $restaurant->id]) }}?save=' + save,
                    type: 'post',
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $("#loader").show();
                        $("#QRDisplay").hide();
                    },
                    success: function (responce) {
                        if (save) {
                            document.location.reload();
                            return;
                        }
                        $("#loader").hide();
                        $("#QRDisplay").show();
                        $('#QRDisplay').html(responce);
                    }
                }
            )
        }

        $(document).on('submit', '#QRData', function (e) {
            e.preventDefault();
            GetQR(1);
        })

        $(document).on('change', '.qr-genarte', function () {
            if ($(this).attr('name') == "gradient_method") {
                if ($(this).val() == "") {
                    $('.one-colors-div').show()
                    $('.gradient-colors-div').hide()
                } else {
                    $('.one-colors-div').hide()
                    $('.gradient-colors-div').show()
                }
            }
            GetQR();
        })


        $(document).on('click', '.reset', function () {
            $('#QRData').trigger("reset")
            setTimeout(GetQR(), 200);
        })
        $(document).on('click', '.remove-image', function () {
            var data = $('#QRData')[0];
            data = new FormData(data);
            data.delete('image');
            $('#profile_image').val('');
            $(".preview-image").hide()
            $(".remove-logo").remove();
            GetQR();
        })

        function svgString2Image(svgString, width, height, format, callback) {
            // set default for format parameter
            format = format ? format : 'png';
            // SVG data URL from SVG string
            var svgData = svgString;
            // create canvas in memory(not in DOM)
            var canvas = document.createElement('canvas');
            // get canvas context for drawing on canvas
            var context = canvas.getContext('2d');
            // set canvas size
            canvas.width = width;
            canvas.height = height;
            // create image in memory(not in DOM)
            var image = new Image();
            // later when image loads run this
            image.onload = function () { // async (happens later)
                // clear canvas
                context.clearRect(0, 0, width, height);
                // draw image with SVG data to canvas
                context.drawImage(image, 0, 0, width, height);
                // snapshot canvas as png
                var pngData = canvas.toDataURL('image/' + format);
                // pass png data URL to callback
                callback(pngData);
            }; // end async
            // start loading SVG data into in memory image
            image.src = svgData;
        }

        $(document).find('[name=gradient_method]').change();
        $(document).on('click', '.dwn-png', function () {
            var img =  $(document).find('.section-to-print')
            var width = img.width()
            var height = img.height()
            svgString2Image($(this).data('href'), width, height, 'png', /* callback that gets png data URL passed to it */function (pngData) {
                var a = document.createElement("a"); //Create <a>
                a.href = pngData; //Image Base64 Goes here
                a.download = "{{ $restaurant->name }}.png"; //File name Here
                a.click();
                // $('.dwn-png').append(a)
            });
        })
    </script>
@endpush
