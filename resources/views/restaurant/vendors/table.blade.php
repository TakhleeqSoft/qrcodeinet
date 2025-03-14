<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('first_name', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('email', __('system.fields.email'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            {{__('system.fields.membership')}}
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between w-150px">
                            @sortablelink('phone_number', __('system.fields.phone_number'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('created_at', __('system.fields.member_since'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>

                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('email_verified_at', __('system.fields.email_verified'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vendors as $vendor)
                    @php
                       $plan_title="";
                       if ($vendor->free_forever==true){
                            $plan_title="<span class='badge bg-success font-size-12'>".trans('system.vendors.free_forever')."</span>";
                       }else{
                           if ($vendor->is_trial_enabled==true){
                                $active_plan=(isset($vendor->active_plan) && $vendor->active_plan!=null)?$vendor->active_plan:null;
                                if($active_plan->expiry_date<date('Y-m-d')){
                                    $plan_title="<span class='badge bg-danger font-size-12'>".trans('system.plans.expired')."</span>";
                                }else{
                                    $plan_title="<span class='badge bg-success font-size-12'>".trans('system.plans.trial')."</span>";
                                }
                           }else{
                               $active_plan=(isset($vendor->active_plan) && $vendor->active_plan!=null)?$vendor->active_plan:null;
                               $current_plans_id=(isset($vendor->current_plans) && count($vendor->current_plans)>0)?$vendor->current_plans[0]->plan_id:0;
                               if(isset($plans) && count($plans)>0){
                                   $plan_title=isset($plans[$current_plans_id])?"<span class='badge bg-success font-size-12'>".$plans[$current_plans_id]."</span>":"";
                               }
                           }
                       }
                    @endphp
                    <tr>
                        <td>
                            @if ($vendor->profile_url != null)
                                <img data-src="{{ $vendor->profile_url }}" alt="" class="avatar-sm rounded-circle me-2 image-object-cover lazyload">
                            @else
                                <div class="avatar-sm d-inline-block align-middle me-2">
                                    <div class="avatar-title bg-soft-primary text-primary font-size-18 m-0 rounded-circle font-weight-bold">
                                        {{ $vendor->logo_name }}
                                    </div>
                                </div>
                            @endif
                            <span class="text-body">{{ $vendor->name }}</span>
                        </td>
                        <td>{{ $vendor->email }}</td>
                        <td>{!! $plan_title !!}</td>
                        <td>{{ $vendor->phone_number }}</td>
                        <td>{{ $vendor->created_at }}</td>
                        <td>
                            @if($vendor->email_verified_at==null)
                                <span class="badge bg-danger">{{__('system.fields.no')}}</span>
                            @else
                                <span class="badge bg-success">{{__('system.fields.yes')}}</span>
                            @endif
                        </td>
                        <td>

                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                {{ Form::open(['route' => ['restaurant.vendors.destroy', ['vendor' => $vendor->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.vendors.are_you_sure', ['name' => $vendor->name]), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $vendor->id, 'method' => 'delete']) }}
                            @endif

                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="{{ route('restaurant.vendors.show', ['vendor' => $vendor->id]) }}" class="btn btn-secondary">{{ __('system.fields.view') }}</a>
                                <a role="button" href="{{ route('restaurant.vendors.edit', ['vendor' => $vendor->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            </div>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                {{ Form::close() }}
                            @endif


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.vendors.title')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>


    </div>
</div>
<div class="row">
    {{ $vendors->links() }}
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
