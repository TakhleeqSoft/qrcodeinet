@extends('layouts.app')
@section('title', __('system.fields.support'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.fields.support') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.fields.support') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                       <div class="row">
                            <div class="col-md-12">
                                <p class="font-weight-bold">{{ __('system.fields.support_content') }}</p>
                            </div>

                           @if(config('app.support_email') !=null||config('app.support_phone') !=null)
                               <div class="col-md-12">
                                   <p>{{ __('system.fields.support_content_sub') }}</p>
                               </div>
                           @endif
                       </div>
                        <div class="row">
                            @if(config('app.support_email') !=null)
                                <div class="col-md-12">
                                    <p class="mb-3"><b>{{ __('system.fields.email') }}:</b> <a class="text-dark" href="mailto:{{config('app.support_email')}}">{{config('app.support_email')}}</a></p>
                                </div>
                            @endif

                            @if(config('app.support_phone') !=null)
                                <div class="col-md-12">
                                    <p><b>{{ __('system.fields.phone_number') }}:</b> <a class="text-dark" href="tel:{{config('app.support_phone')}}">{{config('app.support_phone')}}</a></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
