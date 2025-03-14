@extends('frontend.master')
@section('content')
@push('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom-menu.css') }}">
    <style>
        div[style="display: flex; align-items: center;"] a {
            display: block;
            width: 100%;
            height: 100%;
        }

    div[style="display: flex; align-items: center;"] {
        cursor: pointer; /* لجعل المؤشر يظهر وكأن المربع بأكمله زر */
    }
    .menu-items.selected-active-category {
        background-color:{{$restaurant->button_color}}!important;
        border-color: {{$restaurant->button_color}}!important;
    }
    .sidebar-options.selected-active-category {
        background-color:{{$restaurant->button_color}}!important;
        border-color: {{$restaurant->button_color}}!important;
    }
    #closeButton{
        background-color:{{$restaurant->button_color}}!important;
    }
    .border-top-custom .amount div{
        color:{{$restaurant->button_color}}!important;
    }
    .quantity-btn{
        background-color:{{$restaurant->button_color}}!important;
    }
    .quantity-input{
        border-color:{{$restaurant->button_color}}!important;
    }
    .language-menu.active-category{
        background-color:{{$restaurant->button_color}}!important;
    }
    </style>
@endpush
<section class="container-fluid mx-auto flex header-section h-screen">
    <div class="w-1/4 bg-white text-black h-screen p-4 overflow-y-auto menu-sidebar">
        <ul class="mt-6">
            @foreach ($categoires as $key => $category)
                <li class="menu-items sidebar-options {{ $selectedCategoryId == $category->id ? 'selected-active-category' : '' }}">
                    <div style="display: flex; align-items: center;">
                        @if (isset($category->icon) && !is_null($category->icon) && !empty($category->icon) && ($category->icon_available == 1))
                            <img src="{{ asset('storage/'.$category->icon) }}" class="category-sidebar-image">
                        @elseif($category->icon_available == 1)
                            <img src="{{ isset($category->category_image_url) ? $category->category_image_url : asset('assets/images/default_category.png') }}" class="category-sidebar-image">
                        @endif
                        <a href="{{ route('restaurant.menu.item', ['restaurant' => $restaurant->slug, 'food_category' => $category->id]) }}" class="block p-3 rounded hover:bg-gray-700 f-1rem no-wrap {{ ($category->icon_available == 0) ? 'additional-spacing-sidebar-menu' : '' }}">
                            {{ $category->local_lang_name }}
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="w-full p-4 overflow-y-auto h-screen pt-custom">
        <div class="category-slider mb-5 mt-5 fixed-slider">
            <div class="slider-container">
                @foreach ($categoires ?? [] as $category)
                    <a class="category-button{{ $selectedCategoryId == $category->id ? ' active-menu-button' : '' }}" href="{{ route('restaurant.menu.item', ['restaurant' => $restaurant->slug, 'food_category' => $category->id]) }}">
                        <span>
                            @if (isset($category->icon) && !is_null($category->icon) && !empty($category->icon) && ($category->icon_available == 1))
                                <img src="{{ asset('storage/'.$category->icon) }}" class="category-image" alt="Category Image">
                            @elseif($category->icon_available == 1)
                                <img src="{{ isset($category->category_image_url) ? $category->category_image_url : asset('assets/images/default_category.png') }}" class="category-image" alt="Category Image">
                            @endif
                        </span>
                        <span>{{ $category->local_lang_name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5 xl:gap-8 pb-12 md:pb-10 -mt-3 mt-50px">

            @include('frontend.food_list')
            <p class="font-bold dark:text-white name truncate not_found hidden custome">
                {{ __('system.messages.food_not_found') }}
            </p>
        </div>
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

        });

        $(document).ready(function() {
            var lastScrollTop = 0; // Store the last scroll position
            var $categorySlider = $(".category-slider"); // Cache the slider

            $(window).on("scroll", function() {
                var st = $(this).scrollTop(); // Get current scroll position

                if (st > lastScrollTop) {
                    // Scrolling down
                    if ($(window).width() <= 1024) { // Apply only on mobile
                        $categorySlider.css("z-index", "10000"); // Set z-index when scrolling down
                    }
                } else {
                    // Scrolling up
                    if ($(window).width() <= 1024) { // Apply only on mobile
                        if (st === 0) {
                            // Scrolled to the top
                            $categorySlider.css("z-index", "revert-layer"); // Reset z-index when at the top
                        }
                    }
                }

                lastScrollTop = st <= 0 ? 0 : st; // Ensure scroll position doesn't go negative
            });
        });

        $(document).ready(function() {
            function serch(search) {
                search = search.toLowerCase();
                $(".food-item").show();
                $(document).find(".not_found").hide();
                if (search == '') {
                    $(".food-item").show();
                    $('.not_found.custome').hide();
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
                        $(document).find(".not_found.custome").show();
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
