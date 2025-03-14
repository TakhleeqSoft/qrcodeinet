@extends('layouts.app')
@section('title', __('system.plans.edit.title'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-mb-8 col-xl-8">
                            <h4 class="card-title">{{ __('system.plans.edit.title') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('restaurant.plans.index') }}">{{ __('system.plans.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.plans.edit.title') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 text-end">

                        </div>
                    </div>
                </div>

                {{ Form::model($plan, ['route' => ['restaurant.plans.update', $plan->plan_id], 'method' => 'put', 'files' => true, 'id' => 'pristine-valid']) }}
                @if (request()->query->has('back'))
                    <input type="hidden" name="back" value="{{ request()->query->get('back') }}">
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('restaurant.plans.fields', ['edit' => true])
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                            <a href="{{ route('restaurant.plans.index') }}"class="btn btn-secondary">{{ __('system.crud.back') }}</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection
