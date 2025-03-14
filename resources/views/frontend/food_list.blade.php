@push('page_css')
    <link rel="stylesheet" href="{{ asset('assets/cdns/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-category.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/food_list.blade.css') }}">
<script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>


@php
$usd_price = $food->usd_price ?? 0;
@endphp

    <style>
.float-image {
    position: absolute;
    width: 50px;
    height: 50px;
    z-index: 1000;
    border-radius: 10px;
    transition: transform 1s cubic-bezier(0.25, 0.8, 0.5, 1), opacity 1s;
    pointer-events: none;
    transform: translate(50%, 50%); /* هذا يحرك الصورة إلى المركز */
    opacity: 1; /* اجعلها مرئية بشكل افتراضي */
}

.float-image.hidden {
    opacity: 0; /* اجعلها غير مرئية عند الحاجة */
}

.add-to-cart-btn{
    background-color:{{$restaurant->button_color}}!important;
    border-color: {{$restaurant->button_color}}!important;
}

#cart-button{
    background-color:{{$restaurant->button_color}}!important;
    border-color: {{$restaurant->button_color}}!important;
}
#closeButton{
    background-color:{{$restaurant->button_color}}!important;
}
.language-menu.active-category{
    background-color:{{$restaurant->button_color}}!important;
}
    </style>
@endpush

@if (isset($foods) && count($foods) > 0)
    <?php $default_food_image = !empty($restaurant->vendor_setting->default_food_image) ? getFileUrl($restaurant->vendor_setting->default_food_image) : asset('assets/images/default_food.png'); ?>




@if (isset($foods) && count($foods) > 0)
    @foreach ($foods as $food)
        @php
        $currency = \DB::table('vendor_settings')->where('user_id',$restaurant->user_id)->value('default_currency_symbol') ?? 'USD';
        $currency_position = \DB::table('vendor_settings')->value('default_currency_position') ?? 'right';
        $discounted_price = $food->discounted_price ?? $food->price;

        if (empty($discounted_price) || !is_numeric($discounted_price)) {
            $discounted_price = 0;
        }

        $price = number_format($discounted_price, 2, '.', '');
        $formatted_price = $currency_position === 'left' ? $currency . ' ' . $price : $price . ' ' . $currency;

        // جلب اسم المستخدم للمطعم من جدول restaurants
        $restaurant_slug = \DB::table('restaurants')->where('id', $food->restaurant_id)->value('slug');
        @endphp

        <div class="bg-white dark:bg-secondary/50 rounded-xl shadow-shadowitem hover:shadow-shadowdark transition transform hover:-translate-y-2 duration-300 food-item">
            <a href="{{ url($restaurant_slug . '/product/' . $food->id) }}">
            <img src="{{ !$food->is_default_image ? $food->food_image_url : $default_food_image }}"
     alt="{{ $food->local_lang_name }}"
     class="w-full rounded-t-xl h-32 sm:h-56 object-cover popup-slider"
     onerror="this.src='{{ $default_food_image }}'" />

            </a>

            <div class="p-4 flex flex-col justify-between h-full">
                <p class="font-bold dark:text-white name truncate mb-4">{{ $food->local_lang_name }}</p>

                <div class="flex justify-between items-center mt-auto border-top-custom">
                    <div class="text-primary font-bold text-sm color-brown dark:text-white amount">
                        <div class="text-sm color-brown">{{ $formatted_price }}</div>
                    </div>

                    <button class="bg-add-custom add-to-cart-btn"
                        data-name="{{ $food->local_lang_name }}"
                        data-price="{{ $price }}"
                        data-currency="{{ $currency }}"
                        data-currency-position="{{ $currency_position }}"
                        data-image="{{ !$food->is_default_image ? $food->food_image_url : $default_food_image }}">
                          <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="font-bold dark:text-white name truncate not_found"> {{ __('system.messages.food_not_found') }}</p>
@endif



