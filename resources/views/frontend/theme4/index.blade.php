@extends('frontend.master')
@section('content')
    <section class="container">

        @php($append = request()->query->has('restaurant_view') ? ['restaurant_view' => request()->query->get('restaurant_view')] : [])
        @php($default_category_image = !empty($restaurant->vendor_setting->default_category_image) ? getFileUrl($restaurant->vendor_setting->default_category_image) : asset('assets/images/default_category.png'))

        <div class="grid sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-x-5 gap-y-9 mt-8 mb-12 lg:mb-20 lg:mt-12" id="categories">
            @foreach ($food_categories ?? [] as $category)
                <div class="text-center">
                    <a href="{{ route('restaurant.menu.item', ['restaurant' => $restaurant->slug, 'food_category' => $category->id] + $append) }}">
                        <img src="{{ $category->category_image_url }}" onerror="this.src='{{ $default_category_image }}'" alt="" class="w-full rounded-xl h-36 object-cover" />
                    </a>
                    <a href="{{ route('restaurant.menu.item', ['restaurant' => $restaurant->id, 'food_category' => $category->id] + $append) }}"
                        class="mt-3 inline-block font-bold line-clamp-1 dark:text-white">{{ $category->local_lang_name }}</a>
                </div>
            @endforeach
        </div>

        {{-- <div class="pb-12 pt-6 md:pb-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 xl:gap-8 ">
            @php($foods = $restaurant->foods ?? [])
            @include('frontend.food_list', ['style' => 'display:none;'])
        </div> --}}

    </section>
@endsection
@push('page_js')
    <script>
        $(document).ready(function() {
            function serch(search) {

                search = search.toLowerCase();
                $(document).find(".not_found").hide();

                if (search == '') {
                    $(".food-item").hide();
                    $('.not_found').hide();
                    $(document).find('#categories').show();
                } else {
                    $(document).find('#categories').hide();
                    search = search.replace('\\', '\\\\');
                    var x = 0;
                    $(document).find('.food-item').each(function() {
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

                        if (val1.search(search) == -1 && val2.search(search) == -1 && val3.search(search) ==
                            -1) {
                            $(this).hide();
                            x++;
                        } else {
                            $(this).show();
                        }



                    });
                    if (x == $(document).find('.food-item').length) {
                        $(document).find(".not_found").show();
                    } else {
                        $(document).find(".not_found").hide();
                    }

                }
                // get a new date (locale machine date time)
                var date = new Date();
                // get the date as a string
                var n = date.toDateString();
                // get the time as a string
                var time = date.toLocaleTimeString();


            }


            $(document).on('keyup', '#search_text', function() {
                var search = $(this).val();
                serch(search)
            })
            serch('');
        })
    </script>
@endpush
