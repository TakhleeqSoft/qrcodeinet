@extends('frontend.master')
@push('page_css')
    <style>
        .language-menu.active-category{
            background-color:{{$restaurant->button_color}}!important;
        }
        #closeButton{
            background-color:{{$restaurant->button_color}}!important;
        }
        #sidebar .border-brown-bottom{
            border-color: {{$restaurant->button_color}}!important;
        }
    </style>
@endpush
@section('content')
<section class="container-fluid header-section">
    @php($append = request()->query->has('restaurant_view') ? ['restaurant_view' => request()->query->get('restaurant_view')] : [])
    @php($default_category_image = !empty($restaurant->vendor_setting->default_category_image) ? getFileUrl($restaurant->vendor_setting->default_category_image) : asset('assets/images/default_category.png'))
    <div class="row p-2">
        <div class="pb-6 pl-6 pr-6 pt-6 md:pb-32 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5 xl:gap-8" id="categories">
            @foreach ($food_categories ?? [] as $category)
                <div class="bg-white dark:bg-secondary/50 rounded-xl shadow-shadowitem hover:shadow-shadowdark transition p-5 mt-2 mb-2 ml-2 mr-2 category-items"> <!-- Added mt-2 mb-2 ml-2 mr-2 for margin -->
                    <a href="{{ route('restaurant.menu.item', ['restaurant' => $restaurant->slug, 'food_category' => $category->id] + $append) }}">
                        <img src="{{ $category->category_image_url }}" alt="" class="w-full rounded-t-xl h-32 sm:h-56 object-cover" onerror="this.src='{{ $default_category_image }}'" />
                    </a>
                    <div class="p-4">
                        <a href="{{ route('restaurant.menu.item', ['restaurant' => $restaurant->slug, 'food_category' => $category->id] + $append) }}" class="font-bold dark:text-white block category-name">{{ $category->local_lang_name }}</a>
                    </div>
                </div>
            @endforeach
            <p class="font-bold dark:text-white name truncate not_found hidden custome">
                {{ __('system.messages.food_not_found') }}
            </p>
        </div>
    </div>
</section>


@endsection
@push('page_js')
    <script>
        $(document).ready(function() {
            function serch(search) {

                search = search.toLowerCase();
                $(document).find(".not_found").hide();

                if (search == '')
                {
                    $(".category-items").show();
                    $('.not_found').hide();
                    $(document).find('#categories').show();
                }
                else
                {
                    // $(document).find('#categories').hide();
                    search = search.replace('\\', '\\\\');
                    var x = 0;
                    $(document).find('.category-items').each(function() {
                        var val1 = $(this).find('.category-name').html();

                        if (val1)
                            val1 = val1.toLowerCase();
                        else
                            val1 = "";

                        if (val1.search(search) == -1)
                        {
                            $(this).hide();
                            x++;
                        }
                        else
                        {
                            $(this).show();
                        }

                    });
                    if (x == $(document).find('.category-items').length)
                    {
                        $(document).find(".not_found").show();
                    }
                    else
                    {
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