@else
    <p class="font-bold dark:text-white name truncate not_found"> {{ __('system.messages.food_not_found') }}</p>
@endif

@push('page_js')
    <script type="text/javascript" src="{{ asset('assets/cdns/jquery.magnific-popup.min.js') }}"></script>

<!-- Cart Floating Button -->
<div id="cart-button">
    <i class="fas fa-shopping-cart"></i>
    <span id="cart-total-amount"> 0.00</span>
</div>

<!-- Sidebar for Selected Foods (Hidden by default) -->
<div id="sidebar-cart" style="    z-index: 12000;">
    <button id="close-sidebar-btn">x</button> <!-- زر "x" لإغلاق القائمة -->
    <div class="p-4  " style=" ">
        <h3 class="font-bold"  style=" color: {{$restaurant->button_color}}!important;  border-bottom: 1px solid {{$restaurant->button_color}};">العناصر المختارة</h3>
    </div>
    <div id="selected-items" class="p-4">
        <!-- Items will be added here dynamically -->
    </div>
    <div class="p-4 border-t font-bold">
        <span>المجموع: </span>
        <span id="total-price"> 0.00</span>
    </div>
</div>

<script>
 $(document).ready(function() {
    // استرجاع بيانات العربة من LocalStorage
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    let totalPrice = parseFloat(localStorage.getItem('totalPrice')) || 0;

    // جلب العملة الحالية والموضع من قاعدة البيانات عند تحميل الصفحة
    const currency = "{{ \DB::table('vendor_settings')->where('user_id',$restaurant->user_id)->value('default_currency_symbol') }}";
    const currencyPosition = "{{ \DB::table('vendor_settings')->where('user_id',$restaurant->user_id)->value('default_currency_position') }}";

    // تحديث العربة عند تحميل الصفحة
    updateCart();

    // عند الضغط على زر "+" لإضافة الطعام
    $(document).on('click', '.add-to-cart-btn', function() {
        const name = $(this).data('name');
        const price = Number($(this).data('price'));
        const image = $(this).data('image');

        // التحقق مما إذا كان العنصر موجود بالفعل في العربة
        let itemExists = false;
        cartItems.forEach(item => {
            if (item.name === name) {
                item.quantity += 1; // زيادة الكمية إذا كان العنصر موجودًا
                totalPrice += price;
                itemExists = true;
            }
        });

        // إذا لم يكن العنصر موجودًا في العربة، أضفه
        if (!itemExists) {
            cartItems.push({ name, price, image, quantity: 1 });
            totalPrice += price;
        }

        // حفظ البيانات في LocalStorage
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        localStorage.setItem('totalPrice', totalPrice.toFixed(2));

        // تحديث محتويات العربة
        updateCart();

        // التأكد من بقاء القائمة مفتوحة بعد إضافة العناصر
        $('#sidebar-cart').addClass('open');
    });

    // تحديث محتويات العربة
        function updateCart() {
            let itemsHtml = `
                <div class="flex justify-between items-center p-4 border-b centred-btn ">

                    <button class="clear-cart-btn bg-red-500 text-white px-3 py-1 rounded centred-color">
                        <i class="fas fa-trash-alt"></i> حذف الكل
                    </button>
                </div>
            `;

            cartItems.forEach((item, index) => {
                const formattedPrice = `${item.price.toFixed(2)} ${item.currency || ''}`;
                itemsHtml += `
                    <div class="cart-item flex justify-between items-center p-4 border-b">
                        <button class="remove-item-btn text-red-500" data-index="${index}">x</button>
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image w-12 h-12">
                        <div class="cart-item-details flex-1 text-right">
                            <span class="cart-item-name block font-bold">${item.name}</span>
                            <span class="cart-item-price block">${formattedPrice}</span>
                        </div>
                        <div class="quantity-controls flex items-center">
                            <button class="quantity-btn decrement-btn bg-gray-200 px-2" data-index="${index}">-</button>
                            <input type="text" value="${item.quantity}" class="quantity-input quantity-input w-10 text-center" readonly>
                            <button class="quantity-btn increment-btn bg-gray-200 px-2" data-index="${index}">+</button>
                        </div>
                    </div>
                `;
            });

            $('#selected-items').html(itemsHtml);
            $('#total-price').text(totalPrice.toFixed(2));
            $('#cart-total-amount').text(totalPrice.toFixed(2));

        // إذا كانت العربة فارغة، أغلق القائمة الجانبية وصفر المجموع
        if (cartItems.length === 0) {
            totalPrice = 0; // تصفير المجموع
            $('#total-price').text(`0.00 ${currency}`);
            $('#cart-total-amount').text(`0.00 ${currency}`);
            $('#sidebar-cart').removeClass('open');
            // إزالة القيم من LocalStorage
            localStorage.setItem('totalPrice', '0.00');
            localStorage.setItem('cartItems', JSON.stringify([]));
        }
    }

    // زيادة الكمية عند الضغط على زر "+"
    $(document).on('click', '.increment-btn', function() {
        const index = $(this).data('index');
        const item = cartItems[index];

        if (item) {
            item.quantity += 1; // زيادة الكمية
            totalPrice += item.price; // زيادة السعر الكلي

            // حفظ البيانات المحدثة في LocalStorage
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            localStorage.setItem('totalPrice', totalPrice.toFixed(2));

            updateCart(); // تحديث محتويات العربة
        }

        // التأكد من بقاء القائمة مفتوحة
        $('#sidebar-cart').addClass('open');
    });

    // إنقاص الكمية عند الضغط على زر "-"
    $(document).on('click', '.decrement-btn    ', function() {
        const index = $(this).data('index');
        const item = cartItems[index];

        if (item && item.quantity > 1) {
            item.quantity -= 1; // إنقاص الكمية
            totalPrice -= item.price; // خصم السعر من المجموع الكلي

            // حفظ البيانات المحدثة في LocalStorage
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            localStorage.setItem('totalPrice', totalPrice.toFixed(2));

            updateCart(); // تحديث محتويات العربة
        }

        // التأكد من بقاء القائمة مفتوحة
        $('#sidebar-cart').addClass('open');
    });

    // إزالة عنصر من العربة
    $(document).on('click', '.remove-item-btn', function() {
        const index = $(this).data('index');
        const item = cartItems[index];

        if (item) {
            totalPrice -= item.price * item.quantity; // خصم السعر الكلي للعنصر بناءً على الكمية
            cartItems.splice(index, 1); // إزالة العنصر من القائمة

            // تحديث LocalStorage بعد إزالة العنصر
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            localStorage.setItem('totalPrice', totalPrice.toFixed(2));

            updateCart();

            // التأكد من بقاء القائمة مفتوحة بعد الحذف إذا كان هناك عناصر متبقية
            if (cartItems.length > 0) {
                $('#sidebar-cart').addClass('open');
            }
        }
    });

    // التأكد من فتح القائمة الجانبية عند الضغط على الزر العائم
    $('#cart-button').on('click', function() {
        $('#sidebar-cart').toggleClass('open');
    });

    // إغلاق القائمة عند النقر خارجها فقط إذا كانت مفتوحة
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#sidebar-cart, #cart-button').length && $('#sidebar-cart').hasClass('open')) {
            $('#sidebar-cart').removeClass('open');
        }
    });
    $(document).on('click', '.increment-btn, .decrement-btn    , .remove-item-btn', function(event) {
    console.log('Event Triggered:', event.type, 'on', event.target);
    $('#sidebar-cart').addClass('open');
    });
    $(document).on('click', '.increment-btn, .decrement-btn    , .remove-item-btn', function() {
        setTimeout(function() {
            $('#sidebar-cart').addClass('open');
        }, 0); // تأخير بسيط للتأكد من بقاء القائمة مفتوحة
    });

    $(document).ready(function() {
        // إضافة حدث للنقر على زر "x" لإغلاق القائمة الجانبية
        $('#close-sidebar-btn').on('click', function() {
            $('#sidebar-cart').removeClass('open'); // إغلاق القائمة
        });

        // باقي الكود المرتبط بالقائمة الجانبية هنا ...
    });
      // حذف جميع العناصر
        $(document).on('click', '.clear-cart-btn', function() {
            cartItems = [];
            totalPrice = 0;
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            localStorage.setItem('totalPrice', totalPrice.toFixed(2));
            updateCart();
            $('#sidebar-cart').addClass('open'); // إبقاء القائمة مفتوحة بعد حذف جميع العناصر.
        });


});
$(document).ready(function() {
    $(document).on('click', '.add-to-cart-btn', function() {
        const imageSrc = $(this).data('image'); // احصل على رابط صورة العنصر
        const cartOffset = $('#cart-button').offset(); // موقع زر السلة
        const buttonOffset = $(this).offset(); // موقع الزر المضاف منه

        // إنشاء صورة عائمة مؤقتة
        const floatImage = $('<img src="' + imageSrc + '" class="float-image">');
        $('body').append(floatImage);

        // تحديد موقع الصورة العائمة فوق الزر
        floatImage.css({
            top: buttonOffset.top,
            left: buttonOffset.left
        });

        // تطبيق التحريك لنقل الصورة نحو السلة
        setTimeout(() => {
            floatImage.css({
                transform: `translate(${cartOffset.left - buttonOffset.left}px, ${cartOffset.top - buttonOffset.top}px)`,
                opacity: 0
            });

            // إضافة تأثير الاهتزاز لزر السلة
            $('#cart-button').addClass('shake');

            // إزالة الفئة بعد الانتهاء من الاهتزاز
            setTimeout(() => {
                $('#cart-button').removeClass('shake');
            }, 500); // يجب أن تتطابق مع مدة الاهتزاز في CSS
        }, 100);

        // إزالة الصورة العائمة بعد انتهاء التحريك
        floatImage.on('transitionend', function() {
            floatImage.remove();
        });
    });
});



