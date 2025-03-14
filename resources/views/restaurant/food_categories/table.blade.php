@push('page_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <style>
        .tblLocations .card {
            box-shadow: 0 0 3px rgb(0 0 0 / 15%);
        }

        body[data-layout-mode="dark"] #data-preview .card {
            background: #0000002e;
        }
    </style>
@endpush
<div class="row tblLocations mt-2 mx-1">
    @forelse ($foodCategories ?? [] as $foodCategory)
        <div class="col-xxl-3 col-lg-4 col-md-6 table-data" data-id="{{ $foodCategory->id }}" role="button">
            <i class="fas fa-grip-vertical grid-move-icon"></i>

            <div class="card overflow-hidden h-160px">

                @can('delete category')
                    {{ Form::open(['route' => ['restaurant.food_categories.destroy', ['food_category' => $foodCategory->id]], 'autocomplete' => 'off', 'class' => 'data-confirm d-grid', 'data-confirm-message' => __('system.food_categories.are_you_sure', ['name' => $foodCategory->category_name]), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $foodCategory->id, 'method' => 'delete']) }}
                @endcan

                <div class="card-body">

                    <div class="d-flex align-items-top">
                        <div>
                            @if ($foodCategory->category_image_url != null)
                                <img data-src="{{ $foodCategory->category_image_url }}" alt=""
                                    class="avatar-lg rounded-circle me-2 image-object-cover lazyload">
                            @else
                                <?php
                                $default_image = empty(config('vendor_setting')->default_category_image) ? asset('assets/images/default_category.png') : getFileUrl(config('vendor_setting')->default_category_image);
                                ?>
                                <img data-src="{{ $default_image }}" alt=""   class="avatar-lg rounded-circle me-2 image-object-cover lazyload">
                            @endif
                        </div>
                        <div class="flex-1 ms-3">
                            <h5 class="font-size-15 mb-1">
                                <a href="javascript:void(0)" class="text-dark text-break">{{ $foodCategory->local_lang_name }}</a>
                            </h5>
                            <p class="text-muted mb-0">{{ $foodCategory->created_at }}</p>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 text-end mb-2 position-absolute w-100 bottom-1">
                    @can('edit category')
                        <a role="button"
                            href="{{ route('restaurant.food_categories.edit', ['food_category' => $foodCategory->id]) }}"
                            class="btn btn-success btn-sm">
                            <i class="fa fa-pen"></i>
                        </a>
                    @endcan

                    @can('delete category')
                        <button type="submit" class="btn btn-danger btn-sm  me-2"><i class="fa fa-trash"></i></button>
                    @endcan
                </div>

                @can('delete category')
                    {{ Form::close() }}
                @endcan
            </div>
        </div>
    @empty
        <div class="col-md-12 text-center">
            {{ __('system.crud.data_not_found', ['table' => __('system.food_categories.title')]) }}

        </div>
    @endforelse

</div>
@push('page_scripts')
    <script src="{{ asset('assets/cdns/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/cdns/jquery.ui.touch-punch.min.js') }}"></script>
    <script>
        $(function() {
            $(".tblLocations").sortable({
                cursor: 'pointer',
                dropOnEmpty: false,
                start: function(e, ui) {
                    ui.item.addClass("selected");
                },
                stop: function(e, ui) {
                    ui.item.removeClass("selected");

                    $(this).find(".table-data").each(function(index) {

                        let id = $(this).data('id');
                        $.ajax({
                            url: "{{ route('restaurant.food_categories.change.position') }}",
                            type: 'post',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': id,
                                'index': index + 1,

                            },
                            success: function(data) {

                            },
                        });

                    });
                }
            });
        });
    </script>
@endpush
