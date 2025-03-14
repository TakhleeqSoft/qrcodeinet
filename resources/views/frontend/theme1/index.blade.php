@extends('frontend.master')
@section('content')
    <section class="container">
        <div class="flex md:justify-end justify-center pt-14 pb-8">
        </div>
        @php($append = request()->query->has('restaurant_view') ? ['restaurant_view' => request()->query->get('restaurant_view')] : [])
        @foreach ($food_categories as $category)
            <div class="category">
                <div class="lg:flex items-center justify-between pt-0 pb-4 text-center lg:text-left">
                    <h3 class="text-2xl font-bold mb-5 lg:mb-0 dark:text-white title">{{ $category->local_lang_name }}
                    </h3>
                </div>
                <div class="mb-10">
                    <div class="grid md:grid-cols-2 gap-5">
                        @foreach ($category->foods as $key => $food)
                            <div class="bg-white dark:bg-secondary/50 rounded-xl p-4 food-item popup-slider cursor-pointer"
                                data-id='{!! $food->id !!}'>
                                <a href="javascript:"
                                    class="font-bold text-secondary dark:text-white name">{{ $food->local_lang_name }}</a>
                                <p class="text-neutral text-sm pt-3 mb-4 font-semibold line-clamp-3 description">
                                    {{ $food->local_lang_description }}</p>
                                <div>
                                    <?php
                                    $discounted_price = $food->usd_discounted_price;
                                    $discount = getUsdDiscountPrice($food->discount_price, $food->discount_type, $restaurant->vendor_setting->default_currency_symbol ?? null, $restaurant->vendor_setting->default_currency_position ?? null);
                                    ?>
                                    @if ($discounted_price != null)
                                        <button type="button"
                                            class="font-bold text-base dark:text-white bg-primary/10 dark:bg-primary rounded-lg py-1.5 px-3 inline-block amount">
                                            <span>{{ $food->usd_discounted_price }}</span>
                                        </button>
                                        <div class="px-1 text-sm mt-2 dark:text-white">
                                            <del class="mr-2">{{ $food->usd_price }}</del>
                                            <span
                                                class="text-[#52d352de]">{{ $discount }}
                                                {{ trans('system.fields.off') }}</span>
                                        </div>
                                    @else
                                        <button type="button"
                                            class="font-bold text-base dark:text-white bg-primary/10 dark:bg-primary rounded-lg py-1.5 px-3 inline-block amount">
                                            <span>{{ $food->usd_price }}</span>
                                        </button>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                        <p class="font-bold dark:text-white name truncate not_found"
                            style="{{ count($category->foods) > 0 ? 'display:none;' : '' }}">
                            {{ __('system.messages.food_not_found') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        <p class="font-bold dark:text-white name truncate not_found" style="display:none;">
            {{ __('system.messages.food_not_found') }}</p>
    </section>
@endsection
@push('page_js')
    <script>
        $(document).ready(function() {
            function serch(search) {
                search = search.toLowerCase();
                $(".category,.food-item").show();
                if (search == '') {

                    $(".category,.food-item").show();
                    $(document).find(".not_found").hide();
                } else {
                    $(document).find(".not_found").hide();
                    search = search.replace('\\', '\\\\');
                    console.log(search);
                    var x = 0;
                    $(document).find('.category').each(function() {
                        var title = $(this).find('.title').html()
                        title = title.toLowerCase();
                        if (title.search(search) == -1) {
                            var hide = 0;

                            $(this).find('.food-item').each(function() {
                                var val1 = $(this).find('.name').html(),
                                    val2 = $(this).find('.amount').html();
                                val3 = $(this).find('.description').html();
                                if (val1)
                                    val1 = val1.toLowerCase();
                                else
                                    val1 = "";
                                if (val2)
                                    val2 = val2.toLowerCase();
                                else
                                    val2 = "";
                                if (val3)
                                    val3 = val3.toLowerCase();
                                else
                                    val3 = "";

                                if (val1.search(search) == -1 && val2.search(search) == -1 && val3
                                    .search(search) == -1) {
                                    $(this).hide();
                                    hide++;
                                }
                            });
                            if (hide == $(this).find('.food-item').length) {
                                $(this).hide();
                                x++;
                            }
                        }
                    })

                    if (x == $(document).find('.category').length) {
                        $(document).find(".not_found").show();
                    } else {
                        $(document).find(".not_found").hide();
                    }
                }
            }
            $(document).on('keyup', '.search-text', function() {
                var search = $(this).val();
                serch(search)
            })
        })
    </script>
@endpush
