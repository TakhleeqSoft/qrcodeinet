@extends('frontend.master')
@section('content')
    <div class="container">
        <div class="overflow-x-auto mb-4 scrollbar-thin scrollbar-thumb-primary scrollbar-track-[#d1d7e7]">
            <div class="flex w-max justify-between gap-4 py-8 lg:py-12 font-semibold dark:text-white" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                @php($default_category_image = !empty($restaurant->vendor_setting->default_category_image) ? getFileUrl($restaurant->vendor_setting->default_category_image) : asset('assets/images/default_category.png'))
                @foreach ($food_categories ?? [] as $key => $category)
                    <div class="text-center w-40 xl:w-auto {{ $key == 0 ? 'actives' : '' }} cursor-pointer " id="profile{{ $category->id }}-tab" data-tabs-target="#profile{{ $category->id }}" type="button" role="tab"
                        aria-controls="profile{{ $category->id }}">
                        <img src="{{ $category->category_image_url }}" onerror="this.src='{{ $default_category_image }}'" alt="" class="mx-auto w-24 h-24 rounded-full border border-2  border-transparent " />
                        <a href="javascript:" class="mt-3 inline-block line-clamp-3">{{ $category->local_lang_name }}</a>
                    </div>
                @endforeach

            </div>
        </div>
        <div id="myTabContent">
            @foreach ($food_categories ?? [] as $key => $category)
                <div class="pb-12 md:pb-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 xl:gap-8  {{ $key == 0 ? 'active' : 'hidden' }} tab-pane" id="profile{{ $category->id }}" role="tabpanel"
                    aria-labelledby="profile{{ $category->id }}-tab">
                    @include('frontend.food_list', ['foods' => $category->foods ?? []])

                </div>
            @endforeach

        </div>
        <p class="font-bold dark:text-white name truncate not_found" style="{{ count($food_categories ?? []) > 0 ? 'display:none;' : '' }}">
            {{ __('system.messages.food_not_found') }}</p>
    </div>
@endsection
@push('page_js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '[role=tab]', function() {
                var _target = $(this).data('tabs-target')
                $(document).find("#myTabContent .active").addClass('hidden')
                $(document).find("#myTabContent .active").removeClass('active')
                $(document).find(_target).removeClass('hidden')
                $(document).find(_target).addClass('active')
                $(document).find("#myTab .actives").removeClass('actives')
                $(this).addClass('actives')
            })


            function serch(search) {
                search = search.toLowerCase();

                if (search == '') {

                    $(".food-item").show();
                    $(document).find(".not_found.custome").hide();
                } else {
                    $(".food-item").show();
                    search = search.replace('\\', '\\\\');
                    $(document).find('.tab-pane').each(function() {
                        var x = 0;
                        $(this).find('.food-item').each(function() {
                            if (!$(this).hasClass('not_found')) {
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
                                    x++;
                                }
                            }

                        });
                        if (x == $(this).find('.food-item').length) {
                            $(this).find(".not_found").show();
                        } else {
                            $(this).find(".not_found").hide();
                        }

                    });

                }
            }

            $(document).on('keyup', '.search-text', function() {
                var search = $(this).val();
                serch(search)
            })
        })
    </script>
@endpush
