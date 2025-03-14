@extends('layouts.app')
@section('title', __('system.themes.menu'))

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="tab-content">

                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <h4 class="card-title">{{ __('system.themes.menu') }}</h4>
                                <div class="page-title-box pb-0 d-sm-flex">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a
                                                    href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                            <li class="breadcrumb-item active">{{ __('system.themes.menu') }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">

                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="row">

                            <!-- end card body -->
                            <div class="col-md-12  px-4 ">
                                <div class="row">
                                    @foreach ($themes as $theme)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row ">
                                                        <div class="col-md-6">
                                                            @if (strtolower($theme['name']) == strtolower($restaurant->theme ?? current($themes)['name']))
                                                                <span class="btn btn-sm btn-success disabled w-100">{{ __('system.crud.default') }}</span>
                                                            @else
                                                                {!! Form::open(['method' => 'put', 'route' => ['restaurant.themes.update']]) !!}
                                                                <input type="hidden" name="theme" value="{{ $theme['name'] }}">
                                                                <button type="submit" class="btn btn-sm btn-primary w-100">{{ __('system.crud.active') }}</button>
                                                                {!! Form::close() !!}
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <a type="button" target="_blank"
                                                               class="btn btn-sm btn-secondary mb-md-0"
                                                               href="{{ route('frontend.restaurant', ['restaurant' => $restaurant->slug, 'restaurant_view' => strtolower($theme['name'])]) }}">{{ __('system.crud.preview') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <img class="card-img img-fluid lazyload" data-src="{{ asset($theme['image']) }}" alt="Card image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card -->
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>


                    </div>

                </div>
                <!-- end card -->

            </div>
            <!-- end tab content -->
        </div>
        <!-- end col -->

    </div>
    <!-- end row -->
@endsection
