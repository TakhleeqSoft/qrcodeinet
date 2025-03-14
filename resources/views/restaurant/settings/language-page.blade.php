@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.menu'))
@push('page_css')
    <style>
        .currency-min-height {
            min-height: 316px;
        }
    </style>
@endpush
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.environment.display') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.display') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form autocomplete="off" novalidate="" action="{{ url('vendor/setting/brand-setting') }}"
                      id="pristine-valid" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ url('vendor/setting') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span
                                                class="d-none d-sm-block">{{ __('system.environment.display') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('vendor/pusher-setting') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span
                                                class="d-none d-sm-block">{{ __('system.environment.pusher_setting') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ url('vendor/setting/language-page') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">{{ __('custom.language_page') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                @method('put')
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3 col-12">
                                                                        <div class="mb-3">
                                                                            <label>{{__('custom.facebook_url')}}</label>
                                                                            <input type="text" class="form-control"
                                                                                   name="facebook_url"
                                                                                   value="{{ old('facebook_url',$data->facebook_url) }}">
                                                                            @error('facebook_url')
                                                                            <span
                                                                                class="text-danger d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-12">
                                                                        <div class="mb-3">
                                                                            <label>{{__('custom.instagram_url')}}</label>
                                                                            <input type="text" class="form-control"
                                                                                   name="instagram_url"
                                                                                   value="{{old('instagram_url',$data->instagram_url)}}">
                                                                            @error('instagram_url')
                                                                            <span
                                                                                class="text-danger d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-12">
                                                                        <div class="mb-3">
                                                                            <label>{{__('custom.twitter_url')}}</label>
                                                                            <input type="text" class="form-control"
                                                                                   name="twitter_url"
                                                                                   value="{{old('twitter_url',$data->twitter_url)}}">
                                                                            @error('twitter_url')
                                                                            <span
                                                                                class="text-danger d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-12">
                                                                        <div class="mb-3">
                                                                            <label>{{__('custom.tiktok_url')}}</label>
                                                                            <input type="text" class="form-control"
                                                                                   name="tiktok_url"
                                                                                   value="{{old('tiktok_url',$data->tiktok_url)}}">
                                                                            @error('tiktok_url')
                                                                            <span
                                                                                class="text-danger d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-12">
                                                                        <div class="mb-3">
                                                                            <label>{{__('custom.snapchat_url')}}</label>
                                                                            <input type="text" class="form-control"
                                                                                   name="snapchat_url"
                                                                                   value="{{old('snapchat_url',$data->map_url)}}">
                                                                            @error('snapchat_url')
                                                                            <span
                                                                                class="text-danger d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-12">
                                                                        <div class="mb-3">
                                                                            <label>{{__('custom.map_url')}}</label>
                                                                            <input type="text" class="form-control"
                                                                                   name="map_url"
                                                                                   value="{{old('map_url',$data->map_url)}}">
                                                                            @error('map_url')
                                                                            <span
                                                                                class="text-danger d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-12">
                                                        <div class="card">
                                                            <div class="card-header">{{ __('custom.default_video') }}</div>
                                                            <div class="card-body">
                                                                @if($data->default_video)
                                                                    <video width="100%" controls id="video-player">
                                                                        <source src="{{ asset('storage/'.$data->default_video) }}"
                                                                                type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @endif
                                                            </div>
                                                            <div class="card-footer bg-transparent  text-muted">
                                                                <input type="file" name="default_video"
                                                                       id="default_video"
                                                                       class="d-none my-preview"
                                                                       accept="video/*"
                                                                       data-pristine-accept-message=""
                                                                       data-preview='.preview-image_22'>
                                                                <label for="default_video" class="mb-0">
                                                                    <div class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                                                        <span class="d-none d-lg-inline">{{__('custom.upload_video')}}</span>
                                                                    </div>
                                                                </label>
                                                                @error('default_video')
                                                                <span
                                                                    class="text-danger d-block">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="card">
                                                            <div class="card-header">{{ __('custom.button_color') }}</div>
                                                            <div class="card-body">
                                                                <div class="mb-3">
                                                                    <label>{{__('custom.button_color')}}</label>
                                                                    <input type="color" class="form-control"
                                                                           name="button_color"
                                                                           value="{{old('button_color',$data->button_color)}}">
                                                                    @error('instagram_url')
                                                                    <span
                                                                        class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top text-muted">
                        <div class="row">
                            <div class="col-12 mt-1">
                                <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        $(document).ready(function () {
            $("#default_video").on("change", function (event) {
                var file = event.target.files[0];
                if (file) {
                    var videoURL = URL.createObjectURL(file);
                    $("#video-player").attr("src", videoURL);
                }
            });
        });
    </script>
@endpush
