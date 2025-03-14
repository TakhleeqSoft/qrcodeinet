@extends('layouts.app')
@section('title', __('system.staffs.create.menu'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.staffs.create.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('restaurant.staff.index') }}">{{ __('system.staffs.title') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.staffs.create.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <form autocomplete="off" novalidate="" action="{{ route('restaurant.staff.store') }}" id="pristine-valid" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="card-body">
                            @csrf
                            @include('restaurant.staff.fields')
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top text-muted">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                                <a href="{{ route('restaurant.staff.index') }}"class="btn btn-secondary">{{ __('system.crud.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
