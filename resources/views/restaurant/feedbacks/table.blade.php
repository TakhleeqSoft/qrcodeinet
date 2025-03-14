<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div>
                            @sortablelink('id', __('system.crud.id'), [], ['class' => 'w-100 text-gray d-flex justify-content-between'])
                        </div>
                    </th>
                    <th scope="col">
                        <div>
                            @sortablelink('name', __('system.feedbacks.name'), [], ['class' => 'w-100 text-gray d-flex justify-content-between'])
                        </div>
                    </th>
                    <th scope="col">
                        <div>
                            @sortablelink('email', __('system.feedbacks.email'), [], ['class' => 'w-100 text-gray d-flex justify-content-between'])
                        </div>
                    </th>
                    <th scope="col">
                        {{ucwords(__('system.feedbacks.message'))}}
                    </th>
                    <th scope="col">
                        <div>
                            @sortablelink('restaurant_id', __('system.feedbacks.restaurant'), [], ['class' => 'w-100 text-gray d-flex justify-content-between'])
                        </div>
                    </th>
                    <th scope="col">
                        {{__('system.feedbacks.user')}}
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($feedbacks as $feedback)
                    <tr>
                        <th scope="row" class="sorting_1">{{ $feedback->id }}</th>
                        <td>{{ $feedback->name }}</td>
                        <td>{{ $feedback->email }}</td>
                        <td><a data-url="{{url('get-rightbar-content')}}" data-id="{{$feedback->id}}" data-action="feedbacks"  onclick="show_rightbar_section(this)" href="javascript:void(0)">{{ __('system.fields.view') }}</a></td>
                        <td>{{ $feedback->restaurant->name }}</td>
                        <td>{{ $feedback->user->first_name . ' ' . $feedback->user->last_name }}</td>
                        <td>
                            {{ Form::open(['route' => ['restaurant.feedbacks.destroy', ['feedback' => $feedback->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.feedbacks.are_you_sure'), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $feedback->id, 'method' => 'delete']) }}
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            </div>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.dashboard.feedbacks')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
<div class="row">
    {{ $feedbacks->links() }}
</div>
@push('page_scripts')
    <script>
        $(document).on('change', '.assign_restaurant', function(e) {
            if ($(this).val() != '') {
                var that = $(this).parents('form')
                var title = that.data('confirm-message');

                title = title.replace('#resturant#', $(this).find(":selected").text())
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
