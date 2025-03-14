<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-50px">
                            @sortablelink('id', __('system.crud.id'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('restaurant_id', __('system.call_waiters.restaurant_name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('table_name', __('system.call_waiters.table_name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between ">
                            @sortablelink('no_of_capacity', __('system.tables.no_of_capacity'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>

                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($waiters as $waiter)
                    <tr>
                        {{-- {{ dd($waiter['table']['name']) }} --}}
                        <th scope="row" class="sorting_1">{{ $waiter->id }}</th>
                        <td>{{ $waiter->restaurant->name }}</td>
                        <td>{{ $waiter['table']['name'] }}</td>
                        <td>{{ $waiter['table']['no_of_capacity'] }}</td>

                        <td>
                            {{ Form::open(['route' => ['restaurant.call-waiter.destroy', ['call_waiter' => $waiter->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.call_waiters.are_you_sure'), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $waiter->id, 'method' => 'delete']) }}
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            </div>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.call_waiters.menu')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
@push('page_scripts')
    <script>
        $(document).on('change', '.assign_restaurant', function(e) {
            if ($(this).val() != '') {
                var that = $(this).parents('form')
                var title = that.data('confirm-message');

                title = title.replace('#resturant#', $(this).find(":selected").text())
                console.log(title);
                alertify.confirm(
                    title,
                    function() {
                        that.submit();
                    },
                    function() {
                        alertify.error('{{ __('system.messages.operation_canceled') }}');
                    }
                ).set({
                    title: that.data('confirm-title')
                }).set({
                    labels: {
                        ok: '{{ __('system.crud.confirmed') }}',
                        cancel: '{{ __('system.crud.cancel') }}'
                    }
                });
            }
        })
    </script>
@endpush