let startX;
const swipeThreshold = -70;
const maxSwipeDistance = -250;

// دالة للتحكم في فتح أو إغلاق القائمة مع انسيابية
function toggleSidebarCart(open) {
    $('#sidebar-cart').toggleClass('open', open).css({
        'transform': '',
        'transition': 'transform 0.4s cubic-bezier(0.25, 0.8, 0.5, 1)'
    });
}

// حدث بداية السحب
document.getElementById('sidebar-cart').addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    document.getElementById('sidebar-cart').style.transition = 'none'; // تعطيل الانتقال أثناء السحب لجعل السحب أكثر انسيابية
}, { passive: true }); // جعل الحدث "passive"

// حدث السحب
document.getElementById('sidebar-cart').addEventListener('touchmove', (e) => {
    const distance = Math.max(e.touches[0].clientX - startX, maxSwipeDistance);
    if (distance < 0) document.getElementById('sidebar-cart').style.transform = `translateX(${distance}px)`; // تحريك القائمة مع السحب لليسار
}, { passive: true }); // جعل الحدث "passive"

// حدث الإفلات
document.getElementById('sidebar-cart').addEventListener('touchend', (e) => {
    const distance = e.changedTouches[0].clientX - startX;
    document.getElementById('sidebar-cart').style.transition = 'transform 0.4s cubic-bezier(0.25, 0.8, 0.5, 1)'; // إضافة الانتقال عند الإفلات
    toggleSidebarCart(distance >= swipeThreshold); // تحديد حالة الفتح/الإغلاق بناءً على المسافة
});

 $(document).ready(function() {
    $('.food-item').css('opacity', 0).each(function(index) {
        $(this).delay(index * 200).animate({ opacity: 1 }, 400);
    });
});


</script>
@endpush
