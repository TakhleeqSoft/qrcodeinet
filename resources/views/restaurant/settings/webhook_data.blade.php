@extends('layouts.app')
@section('title', 'Webhook')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">Webhook Data</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">Webhook</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="mb-4">
                        <div id="restaurants_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" '' id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th scope="col">
                                            ID
                                        </th>
                                        <th scope="col">
                                            Type
                                        </th>

                                        <th>Created At</th>
                                        <th>{{ __('system.crud.action') }}</th>
                                    </tr>
                                    </thead>
                                        <tbody>

                                        @forelse ($webhook_data ?? [] as $webhook)
                                            <tr>
                                                <th scope="row" class="sorting_1">
                                                    {{$webhook->id}}
                                                </th>
                                                <th scope="row" class="sorting_1">
                                                    {{$webhook->type}}
                                                </th>
                                                <th scope="row" class="sorting_1">
                                                    {{$webhook->created_at}}
                                                </th>
                                                <td>
                                                    <a role="button" target="_blank" href="{{ route('restaurant.webhookDetails', ['webhook' => $webhook->id]) }}" class="btn btn-success">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    {{ __('system.crud.data_not_found', ['table' => 'Webhook']) }}
                                                </td>
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                {{ $webhook_data->links() }}
                            </div>

                        </div>
                        <!-- end table -->
                    </div>
                    <!-- end table responsive -->
                </div>
            </div>
        </div>
    </div>
@endsection
