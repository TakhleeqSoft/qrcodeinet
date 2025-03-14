@extends('frontend.master')
@section('content')
    <section class="container">
        <div class="lg:flex items-center justify-between pt-14 pb-8 text-center lg:text-left">
            <h3 class="text-2xl font-bold mb-5 lg:mb-0 dark:text-white">{{ $food_category->local_lang_name }}</h3>
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-end gap-5">

                {!! Form::select('categories', $categoires, $food_category->id, [
                    'class' => 'text-white bg-neutral dark:bg-[#2c333f] text-sm font-semibold py-3.5 px-4 rounded-lg border border-neutral dark:border-secondary  form-select outline-none',
                    'id' => 'category',
                ]) !!}

            </div>
        </div>
        <div class="pb-12 md:pb-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 xl:gap-8">
            @include('frontend.food_list')
        </div>
    </section>
@endsection
@push('page_js')
    <script>
        @php($append = request()->query->has('restaurant_view') ? ['restaurant_view' => request()->query->get('restaurant_view')] : [])

        var categoriesRoute = "{{ route('restaurant.menu.item', ['restaurant' => $restaurant->slug, 'food_category' => '#ID#']) . '?' . http_build_query($append) }}"

        $(document).on("change", "#category", function() {
            categoriesRoute = categoriesRoute.replace("#ID#", $(this).val())
            document.location.href = categoriesRoute

        })
        $(document).ready(function() {
            function serch(search) {
                search = search.toLowerCase();
                $(".food-item").show();
                $(document).find(".not_found").hide();
                if (search == '') {
                    $(".food-item").show();
                    $('.not_found').hide();
                } else {
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

                        if (val1.search(search) == -1 && val2.search(search) == -1 && val3.search(search) == -1) {
                            $(this).hide();
                            x++;
                        }



                    });
                    if (x == $(document).find('.food-item').length) {
                        $(document).find(".not_found").show();
                    } else {
                        $(document).find(".not_found").hide();
                    }

                }
            }


            $(document).on('keyup', '#search_text', function() {
                var search = $(this).val();
                serch(search)
            })
        })
    </script>
@endpush
