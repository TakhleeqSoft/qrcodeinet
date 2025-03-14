@push('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/product-details-style.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <?php $default_food_image = !empty($restaurant->vendor_setting->default_food_image) ? getFileUrl($restaurant->vendor_setting->default_food_image) : asset('assets/images/default_food.png'); ?>



        <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        .quantity-btn{
            background-color:{{$product->restaurant->button_color}}!important;
        }
        .quantity-input{
            border-color:{{$product->restaurant->button_color}}!important;
        }
        .cart-item-price{
            color:{{$product->restaurant->button_color}}!important;
        }
    </style>

    <body>


    <div class="container mx-auto py-8 mt-20">
        <div style="    text-align: center;">
            <a class="btn-back" href="https://menu.albaytaldamashqi.com/albaytaldamashqist">رجوع</a></div>

        <div class="flex flex-col lg:flex-row bg-white shadow-lg rounded-lg p-6 items-center margin-products ">
            <div class="lg:w-1/2 w-full text-center">

                <img
                    src="{{ !empty($product->food_image) ? asset('storage/' . $product->food_image) : $default_food_image }}"
                    alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md">
            </div>

            <div class="lg:w-1/2 w-full text-left lg:pl-10 mt-6 lg:mt-0 text-preview">
                <h2 style="color: {{$product->restaurant->button_color}}"
                    class="text-3xl font-bold  mb-4 text-preview">{{ $product->name }}</h2>
                <p style="color: {{$product->restaurant->button_color}}"
                   class="text-xl text-primary font-semibold mb-6">{{ $currency }} {{ number_format($product->price, 2) }}</p>
                <button
                    class="text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition duration-300 add-to-cart-btn bt"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-currency="{{ $currency }}"
                    style="background: {{$product->restaurant->button_color}}"
                    data-image="{{ !empty($product->food_image) ? asset('storage/' . $product->food_image) : $default_food_image }}">
                    <i class="fas fa-cart-plus"></i> أضف إلى العربة
                </button>

            </div>
        </div>


        <div class="related-products mt-10">
            <h3 style="color: {{$product->restaurant->button_color}}" class=" centered-txt text-2xl font-bold mb-6  item-center">منتجات مشابهة</h3>
            <div class="product-list grid gap-6 margin-products">
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="related-product-item">
                        <a href="{{ url($username . '/product/' . $relatedProduct->id) }}">
                            <img
                                src="{{ !empty($relatedProduct->food_image) ? asset('storage/' . $relatedProduct->food_image) : $default_food_image }}"
                                alt="{{ $relatedProduct->name }}"
                                class="w-full h-48 object-cover"
                                onerror="this.src='{{ $default_food_image }}'"
                            />

                            <p class="related-product-name">{{ $relatedProduct->name }}</p>
                        </a>


                        <div class="related-product-footer">
                            <span style="color: {{$product->restaurant->button_color}}!important;"
                                class="related-product-price">{{ $currency }} {{ number_format($relatedProduct->price, 2) }}</span>
                            <button style="background: {{$product->restaurant->button_color}}!important;border-color:{{$product->restaurant->button_color}}!important; " class="bg-add-custom add-to-cart-btn" data-name="{{ $relatedProduct->name }}"
                                    data-price="{{ $relatedProduct->price }}" data-currency="{{ $currency }}"
                                    data-image="{{ !empty($relatedProduct->food_image) ? asset('storage/' . $relatedProduct->food_image) : $default_food_image }}">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="sidebar-cart">

        <div class="p-4 border-b">
            <button id="close-sidebar-btn">x</button>
            <h3 class="font-bold text-items-select" style=" color: {{$product->restaurant->button_color}}; ">العناصر المختارة</h3>
        </div>

        <div id="selected-items" class="p-4 selected-items"></div>
        <div class="p-4 border-t font-bold centered-txt">
            <span>المجموع: </span>
            <span id="total-price" class="centered-txt"> 0.00</span>
        </div>
    </div>


    <!-- زر عائم للعربة -->
    <div id="cart-button" style="background: {{$product->restaurant->button_color}}!important;">
        <span id="cart-total-amount"> 0.00</span>
        <i class="fas fa-shopping-cart"></i>

    </div>

    <script>
        $(document).ready(function () {
            // استرجاع بيانات العربة من LocalStorage
            let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
            let totalPrice = parseFloat(localStorage.getItem('totalPrice')) || 0;

            // جلب العملة الحالية والموضع من قاعدة البيانات عند تحميل الصفحة
            const currency = "{{ \DB::table('vendor_settings')->where('user_id',@$product->restaurant->user_id ?? 0)->value('default_currency_symbol') }}";
            const currencyPosition = "{{ \DB::table('vendor_settings')->where('user_id',@$product->restaurant->user_id ?? 0)->value('default_currency_position') }}";

            // تحديث العربة عند تحميل الصفحة
            updateCart();

            // عند الضغط على زر "+" لإضافة الطعام
            $(document).on('click', '.add-to-cart-btn', function () {
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
                    cartItems.push({name, price, image, quantity: 1});
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
                <div class="flex justify-between items-center p-4 border-b      del-btn-centred">

                    <button class="clear-cart-btn bg-red-500 text-white px-3 py-1 rounded">
                        <i class="fas fa-trash-alt"></i> حذف الكل
                    </button>
                </div>
            `;

                cartItems.forEach((item, index) => {
                    const formattedPrice = `${item.price.toFixed(2)} ${item.currency || ''}`;
                    itemsHtml += `
                    <div class="cart-item flex justify-between items-center p-4 border-b">
                    <div class="quantity-controls flex items-center">
                            <button class="quantity-btn decrement-btn bg-gray-200 px-2" data-index="${index}">-</button>
                            <input type="text" value="${item.quantity}" class="quantity-input w-10 text-center" readonly>
                            <button class="quantity-btn increment-btn bg-gray-200 px-2" data-index="${index}">+</button>
                        </div>

                        <div class="cart-item-details flex-1 text-right del-btn-centred">
                            <span class="cart-item-name block font-bold">${item.name}</span>
                            <span class="cart-item-price block">${formattedPrice}</span>
                        </div>
                                                <img src="${item.image}" alt="${item.name}" class="cart-item-image w-12 h-12">

                        <button class="remove-item-btn text-red-500" data-index="${index}">x</button>
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
            $(document).on('click', '.increment-btn', function () {
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
            $(document).on('click', '.decrement-btn', function () {
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
            $(document).on('click', '.remove-item-btn', function () {
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
            $('#cart-button').on('click', function () {
                $('#sidebar-cart').toggleClass('open');
            });

            // إغلاق القائمة عند النقر خارجها فقط إذا كانت مفتوحة
            $(document).on('click', function (e) {
                if (!$(e.target).closest('#sidebar-cart, #cart-button').length && $('#sidebar-cart').hasClass('open')) {
                    $('#sidebar-cart').removeClass('open');
                }
            });
            $(document).on('click', '.increment-btn, .decrement-btn, .remove-item-btn', function (event) {
                console.log('Event Triggered:', event.type, 'on', event.target);
                $('#sidebar-cart').addClass('open');
            });
            $(document).on('click', '.increment-btn, .decrement-btn, .remove-item-btn', function () {
                setTimeout(function () {
                    $('#sidebar-cart').addClass('open');
                }, 0); // تأخير بسيط للتأكد من بقاء القائمة مفتوحة
            });

            $(document).ready(function () {
                // إضافة حدث للنقر على زر "x" لإغلاق القائمة الجانبية
                $('#close-sidebar-btn').on('click', function () {
                    $('#sidebar-cart').removeClass('open'); // إغلاق القائمة
                });

                // باقي الكود المرتبط بالقائمة الجانبية هنا ...
            });
            // حذف جميع العناصر
            $(document).on('click', '.clear-cart-btn', function () {
                cartItems = [];
                totalPrice = 0;
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
                localStorage.setItem('totalPrice', totalPrice.toFixed(2));
                updateCart();
                $('#sidebar-cart').addClass('open'); // إبقاء القائمة مفتوحة بعد حذف جميع العناصر.
            });


        });

        $(document).ready(function () {
            $(document).on('click', '.add-to-cart-btn', function () {
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
                floatImage.on('transitionend', function () {
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
        $('#sidebar-cart').on('touchstart', (e) => {
            startX = e.originalEvent.touches[0].clientX;
            $('#sidebar-cart').css('transition', 'none'); // تعطيل الانتقال أثناء السحب لجعل السحب أكثر انسيابية
        });

        // حدث السحب
        $('#sidebar-cart').on('touchmove', (e) => {
            const distance = Math.max(e.originalEvent.touches[0].clientX - startX, maxSwipeDistance);
            if (distance < 0) $('#sidebar-cart').css('transform', `translateX(${distance}px)`); // تحريك القائمة مع السحب لليسار
        });

        // حدث الإفلات
        $('#sidebar-cart').on('touchend', (e) => {
            const distance = e.originalEvent.changedTouches[0].clientX - startX;
            $('#sidebar-cart').css('transition', 'transform 0.4s cubic-bezier(0.25, 0.8, 0.5, 1)'); // إضافة الانتقال عند الإفلات
            toggleSidebarCart(distance >= swipeThreshold); // تحديد حالة الفتح/الإغلاق بناءً على المسافة
        });
        $(document).ready(function () {
            $('.margin-products').css('opacity', 0).each(function (index) {
                $(this).delay(index * 200).animate({opacity: 1}, 400);
            });
        });

    </script>

    </body>
