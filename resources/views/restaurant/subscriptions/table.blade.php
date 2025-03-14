<div class="row">
    <div class="col-sm-12 table-responsive">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer mt-0 table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th>{{trans('system.fields.name')}}</th>
                    <th>{{trans('system.plans.plan_name')}}</th>
                    <th>{{trans('system.plans.payment_method')}}</th>
                    <th>{{trans('system.plans.start_date')}}</th>
                    <th>{{trans('system.plans.expiry_date')}}</th>
                    <th>{{trans('system.plans.details')}}</th>
                    <th>{{trans('system.plans.status')}}</th>
                    <th>{{trans('system.dashboard.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($subscriptions) && count($subscriptions)>0)
                    @foreach($subscriptions as $subscription)
                        <tr  data-url="{{ url('get-rightbar-content') }}" data-id="{{ $subscription->id }}" data-action="subscription-history" @if(request()->action=='approved')  class="app-cursor-pointer" onclick="show_rightbar_section(this)" @endif>
                            <td> @if(isset($subscription->user)) {{$subscription->user->first_name}} @endif</td>
                            <td> @if(isset($subscription->plan->title)) {{$subscription->plan->title}} @else {{ __('system.plans.trial') }}  @endif</td>

                            <td>{{ trans('system.payment_setting.'.$subscription->payment_method) }}</td>

                            <td>{{formatDate($subscription->start_date)}}</td>

                            @if(isset($subscription->expiry_date) && $subscription->expiry_date!=null)
                                <td>{{formatDate($subscription->expiry_date)}}</td>
                            @else
                                <td data-action="{{$subscription->expiry_date}}">{{ trans('system.plans.lifetime') }}</td>
                            @endif
                            <td style="width: 300px">
                               {{$subscription->details}}
                            </td>
                            <td>
                                @if($subscription->status=='approved')
                                    <span class="badge bg-success font-size-12">{{trans('system.plans.approved')}}</span>
                                @elseif($subscription->status=='rejected')
                                    <span class="badge bg-danger font-size-12">{{trans('system.plans.rejected')}}</span>
                                @elseif($subscription->status=='pending')
                                    <span class="badge bg-secondary font-size-12">{{trans('system.plans.pending')}}</span>
                                @endif
                            </td>
                            <td>
                                @if($subscription->status!='approved')

                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if($subscription->status=='pending')
                                                <li>
                                                    {{ Form::open(['route' => ['restaurant.subscriptions.approve', ['subscription' => $subscription->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.plans.are_you_sure', ['name' => __('system.plans.approve')]), 'data-confirm-title' => __('system.plans.approve'), 'id' => 'approve_form_' . $subscription->id, 'method' => 'put']) }}
                                                    <button type="submit" class="dropdown-item btn btn-success"><i class="mdi mdi-check-all font-size-16 text-success me-1"></i> {{trans('system.plans.approve')}}</button>
                                                    {{ Form::close() }}
                                                </li>

                                                <li>
                                                    {{ Form::open(['route' => ['restaurant.subscriptions.reject', ['subscription' => $subscription->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.plans.are_you_sure', ['name' => __('system.plans.reject')]), 'data-confirm-title' => __('system.plans.reject'), 'id' => 'reject_form_' . $subscription->id, 'method' => 'put']) }}
                                                    <button type="submit" class="dropdown-item btn btn-danger"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> {{trans('system.plans.reject')}}</button>
                                                    {{ Form::close() }}
                                                </li>
                                            @elseif($subscription->status=='rejected')
                                                <li>
                                                    {{ Form::open(['route' => ['restaurant.subscriptions.delete', ['subscription' => $subscription->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.plans.subscription_delete', ['name' => __('system.crud.delete')]), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete_form_' . $subscription->id, 'method' => 'put']) }}
                                                    <button type="submit" class="dropdown-item btn btn-danger"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> {{trans('system.crud.delete')}}</button>
                                                    {{ Form::close() }}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                @endif

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.plans.subscriptions')]) }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
