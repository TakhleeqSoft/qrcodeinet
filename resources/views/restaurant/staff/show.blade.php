@extends('layouts.app')
@section('title', __('system.fields.view'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.staffs.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('restaurant.staff.index') }}">{{ __('system.staffs.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{$staff->first_name." ".$staff->last_name}}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row">
                            <!-- Profile Details -->
                            <div class="col-md-4">
                                <div class="card vendor_details_div_height">
                                    <div class="card-header">
                                        {{__('system.profile.profile_details')}}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{__('system.fields.name')}}</b>: {{$staff->first_name." ".$staff->last_name}}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{__('system.fields.email')}}</b>: {{$staff->email}}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{__('system.fields.phone_number')}}</b>: {{$staff->phone_number}}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{__('system.fields.member_since')}}</b>: {{$staff->created_at}}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{__('system.fields.address')}}</b>: {{$staff->address}}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{__('system.fields.city')}}</b>: {{$staff->city}}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{__('system.fields.state')}}</b>: {{$staff->state}}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{__('system.fields.zip')}}</b>: {{$staff->zip}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Details -->
                            <div class="col-md-4">
                                <div class="card vendor_details_div_height">
                                    <div class="card-header">
                                        {{__('system.password.menu')}}
                                    </div>
                                    <div class="card-body">
                                        <form method="post" autocomplete="off" novalidate="" id="pristine-valid" action="{{route('restaurant.staff.password.update', ['staff' => $staff->id]) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-group">
                                                        <label>{{__('system.fields.new_password')}}</label>
                                                        <input autocomplete="off" id="new_password" required name="new_password" placeholder="{{__('system.fields.new_password')}}" minlength="8" class="form-control"/>
                                                    </div>
                                                    @error('new_password')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mb-5">
                                                    <div class="form-group">
                                                        <label>{{__('system.fields.confirm_password')}}</label>
                                                        <input  autocomplete="off" data-pristine-equals-message="{{__('system.password.confirm_password_error')}}" data-pristine-equals="#new_password" id="confirm_password" required name="confirm_password" placeholder="{{__('system.fields.confirm_password')}}" minlength="8" class="form-control"/>
                                                    </div>
                                                        @error('confirm_password')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
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
        </div>
    </div>
@endsection
