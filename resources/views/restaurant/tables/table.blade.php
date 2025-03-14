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
                            @sortablelink('name', __('system.tables.name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('no_of_capacity', __('system.tables.no_of_capacity'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between ">
                            @sortablelink('position', __('system.tables.position'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>

                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tables as $table)
                    <tr>
                        <th scope="row" class="sorting_1">{{ $table->id }}</th>
                        <td>{{ $table->name }}</td>
                        <td>{{ $table->no_of_capacity }}</td>
                        <td>{{ $table->position }}</td>
                        <td>
                            @can('delete tables')
                                {{ Form::open(['route' => ['restaurant.tables.destroy', ['table' => $table->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.tables.are_you_sure', ['name' => $table->title]), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $table->id, 'method' => 'delete']) }}
                            @endcan
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    @can('edit tables')
                                        <a role="button" href="{{ route('restaurant.tables.edit', ['table' => $table->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                    @endcan

                                    @can('delete tables')
                                        <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                    @endcan
                                </div>
                            @can('delete tables')
                                {{ Form::close() }}
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.tables.menu')]) }}
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
