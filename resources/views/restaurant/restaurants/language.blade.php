@extends('layouts.app')
@section('title', __('system.restaurants.create.menu'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('custom.add_language') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a
                                                href="{{ route('restaurant.restaurants.index') }}">{{ __('system.restaurants.menu') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ __('custom.add_language') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <form autocomplete="off" novalidate="" action="{{ route('restaurant.restaurants.set-language') }}"
                            id="pristine-valid" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $id }}">

                            <div class="form-group">
                                <label class="required" for="languageSelect">{{ __('custom.select_language') }}</label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-info btn-xs select-all"
                                        style="border-radius: 0">{{ __('custom.select_all') }}</span>
                                    <span class="btn btn-info btn-xs deselect-all"
                                        style="border-radius: 0">{{ __('custom.deselect_all') }}</span>
                                </div>
                                <select class="form-control select2" name="language[]" id="languageSelect" multiple>
                                    @foreach ($languages as $language)
                                    
                                        <option class="p-3" value="{{ $language->id }}"
                                            {{ in_array($language->id, old('language', $assignedLanguages ?? [])) ? 'selected' : '' }}>
                                            {{ $language->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('language'))
                                    <div class="text-danger">
                                        {{ $errors->first('language') }}
                                    </div>
                                @endif
                                <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button> 
                            </div>
                        </form>
                    </div>

                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
