@extends('layouts.app')
@section('title', __('system.restaurants.create.menu'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.restaurants.create.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a
                                                href="{{ route('restaurant.restaurants.index') }}">{{ __('system.restaurants.menu') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ __('system.restaurants.create.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <form autocomplete="off" novalidate="" action="{{ route('restaurant.restaurants.store') }}"
                              id="pristine-valid" method="post" enctype="multipart/form-data">
                            @csrf

                            @include('restaurant.restaurants.fields', ['create' => true])

                        </form>
                    </div>


                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
