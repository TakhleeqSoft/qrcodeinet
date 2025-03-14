<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" '' id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('name', __('system.fields.restaurant_name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('contact_email', __('system.fields.email'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('phone_number', __('system.fields.phone_number'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('created_at', __('system.fields.created_at'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="w-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($restaurants ?? [] as $restaurant)
                    <tr>
                        <td>
                            <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">
                                    <a href="{{ route('frontend.restaurant', ['restaurant' => $restaurant->slug]) }}" target="_blank">
                                        <span>{{ $restaurant->name }}</span> <i class=" fas fa-external-link-alt ms-2 " aria-hidden="true"></i>
                                    </a>
                                </a>
                            </h5>
                            <p class="mb-0">
                                <span class="badge bg-success font-size-12">
                                    {{ $restaurant->restaurant_type->local_name ?? '-' }}
                                </span>
                            </p>
                        </td>
                        <td>{{ $restaurant->contact_email ?? '-' }}</td>
                        <td>{{ $restaurant->phone_number ?? '-' }}</td>
                        <td>
                            {{ $restaurant->created_at }}
                        </td>
                        <td>
                            @can('delete restaurants')
                                {{ Form::open(['route' => ['restaurant.restaurants.destroy', ['restaurant' => $restaurant->id]], 'class' => 'data-confirm', 'data-confirm-message' => __('system.restaurants.are_you_sure', ['name' => $restaurant->name]), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $restaurant->id, 'method' => 'delete', 'autocomplete' => 'off']) }}
                            @endif

                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                @can('edit restaurants')
                                <a role="button" href="{{ route('restaurant.restaurants.edit', ['restaurant' => $restaurant->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                @endcan

                                @can('delete restaurants')
                                    <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                @endcan
                            </div>

                            @can('delete restaurants')
                                {{ Form::close() }}
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.restaurants.title')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>


    </div>
</div>
<div class="row">
    {{ $restaurants->links() }}
</div>
