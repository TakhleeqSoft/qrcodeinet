@extends('layouts.app')
@section('title', __('system.dashboard.report'))
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
                        <h4 class="card-title">{{ __('system.dashboard.report') }}</h4>
                        <div class="page-title-box pb-0 d-sm-flex">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('system.dashboard.report') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div id="restaurants_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                        <form class="row mb-3" method="get" action="">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label class="form-label" for="first_name">{{__('system.vendors.menu')}}</label>
                                            <select name="user_id" class="form-control" id="">
                                                <option value="">{{__('system.dashboard.all')}}</option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $user->id == request()->query('user_id') ?  'selected' : '' }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label" for="from_date">{{__('system.dashboard.from_date')}}</label>
                                            <input type="date" class="form-control" id="from_date" name="from_date" value="{{ request()->query('from_date') ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label" for="to_date">{{__('system.dashboard.to_date')}}</label>
                                            <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request()->query('to_date') ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" style="padding-top: 25px;">
                                <button type="submit" class="btn btn-primary ">{{__('system.crud.search')}}</button>
                                <a href="{{url('/report')}}" class="btn btn-secondary ">{{__('system.crud.reset')}}</a>
                            </div>
                        </form>
                        <div id="data-preview" class='overflow-hidden'>
                            @include('restaurant.report.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
