@extends('layouts.app')
@section('title', __('system.tables.menu'))
@push('page_css')
    <style>
        .data-description {
            text-overflow: clip;
            max-height: 50px;
            min-height: 50px;
            overflow: hidden;
        }
    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.tables.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.tables.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        @can('add tables')
                            <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                                <a href="{{ route('restaurant.tables.create') }}" class="btn btn-primary btn-rounded waves-effect waves-light"><i class="bx bx-plus me-1"></i>{{ __('system.crud.add_new') }}</a>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <div id="restaurants_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                                    <div id="data-preview" class='overflow-hidden'>
                                        @include('restaurant.tables.table')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
