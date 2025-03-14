 @php($languages_array = getAllLanguages(true))
 @extends('layouts.app', ['languages_array' => $languages_array])
 @section('title', __('system.environment.menu'))
 @section('content')
     <div class="row">
         <div class="col-xl-12 col-sm-12">
             <div class="card">
                 <div class="card-header">
                     <div class="row">
                         <div class="col-md-6 col-xl-6">
                             <h4 class="card-title">{{ __('system.environment.title') }}</h4>
                             <div class="page-title-box pb-0 d-sm-flex">
                                 <div class="page-title-right">
                                     <ol class="breadcrumb m-0">
                                         <li class="breadcrumb-item"><a
                                                 href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                         <li class="breadcrumb-item active">{{ __('system.environment.title') }}</li>
                                     </ol>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <form autocomplete="off" novalidate="" action="{{ route('restaurant.environment.setting.update') }}"
                     id="pristine-valid" method="post" enctype="multipart/form-data">
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-12">
                                 <!-- Nav tabs -->
                                 <ul class="nav nav-tabs" role="tablist">
                                     <li class="nav-item">
                                         <a class="nav-link active" href="{{ url('environment/setting') }}">
                                             <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                             <span class="d-none d-sm-block">{{ __('system.environment.application') }}
                                                 {{ __('system.environment.title') }}</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ url('environment/setting/email') }}">
                                             <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                             <span class="d-none d-sm-block">{{ __('system.environment.email') }}</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ url('environment/setting/payment') }}">
                                             <span class="d-block d-sm-none"><i class="far fa-credit-card"></i></span>
                                             <span class="d-none d-sm-block">{{ __('system.environment.payment') }}</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('restaurant.restaurant-type.index') }}">
                                             <span class="d-block d-sm-none"><i class="fas fa-utensils"></i></span>
                                             <span class="d-none d-sm-block">{{ __('system.restaurant_type.menu') }}</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('restaurant.frontend.admin') }}">
                                             <span class="d-block d-sm-none"><i class="fa fa-globe"></i></span>
                                             <span class="d-none d-sm-block">{{ __('system.dashboard.frontend') }}</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ url('environment/setting/seo') }}">
                                             <span class="d-block d-sm-none"><i class="fa fa-code"></i></span>
                                             <span class="d-none d-sm-block">{{ __('system.environment.seo') }}</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ url('environment/setting/analytics') }}">
                                             <span class="d-block d-sm-none"><i class="fa fa-code"></i></span>
                                             <span class="d-none d-sm-block">{{ __('system.environment.analytics_code') }}</span>
                                         </a>
                                     </li>
                                 </ul>
                                 @method('put')
                                 @csrf
                                 @include('restaurant.settings.fields')
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
