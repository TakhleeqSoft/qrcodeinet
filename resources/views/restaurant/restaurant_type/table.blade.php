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
                        <div class="d-flex justify-content-between w-260px">
                            @sortablelink('type', __('system.restaurant_type.type'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($restaurantTypes as $restaurantType)
                    <tr>
                        <th scope="row" class="sorting_1">{{ $restaurantType->id }}</th>
                        <td>{{ $restaurantType->local_name }}</td>
                        <td>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                {{ Form::open(['route' => ['restaurant.restaurant-type.destroy', ['restaurant_type' => $restaurantType->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.restaurant_type.are_you_sure', ['type' => $restaurantType->type]), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $restaurantType->id, 'method' => 'delete']) }}
                            @endif

                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="{{ route('restaurant.restaurant-type.edit', ['restaurant_type' => $restaurantType->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            </div>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                {{ Form::close() }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.restaurant_type.menu')]) }}
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
