@extends('layouts.app')
@section('title', __('system.food_categories.menu'))
@push('page_css')
    <style>
        .data-description {
            text-overflow: clip;
            max-height: 50px;
            min-height: 50px;
            overflow: hidden;
        }

        /* The switch - the box around the slider */
        .form-switch {
            position: relative;
            display: inline-block;
            width: 40px; /* Width of the switch */
            height: 22px; /* Height of the switch */
        }

        /* Hide the default checkbox */
        .form-switch .form-check-input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .form-switch .form-check-label {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc; /* Off state */
            transition: .4s;
            border-radius: 22px; /* Rounded borders for the slider */
        }

        .form-switch .form-check-label:before {
            position: absolute;
            content: "";
            height: 18px; /* Height of the slider */
            width: 18px; /* Width of the slider */
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%; /* Circular shape for the slider */
        }

        /* On mouse-over, add a grey background color */
        .form-switch .form-check-input:hover + .form-check-label {
            background-color: #a6a6a6;
        }

        /* When the checkbox is checked, add a blue background */
        .form-switch .form-check-input:checked + .form-check-label {
            background-color: #2196F3;
        }

        /* Move the slider to the right when checked */
        .form-switch .form-check-input:checked + .form-check-label:before {
            transform: translateX(18px); /* Adjust the position to match the size */
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
                            <h4 class="card-title">{{ __('system.food_categories.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.food_categories.menu') }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                        @can('add category')
                            <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                                <a href="{{ route('restaurant.food_categories.create') }}"
                                   class="btn btn-primary btn-rounded waves-effect waves-light"><i
                                        class="bx bx-plus me-1"></i>{{ __('system.crud.add_new') }}</a>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <!-- عرض حجم الصورة في حال تم ضغطها -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="available-categories">
                        <label for="">{{ __('system.fields.icon_available') }}</label>

                        @php($icon_available=false)
{{--                        @if(isset($categoryIconShow) && $categoryIconShow > 0)--}}
{{--                            @php($icon_available=true)--}}
{{--                        @endif--}}
                        @forelse ($foodCategories ?? [] as $foodCategory)
                            @if ($foodCategory->icon_available != null)
                                @php($icon_available=true)
                                @break
                            @endif
                        @empty
                        @endforelse
                        <div class="form-check form-switch">
                            {!! Form::checkbox('icon_available', $icon_available, $icon_available, [
                                'class' => 'form-check-input',
                                'id' => 'icon_available'
                            ]) !!}
                            <label class="form-check-label" for="icon_available"></label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div id="restaurants_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                            <p class="text-danger">{{ __('system.fields.category_drag_and_drop_message') }}</p>
                            <div id="data-preview" class='overflow-hidden'>
                                @include('restaurant.food_categories.table')
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        $(document).ready(function () {
            $('#icon_available').change(function () {
                // Check if the checkbox is checked
                var iconAvailable = $(this).is(':checked') ? 1 : 0;

                // Send AJAX request
                $.ajax({
                    url: '{{ url('icons/availability/update') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        icon_available: iconAvailable,
                        'restaurant_id': '{{ $restaurant_id }}'
                    },
                    success: function (response) {
                        console.log('Success:', response);
                        // Optionally, alert the user or update the UI
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endpush

