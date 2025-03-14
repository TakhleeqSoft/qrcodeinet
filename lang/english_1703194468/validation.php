<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما يكون :other هو :value.',
    'active_url' => ':attribute ليس عنوان URL صحيح.',
    'after' => ':attribute يجب أن يكون تاريخًا بعد :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخًا بعد أو يساوي :date.',
    'alpha' => ':attribute يجب أن يحتوي فقط على حروف.',
    'alpha_dash' => ':attribute يجب أن يحتوي فقط على حروف وأرقام وشرطات وشرطات سفلية.',
    'alpha_num' => ':attribute يجب أن يحتوي فقط على حروف وأرقام.',
    'array' => ':attribute يجب أن يكون مصفوفة.',
    'before' => ':attribute يجب أن يكون تاريخًا قبل :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخًا قبل أو يساوي :date.',
    'between' => [
        'array' => ':attribute يجب أن يكون بين :min و :max عنصر.',
        'file' => ':attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'string' => ':attribute يجب أن يكون بين :min و :max حرف.',
    ],
    'boolean' => 'يجب أن يكون حقل :attribute صحيحًا أو خاطئًا.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => ':attribute ليس تاريخًا صحيحًا.',
    'date_equals' => ':attribute يجب أن يكون تاريخًا مساويًا لـ :date.',
    'date_format' => ':attribute لا يتطابق مع التنسيق :format.',
    'declined' => 'يجب رفض :attribute.',
    'declined_if' => 'يجب رفض :attribute عندما يكون :other هو :value.',
    'different' => ':attribute و :other يجب أن يكونوا مختلفين.',
    'digits' => ':attribute يجب أن يكون :digits أرقام.',
    'digits_between' => ':attribute يجب أن يكون بين :min و :max أرقام.',
    'dimensions' => ':attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_start_with' => ':attribute قد لا يبدأ بأحد القيم التالية: :values.',
    'email' => ':attribute يجب أن يكون عنوان بريد إلكتروني صحيح.',
    'ends_with' => ':attribute يجب أن ينتهي بأحد القيم التالية: :values.',
    'enum' => 'القيمة المحددة :attribute غير صحيحة.',

    'exists' => 'القيمة المحددة :attribute غير صحيحة.',
    'file' => ':attribute يجب أن يكون ملفًا.',
    'filled' => 'يجب أن يحتوي حقل :attribute على قيمة.',
    'gt' => [
        'array' => ':attribute يجب أن يحتوي على أكثر من :value عنصر.',
        'file' => ':attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'numeric' => ':attribute يجب أن يكون أكبر من :value.',
        'string' => ':attribute يجب أن يكون أكبر من :value حرف.',
    ],
    'gte' => [
        'array' => ':attribute يجب أن يحتوي على :value عنصر أو أكثر.',
        'file' => ':attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => ':attribute يجب أن يكون أكبر من أو يساوي :value.',
        'string' => ':attribute يجب أن يكون أكبر من أو يساوي :value حرف.',
    ],
    'image' => ':attribute يجب أن يكون صورة.',
    'in' => 'القيمة المحددة :attribute غير صحيحة.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => ':attribute يجب أن يكون عددًا صحيحًا.',
    'ip' => ':attribute يجب أن يكون عنوان IP صحيحًا.',
    'ipv4' => ':attribute يجب أن يكون عنوان IPv4 صحيحًا.',
    'ipv6' => ':attribute يجب أن يكون عنوان IPv6 صحيحًا.',
    'json' => ':attribute يجب أن يكون نص JSON صحيحًا.',
    'lt' => [
        'array' => ':attribute يجب أن يحتوي على أقل من :value عنصر.',
        'file' => ':attribute يجب أن يكون أقل من :value كيلوبايت.',
        'numeric' => ':attribute يجب أن يكون أقل من :value.',
        'string' => ':attribute يجب أن يكون أقل من :value حرف.',
    ],
    'lte' => [
        'array' => ':attribute يجب ألا يحتوي على أكثر من :value عنصر.',
        'file' => ':attribute يجب أن يكون أقل من أو يساوي :value كيلوبايت.',
        'numeric' => ':attribute يجب أن يكون أقل من أو يساوي :value.',
        'string' => ':attribute يجب أن يكون أقل من أو يساوي :value حرف.',
    ],
    'mac_address' => ':attribute يجب أن يكون عنوان MAC صحيحًا.',
    'max' => [
        'array' => ':attribute يجب ألا يحتوي على أكثر من :max عنصر.',
        'file' => ':attribute يجب ألا يكون أكبر من :max كيلوبايت.',
        'numeric' => ':attribute يجب ألا يكون أكبر من :max.',
        'string' => ':attribute يجب ألا يكون أكبر من :max حرف.',
    ],
    'mimes' => ':attribute يجب أن يكون نوع الملف: :values.',
    'mimetypes' => ':attribute يجب أن يكون نوع الملف: :values.',
    'min' => [
        'array' => ':attribute يجب أن يحتوي على الأقل على :min عنصر.',
        'file' => ':attribute يجب أن يكون على الأقل :min كيلوبايت.',
        'numeric' => ':attribute يجب أن يكون على الأقل :min.',
        'string' => ':attribute يجب أن يكون على الأقل :min حرف.',
    ],
    'multiple_of' => ':attribute يجب أن يكون مضاعفًا للقيمة :value.',
    'not_in' => 'القيمة المحددة :attribute غير صحيحة.',
    'not_regex' => 'تنسيق :attribute غير صحيح.',
    'numeric' => ':attribute يجب أن يكون رقمًا.',
    'password' => [
        'letters' => ':attribute يجب أن يحتوي على حرف واحد على الأقل.',
        'mixed' => ':attribute يجب أن يحتوي على حرف كبير وحرف صغير على الأقل.',
        'numbers' => ':attribute يجب أن يحتوي على رقم واحد على الأقل.',
        'symbols' => ':attribute يجب أن يحتوي على رمز واحد على الأقل.',
        'uncompromised' => ':attribute المعطى قد ظهر في تسريب بيانات. يرجى اختيار :attribute مختلفًا.',
        'invalid' => 'الرجاء إدخال 8 أحرف على الأقل.',
        'passwordconfirmation' => 'كلمات المرور غير متطابقة.',
    ],
    'present' => 'حقل :attribute يجب أن يكون موجودًا.',
    'prohibited' => 'حقل :attribute محظور.',
    'prohibited_if' => 'حقل :attribute محظور عندما يكون :other هو :value.',
    'prohibited_unless' => 'حقل :attribute محظور ما لم يكن :other في :values.',
    'prohibits' => 'حقل :attribute يمنع :other من الوجود.',
    'regex' => 'تنسيق :attribute غير صحيح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي حقل :attribute على مفاتيح للقيم: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other في :values.',
    'required_with' => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_with_all' => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_without' => 'حقل :attribute مطلوب عندما لا تكون :values موجودة.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same' => ':attribute و :other يجب أن تتطابق.',
    'size' => [
        'array' => ':attribute يجب أن يحتوي على :size عنصر.',
        'file' => ':attribute يجب أن يكون :size كيلوبايت.',
        'numeric' => ':attribute يجب أن يكون :size.',
        'string' => ':attribute يجب أن يكون :size حرف.',
    ],
    'starts_with' => ':attribute يجب أن يبدأ بأحد القيم التالية: :values.',
    'string' => ':attribute يجب أن يكون نصًا.',
    'timezone' => ':attribute يجب أن يكون نطاق زمني صحيحًا.',
    'unique' => ':attribute تم أخذه بالفعل.',
    'uploaded' => 'فشل تحميل :attribute.',
    'url' => ':attribute يجب أن يكون عنوان URL صحيحًا.',
    'uuid' => ':attribute يجب أن يكون UUID صحيحًا.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'allow_only_jpg_png_gif_error' => 'يتم دعم ملفات الصور فقط بصيغة JPG، PNG، و GIF.',
    'custom' => [
        'invalid' => 'الرجاء إدخال :attribute صحيح.',
        'required' => 'هذا الحقل مطلوب.',
        'required_array_keys' => 'يجب أن يحتوي هذا الحقل على مفاتيح للقيم: :values.',

        'currentpassword' => 'كلمة المرور الحالية غير صحيحة.',
        'samepassword' => 'كلمة المرور الجديدة مطابقة للقديمة.',
        'select_required' => 'الرجاء اختيار :attribute.',
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
