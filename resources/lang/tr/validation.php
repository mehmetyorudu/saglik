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

    'accepted' => ':attribute kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL olmalıdır.',
    'after' => ':attribute, :date tarihinden sonra olmalıdır.',
    'after_or_equal' => ':attribute, :date tarihinden sonra veya aynı olmalıdır.',
    'alpha' => ':attribute sadece harflerden oluşmalıdır.',
    'alpha_dash' => ':attribute sadece harfler, rakamlar, tireler ve alt çizgilerden oluşmalıdır.',
    'alpha_num' => ':attribute sadece harfler ve rakamlardan oluşmalıdır.',
    'array' => ':attribute bir dizi olmalıdır.',
    'before' => ':attribute, :date tarihinden önce olmalıdır.',
    'before_or_equal' => ':attribute, :date tarihinden önce veya aynı olmalıdır.',
    'between' => [
        'numeric' => ':attribute :min ile :max arasında olmalıdır.',
        'file' => ':attribute :min ile :max kilobayt arasında olmalıdır.',
        'string' => ':attribute :min ile :max karakter arasında olmalıdır.',
        'array' => ':attribute :min ile :max arasında öğeye sahip olmalıdır.',
    ],
    'boolean' => ':attribute alanı doğru veya yanlış olmalıdır.',
    'confirmed' => ':attribute onayı eşleşmiyor.',
    'date' => ':attribute geçerli bir tarih olmalıdır.',
    'date_equals' => ':attribute, :date tarihine eşit olmalıdır.',
    'date_format' => ':attribute, :format biçimiyle eşleşmelidir.',
    'different' => ':attribute ve :other farklı olmalıdır.',
    'digits' => ':attribute :digits rakam olmalıdır.',
    'digits_between' => ':attribute :min ile :max arasında rakam olmalıdır.',
    'dimensions' => ':attribute geçersiz resim boyutlarına sahip.',
    'distinct' => ':attribute alanı yinelenen bir değere sahip.',
    'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':attribute şunlardan biriyle bitmelidir: :values.',
    'exists' => 'Seçili :attribute geçersiz.',
    'file' => ':attribute bir dosya olmalıdır.',
    'filled' => ':attribute alanı bir değere sahip olmalıdır.',
    'gt' => [
        'numeric' => ':attribute, :value değerinden büyük olmalıdır.',
        'file' => ':attribute, :value kilobayttan büyük olmalıdır.',
        'string' => ':attribute, :value karakterden büyük olmalıdır.',
        'array' => ':attribute, :value öğeden daha fazla olmalıdır.',
    ],
    'gte' => [
        'numeric' => ':attribute, :value değerinden büyük veya eşit olmalıdır.',
        'file' => ':attribute, :value kilobayttan büyük veya eşit olmalıdır.',
        'string' => ':attribute, :value karakterden büyük veya eşit olmalıdır.',
        'array' => ':attribute, :value veya daha fazla öğeye sahip olmalıdır.',
    ],
    'image' => ':attribute bir resim olmalıdır.',
    'in' => 'Seçili :attribute geçersiz.',
    'in_array' => ':attribute alanı :other içinde mevcut değil.',
    'integer' => ':attribute bir tam sayı olmalıdır.',
    'ip' => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute geçerli bir JSON dizesi olmalıdır.',
    'lt' => [
        'numeric' => ':attribute, :value değerinden küçük olmalıdır.',
        'file' => ':attribute, :value kilobayttan küçük olmalıdır.',
        'string' => ':attribute, :value karakterden küçük olmalıdır.',
        'array' => ':attribute, :value öğeden daha az olmalıdır.',
    ],
    'lte' => [
        'numeric' => ':attribute, :value değerinden küçük veya eşit olmalıdır.',
        'file' => ':attribute, :value kilobayttan küçük veya eşit olmalıdır.',
        'string' => ':attribute, :value karakterden küçük veya eşit olmalıdır.',
        'array' => ':attribute, :value veya daha az öğeye sahip olmalıdır.',
    ],
    'max' => [
        'numeric' => ':attribute, :max değerinden büyük olmamalıdır.',
        'file' => ':attribute, :max kilobayttan büyük olmamalıdır.',
        'string' => ':attribute, :max karakterden büyük olmamalıdır.',
        'array' => ':attribute, :max öğeden daha fazla olmamalıdır.',
    ],
    'mimes' => ':attribute şu dosya türlerinden biri olmalıdır: :values.',
    'mimetypes' => ':attribute şu dosya türlerinden biri olmalıdır: :values.',
    'min' => [
        'numeric' => ':attribute en az :min olmalıdır.',
        'file' => ':attribute en az :min kilobayt olmalıdır.',
        'string' => ':attribute en az :min karakter olmalıdır.',
        'array' => ':attribute en az :min öğeye sahip olmalıdır.',
    ],
    'not_in' => 'Seçili :attribute geçersiz.',
    'not_regex' => ':attribute formatı geçersiz.',
    'numeric' => ':attribute bir sayı olmalıdır.',
    'present' => ':attribute alanı mevcut olmalıdır.',
    'regex' => ':attribute formatı geçersiz.',
    'required' => ':attribute alanı zorunludur.',
    'required_if' => ':attribute alanı, :other :value olduğunda zorunludur.',
    'required_unless' => ':attribute alanı, :other :values içinde olmadığı sürece zorunludur.',
    'required_with' => ':attribute alanı, :values mevcut olduğunda zorunludur.',
    'required_with_all' => ':attribute alanı, :values mevcut olduğunda zorunludur.',
    'required_without' => ':attribute alanı, :values mevcut olmadığında zorunludur.',
    'required_without_all' => ':attribute alanı, :values hiçbirinin mevcut olmadığı durumlarda zorunludur.',
    'same' => ':attribute ve :other eşleşmelidir.',
    'size' => [
        'numeric' => ':attribute :size olmalıdır.',
        'file' => ':attribute :size kilobayt olmalıdır.',
        'string' => ':attribute :size karakter olmalıdır.',
        'array' => ':attribute :size öğeye sahip olmalıdır.',
    ],
    'starts_with' => ':attribute şunlardan biriyle başlamalıdır: :values.',
    'string' => ':attribute bir dize olmalıdır.',
    'timezone' => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique' => ':attribute daha önce alınmış.',
    'uploaded' => ':attribute yüklemesi başarısız oldu.',
    'url' => ':attribute formatı geçersiz.',
    'uuid' => ':attribute geçerli bir UUID olmalıdır.',

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
        'password' => [
            'min' => 'Şifreniz en az :min karakterden oluşmalıdır.',
        ],
        'appointment_time' => [
            'required' => 'Lütfen bir randevu saati seçin.',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'İsim',
        'email' => 'E-posta',
        'password' => 'Şifre',
        'password_confirmation' => 'Şifre onayı',
        'age' => 'Yaş',
        'height' => 'Boy',
        'weight' => 'Kilo',
        'waist_circumference' => 'Bel çevresi',
        'specialty' => 'Uzmanlık Alanı',
        'appointment_time' => 'Randevu Saati',
    ],

];
