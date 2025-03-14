@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.menu'))
@push('page_css')
    <style>
        .rating {
            font-size: 1rem;
            color: #ffd700;
        }
        .rating .empty {
            color: #ddd;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('custom.feedback') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">>{{ __('custom.feedback') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr class="bg-light">
                                    <th>{{ __('custom.Staff') }}</th>
                                    <th>{{ __('custom.Service') }}</th>
                                    <th>{{ __('custom.Hygiene') }}</th>
                                    <th>{{ __('custom.How was overall experience?') }}</th>
                                    <th>{{ __('custom.Any additional comment?') }}</th>
                                    <th>{{ __('custom.Contact') }}</th>
                                    <th>{{ __('custom.created') }}</th>
                                    <th>{{ __('custom.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feedbacks as $feedback)
                                    <tr>
                                        <td>
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $feedback->staff)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="fas fa-star empty"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $feedback->service)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="fas fa-star empty"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $feedback->hygiene)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="fas fa-star empty"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $feedback->overall_experience)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="fas fa-star empty"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                        <td>{{ $feedback->additional_comment }}</td>
                                        <td>{{ $feedback->phone_number }}</td>
                                        <td>{{ $feedback->created_at }}</td>
                                        <td>
                                            <a data-id="{{ $feedback->id }}" class="btn btn-sm btn-danger delete" href=""><i class="fa fa-trash"></i></a>
                                            <form action="{{route('restaurant.vendor.feedback')}}" method="POST" id="delete-form-{{ $feedback->id }}" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $feedback->id }}">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $feedbacks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: '{{ __('custom.are_you_sure') }}',
                    text: '{{ __('custom.you_want_to_delete_this') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('custom.yes') }}',
                    cancelButtonText: '{{ __('custom.no') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + id).submit();
                    }
                });
            });
        });
    </script>
@endpush
