<div id="myModal" class="modal fade relative hidden z-20" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="container">
                <div class="transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative">
                        <button class="absolute right-2  top-2 z-10 close-model">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                        <div class="flex flex-col md:flex-row gap-5">
                            <div
                                class="flex-none md:w-[500px] lg:w-[580px] md:max-w-[500px] lg:max-w-[580px] flex flex-row gap-3">
                                <div class="flex-1 swiper mySwiper2">
                                    <div class="swiper-wrapper">
                                        @php
                                            $default_food = !empty($vendor_setting->default_food_image) ? getFileUrl($vendor_setting->default_food_image) : asset('assets/images/default_food.png');
                                            $discount = getUsdDiscountPrice($food->discount_price, $food->discount_type, $restaurant->vendor_setting->default_currency_symbol ?? null, $restaurant->vendor_setting->default_currency_position ?? null);
                                        @endphp
                                        @foreach ($food->gallery_images_slider_data as $img)
                                            <div class="swiper-slide cursor-grabbing">
                                                <img src="{{ $img['src'] }}"
                                                    onerror="this.src='{{ $default_food }}'"
                                                    alt="{{ $img['title'] ?? '' }}"
                                                    class="w-full h-full object-cover cursor-pointer lazyload" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div thumbsSlider=""
                                    class="-order-1 flex-none max-w-[50px] md:max-w-[100px] h-[217px] sm:h-[543px] lg:h-[562px] swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($food->gallery_images_slider_data as $img)
                                            <div class="swiper-slide h-full cursor-grabbing">
                                                <img src="{{ $img['src'] }}"
                                                    onerror="this.src='{{ $default_food }}'"
                                                    alt="{{ $img['title'] ?? '' }}"
                                                    class="w-full h-full object-cover cursor-pointer lazyload" />
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="flex-1 space-y-5">
                                <h3 class="font-bold text-xl">{{ $food->local_lang_name }}</h3>
                                <div class="xs:flex !mt-1">
                                    @foreach ($food->food_categories->pluck('local_lang_name') as $name)
                                        <span class="text-sm inline-block  px-2 py-1 leading-none text-center whitespace-nowrap  bg-primary text-white rounded mx-1">{{ $name }}</span>
                                    @endforeach
                                </div>
                                <ul class="font-bold space-y-1 text-black/70">
                                    <li>
                                        @php
                                            $discounted_price = $food->usd_discounted_price;
                                        @endphp
                                        @if ($discounted_price != null)
                                            <div>
                                                <span
                                                    class="font-semibold text-lg">{{ $food->usd_discounted_price }}</span>
                                            </div>
                                            <div>
                                                <del class="font-semibold">{{ $food->usd_price }}</del>
                                                <span
                                                    class="text-[#52d352de]">{{ $discount }}
                                                    {{ trans('system.fields.off') }}</span>
                                            </div>
                                        @else
                                            <div>
                                                <span
                                                    class="font-semibold text-lg">{{ $food->usd_price }}</span>
                                            </div>
                                        @endif
                                    </li>
                                    @if (isset($restaurant_setting->allow_show_preparation_time) && $restaurant_setting->allow_show_preparation_time == true)
                                        @isset($food->preparation_time)
                                            <li>{{ __('system.fields.preparation_time') }}: <span
                                                    class="font-semibold">{{ $food->preparation_time }}</span></li>
                                        @endisset
                                    @endif

                                    @if (isset($restaurant_setting->allow_show_allergies) && $restaurant_setting->allow_show_allergies == true)
                                        @isset($food->allergy)
                                            <li>{{ __('system.fields.allergies') }}: <span
                                                    class="font-semibold">{{ $food->local_lang_allergy }}</span></li>
                                        @endisset
                                    @endif
                                    @if (isset($restaurant_setting->allow_show_calories) && $restaurant_setting->allow_show_calories == true)
                                        @isset($food->calories)
                                            <li>{{ __('system.fields.calories') }}: <span
                                                    class="font-semibold">{{ $food->local_lang_calories }}</span></li>
                                        @endisset
                                    @endif
                                </ul>
                                @isset($food->local_lang_description)
                                    <p class="text-sm">{{ $food->local_lang_description }}</p>
                                    @endif
                                    @if ($food->local_custom_field)
                                        <div>
                                            <h4 class="font-bold text-base mb-2">{{ __('system.fields.specifications') }} :
                                            </h4>
                                            <div class="max-h-[350px] overflow-x-hidden">
                                                <table class="border-collapse border border-black/20 w-full text-sm ">
                                                    <tbody>
                                                        @foreach ($food->local_custom_field as $k => $v)
                                                            <tr>
                                                                <th class="border border-black/20 px-4 py-2 font-normal">
                                                                    <b>{{ $k }}</b>
                                                                </th>
                                                                <td class="border border-black/20 px-4 py-2">
                                                                    {{ $v }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class=" bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
