@push('page_css')
    <link rel="stylesheet" href="{{ asset('assets/cdns/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/cdns/magnific-popup.css') }}">
    <style>
        .tblLocations .card {
            box-shadow: 0 0 3px rgb(0 0 0 / 15%);
        }

        body[data-layout-mode="dark"] #data-preview .card {
            background: #0000002e;
        }

        img.mfp-img {
            width: 100%;
        }

        #data-preview .card {
            height: 220px;
        }

        .choices__list.choices__list--dropdown {
            z-index: 15;
        }

        .mr-10 {
            margin-right: 6px;
        }
    </style>
@endpush
<div class="row tblLocations px-1 pt-3">

    @forelse ($foods ?? [] as $food)

        <div class="col-xxl-3 col-lg-4 col-md-6 table-data" data-food_id="{{ $food->id }}"
            data-category="{{ request()->query('food_category_id') }}"
            @if (request()->query->has('food_category_id')) role="button" @endif>
            @if (request()->query->has('food_category_id'))
                <i class="fas fa-grip-vertical grid-move-icon"></i>
            @endif


            <div class="card overflow-hidden">

                {{ Form::open(['route' => ['restaurant.foods.destroy', ['food' => $food->id]], 'class' => 'data-confirm', 'data-confirm-message' => __('system.foods.are_you_sure', ['name' => $food->name]), 'data-confirm-title' => __('system.crud.delete'), 'autocomplete' => 'off', 'id' => 'delete-form_' . $food->id, 'method' => 'delete']) }}

                <div class="card-body">

                    <div class="d-flex align-items-top">
                        <div class="popup-slider " role="button" data-items='{!! json_encode($food->gallery_images_slider_data) !!}'>

                            @if ($food->food_image_url != null)
                                <img data-src="{{ $food->food_image_url }}" alt=""
                                    class="avatar-lg rounded-circle me-2 image-object-cover lazyload">
                            @else
                                <?php
                                $default_image = empty(config('vendor_setting')->default_food_image) ? asset('assets/images/default_food.png') : getFileUrl(config('vendor_setting')->default_food_image);
                                ?>
                                <img data-src="{{ $default_image }}"
                                    class="avatar-lg rounded-circle me-2 image-object-cover lazyload" />
                            @endif
                        </div>
                        <div class="flex-1 ms-3 food-size-width">
                            <h5 class="font-size-15 mb-1 "><a
                                    class="text-dark text-break">{{ $food->local_lang_name }}</a></h5>
                            <p class="text-muted mb-0 text-truncate">
                                @foreach ($food->food_categories as $c)
                                    <span
                                        class="badge font-size-12 bg-soft-info text-info foods-desc">{!! $c->category_name !!}
                                    </span>
                                @endforeach

                            </p>
                        </div>
                    </div>
                    <div class="mt-3 pt-1 w-100 data-description">
                        {{ $food->local_lang_description }}
                    </div>
                </div>

                <div class="position-absolute w-100 bottom-1">
                    <div class="col-md-12 text-end mb-2 px-3 align-items-center justify-content-between gap-1 d-flex ">
                        <div class="text-start">
                            @php
                                $discounted_price = $food->usd_discounted_price;
                                $discount = null;
                                if ($food->discount_type == 'fixed') {
                                    if (config('vendor_setting')->default_currency_position == 'right') {
                                        $discount = $food->discount_price . '' . config('vendor_setting')->default_currency_symbol;
                                    } else {
                                        $discount = config('vendor_setting')->default_currency_symbol . '' . $food->discount_price;
                                    }
                                } else {
                                    $discount = $food->discount_price . '%';
                                }

                            @endphp
                            @if ($discounted_price != null)
                                <div class="h5">{{ $discounted_price }}</div>
                                <div>
                                    <del class="h6 mr-10">{{ $food->usd_price }}</del>
                                    <span class="text-success">{{ $discount }}
                                        {{ trans('system.fields.off') }}</span>
                                </div>
                            @else
                                <div class="h5">{{ $food->usd_price }}</div>
                            @endif

                        </div>
                        <div class="d-flex align-items-center gap-1">
                            @can('edit food')
                                <a role="button"
                                    href="{{ route('restaurant.foods.edit', ['food' => $food->id, 'back' => url()->full()]) }}"
                                    class="btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                            @endcan

                            @can('delete food')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </button>
                            @endcan
                        </div>
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    @empty
        <div class="col-md-12 text-center">
            {{ __('system.crud.data_not_found', ['table' => __('system.foods.title')]) }}
        </div>
    @endforelse

</div>

@push('page_scripts')
    <script type="text/javascript" src="{{ asset('assets/cdns/jquery.magnific-popup.min.js') }}"></script>

    @if (request()->query->has('food_category_id'))
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

                            let food_id = $(this).data('food_id');
                            let category = $(this).data('category');
                            $.ajax({
                                url: "{{ route('restaurant.foods.change.position') }}",
                                type: 'post',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'food_id': food_id,
                                    'category': category,
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
    @endif
    <script>
        $(document).find('.popup-slider').each(function() {
            var that = $(this);
            var items = that.data('items');
            $(this).magnificPopup({
                items: items,
                closeBtnInside: false,

                gallery: {
                    enabled: true
                },
                type: 'image' // this is a default type
            });
        })
    </script>

@endpush
