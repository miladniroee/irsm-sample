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

    'accepted' => ':attribute باید پذیرفته شده باشد.',
    'accepted_if' => ':attribute باید وقتی  :other برابر با :value است پذیرفته شود.',
    'active_url' => ':attribute یک آدرس معتبر نیست.',
    'after' => ':attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal' => ':attribute باید تاریخی بعد از یا مساوی :date باشد.',
    'alpha' => ':attribute باید فقط شامل حروف انگلیسی باشد.',
    'alpha_dash' => ':attribute باید شامل حروف انگلیسی و عدد و خظ تیره(-) باشد.',
    'alpha_num' => ':attribute باید شامل حروف انگلیسی و عدد باشد.',
    'array' => ':attribute باید شامل آرایه باشد.',
    'ascii' => ':attribute باید دارای کارکتر های  single-byte alphanumeric و نماد ها باشد.',
    'before' => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal' => ':attribute باید تاریخی قبل از یا مساوی :date باشد.',
    'between' => [
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'file' => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'string' => ':attribute باید بین :min و :max کاراکتر باشد.',
        'array' => ':attribute باید بین :min و :max آیتم باشد.',
    ],
    'boolean' => 'فیلد :attribute باید یکی از صفر یا یک باشد.',
    'confirmed' => ':attribute با تاییدیه مطابقت ندارد.',
    'current_password' => 'رمز عبور اشتباه است.',
    'date' => ':attribute یک تاریخ معتبر نیست.',
    'date_equals' => ':attribute باید برابر با تاریخ :date باشد.',
    'date_format' => ':attribute با الگوی :format مطاقبت ندارد.',
    'decimal' => ':attribute باید دارای :decimal رقم اعشار باشد.',
    'declined' => ':attribute باید رد شود.',
    'declined_if' => ':attribute باید رد شود اگر مقدار :other برابر با :value باشد.',
    'different' => ':attribute و :other باید متفاوت باشد.',
    'digits' => ':attribute باید :digits رقم باشد.',
    'digits_between' => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions' => 'ابعاد تصویر :attribute قابل قبول نیست.',
    'distinct' => 'فیلد :attribute دارای یک مقدار تکراری است.',
    'doesnt_end_with' => ':attribute نباید با یکی از مقادیر زیر خاتمه یابد: :values.',
    'doesnt_start_with' => ':attribute نباید با یکی از مقادیر زیر شروع شود: :values.',
    'email' => ':attribute باید یک ایمیل معتبر باشد.',
    'ends_with' => ':attribute باید با یکی از این مقادیر پایان یابد: :values.',
    'enum' => ':attribute انتخاب شده اشتباه است',
    'exists' => ':attribute انتخاب شده نامعتبر است.',
    'file' => ':attribute باید یک فایل باشد.',
    'filled' => 'فیلد :attribute باید پر باشد.',
    'gt' => [
        'array' => ':attribute باید بیش از :value آیتم داشته باشد.',
        'file' => ':attribute باید بیشتر از  :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بزرگتر از :value باشد.',
        'string' => ':attribute باید بیش از :value کارکتر باشد.',
    ],
    'gte' => [
        'array' => ':attribute باید :value آیتم و یا بیشتر داشته باشد.',
        'file' => ':attribute باید :value کیلوبایت و یا بیشتر باشد.',
        'numeric' => ':attribute باید :value و یا بزرگتر باشد.',
        'string' => ':attribute باید :value کارکتر و یا بیشتر باشد.',
    ],
    'image' => ':attribute باید یک تصویر باشد.',
    'in' => ':attribute انتخاب شده نامعتبر است.',
    'in_array' => 'فیلد :attribute در :other وجود ندارد.',
    'integer' => ':attribute باید یک عدد صحیح باشد.',
    'ip' => ':attribute باید یک آی پی معتبر باشد.',
    'ipv4' => ':attribute باید یک آی پی 4 آدرس معتبر باشد.',
    'ipv6' => ':attribute باید یک آی پی 6 آدرس معتبر باشد.',
    'json' => ':attribute باید یک رشته JSON معتبر باشد.',
    'key_exists' => 'فیلد :attribute در دیتابیس وجود ندارد.',
    'lowercase' => ':attribute باید با حروف کوچک باشد.',
    'lt' => [
        'array' => ':attribute باید کمتر از :value آیتم داشته باشد.',
        'file' => ':attribute باید کمتر از  :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کوچک تر از :value باشد.',
        'string' => ':attribute باید کمتر از :value کارکتر باشد.',
    ],
    'lte' => [
        'array' => ':attribute باید :value آیتم و یا کمتر داشته باشد.',
        'file' => ':attribute باید :value کیلوبایت و یا کمتر باشد.',
        'numeric' => ':attribute باید :value و یا کوچکتر باشد.',
        'string' => ':attribute باید :value کارکتر و یا کمتر باشد.',
    ],
    'mac_address' => ':attribute باید یک مک آدرس صحیح باشد.',
    'max' => [
        'array' => ':attribute نباید بیشتر از :max آیتم باشد.',
        'file' => ':attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'string' => ':attribute نباید بیشتر از :max کاراکتر باشد.',
    ],
    'max_digits' => ':attribute نباید بیش از :max رقم باشد.',
    'mimes' => ':attribute باید یکی از فرمت های :values باشد.',
    'mimetypes' => ':attribute باید یکی از فرمت های :values باشد.',
    'min' => [
        'array' => ':attribute باید حداقل :min آیتم باشد.',
        'file' => ':attribute باید حداقل :min کیلوبایت باشد.',
        'numeric' => ':attribute باید حداقل :min باشد.',
        'string' => ':attribute باید حداقل :min کاراکتر باشد.',
    ],
    'min_digits' => ':attribute باید حداقل :min رقم باشد.',
    'missing' => ':attribute باید از دست رفته باشد.',
    'missing_if' => ':attribute باید از دست رفته باشد در صورتی که :other برابر با :value باشد.',
    'missing_unless' => ':attribute باید از دست رفته باشد مگر وقتی :other برابر با :value.',
    'missing_with' => ':attribute باید از دست رفته باشد وقتی :values وجود دارد.',
    'missing_with_all' => ':attribute باید از دست رفته باشد وفتی مقادیر :values موجود هستند.',
    'multiple_of' => ':attribute باید ضربی از :value باشد.',
    'not_in' => ':attribute انتخاب شده نامعتبر است.',
    'not_regex' => ':attribute دارای فرمت اشتباهی است.',
    'numeric' => ':attribute باید عدد باشد.',
    'password' => [
        'letters' => ':attribute باید حداقل دارای یک حرف باشد.',
        'mixed' => ':attribute باید حداقل دارای یک حرف کوچک و یک حرف بزرگ باشد.',
        'numbers' => ':attribute باید حداقل یک عدد داشته باشد.',
        'symbols' => ':attribute باید حداقل یک نماد داشته باشد.',
        'uncompromised' => 'مقدار :در بررسی های لو رفتن رمز عبور وجود دارد، لطفا رمز دیگری انتخاب کنید :attribute.',
    ],
    'present' => 'فیلد :attribute باید در پارامترهای دریافتی وجود داشته باشد.',
    'prohibited' => ':attribute ممنوع است.',
    'prohibited_if' => ':attribute در صورتی که :other برابر با :value باشد ممنوع است.',
    'prohibited_unless' => ':attribute ممنوع است مگر این که :other بین مقادیر :values وجود داشته باشد.',
    'prohibits' => 'مقدار :other در :prohibits ممنوع است.',
    'regex' => 'فرمت :attribute نامعتبر است.',
    'required' => 'فیلد :attribute الزامی است.',
    'required_array_keys' => ':attribute باید موارد: :values. را داشته باشد',
    'required_if' => 'فیلد :attribute  زمانی که :other برابر با :value باشد الزامی است.',
    'required_if_accepted' => ':attribute زمانی که :other تایید شده است، الزامی است.',
    'required_unless' => 'فیلد :attribute الزامی است تا :other برابر با :values باشد.',
    'required_with' => 'فیلد :attribute الزامی است تا :values موجود باشد.',
    'required_with_all' => 'فیلد :attribute الزامی است تا :values موجود باشد.',
    'required_without' => 'فیلد :attribute الزامی است تا :values موجود نباشد.',
    'required_without_all' => 'فیلد :attribute الزامی است تا :values موجود نباشد.',
    'same' => ':attribute و :other باید مانند هم باشد.',
    'size' => [
        'numeric' => ':attribute باید برابر با :size باشد.',
        'file' => ':attribute باید برابر با :size کیلوبایت باشد.',
        'string' => ':attribute باید برابر با :size کاراکتر باشد.',
        'array' => ':attribute باید شامل :size آیتم باشد.',
    ],
    'starts_with' => ':attribute باید با یکی از این موارد شروع شود: :values.',
    'string' => ':attribute باید یک رشته باشد.',
    'timezone' => ':attribute باید یک منطقه صحیح باشد.',
    'unique' => ':attribute قبلا انتخاب شده است.',
    'uploaded' => 'بارگذاری :attribute با خطا مواجه شد.',
    'uppercase' => ':attribute باید با حروف بزرگ نوشته شود.',
    'url' => 'فرمت آدرس :attribute نامعتبر است.',
    'ulid' => ':attribute باید یک ULID معتبر باشد.',
    'uuid' => ':attribute باید یک UUID معتبر باشد.',


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

    'custom' => [
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

    'attributes' => [
        'fullname' => "نام و نام خانوادگی",
        "privacy_policy" => "شرایط و قوانین",
        'name' => 'نام',
        'username' => 'نام کاربری',
        'email' => 'ایمیل',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تایید رمز عبور',
        'city' => 'شهر',
        'country' => 'کشور',
        'address' => 'آدرس',
        'phone' => 'تلفن',
        'mobile' => 'موبایل',
        'age' => 'سن',
        'sex' => 'جنسیت',
        'gender' => 'جنسیت',
        'day' => 'روز',
        'month' => 'ماه',
        'year' => 'سال',
        'hour' => 'ساعت',
        'minute' => 'دقیقه',
        'second' => 'ثانیه',
        'content' => 'محتوا',
        'description' => 'توضیحات',
        'excerpt' => 'خلاصه',
        'date' => 'تاریخ',
        'time' => 'زمان',
        'available' => 'موجود',
        'size' => 'اندازه',
        'price' => 'قیمت',
        'desc' => 'توضیح',
        'title' => 'عنوان',
        'q' => 'البحث',
        'link' => 'لینک',
        'slug' => 'لینک کوتاه',
        'otp_number' => 'کد تایید',
        'melli_code' => 'کد ملی',
        'birthdate' => 'تاریخ تولد',
        'invoice_no' => 'شماره فاکتور',
        'receipts' => 'رسید ها',
        'receipts.0' => 'رسید 1',
        'receipts.1' => 'رسید 2',
        'receipts.2' => 'رسید 3',
        'name_fa' => 'نام فارسی',
        'name_en' => 'نام انگلیسی',
        'name_ar' => 'نام عربی',
        'category' => 'دسته بندی',
        'filepond' => 'تصویر',
        'attribute' => 'ویژگی',
        'attribute.*' => 'ویژگی',
        'code' => 'کد تخفیف',
        'value' => 'مقدار',
        'max_value' => 'حداکثر بلغ تخفیف',
        'min_price' => 'حداقل مبلغ خرید',
        'max_uses' => 'حداکثر تعداد استفاده',
        'expires_at' => 'تاریخ انقضا',
        'is_active' => 'فعال',
        'first_order_only' => 'فقط برای سفارش اول',
        'is_single_use' => 'فقط برای یک خرید',
        'user_id' => 'کاربر',
        'category_id' => 'دسته بندی',
        'new_category_id' => 'دسته بندی جدید',
        'parent_id' => 'دسته بندی والد',
        'branch_id' => 'شعبه',
    ],

];
