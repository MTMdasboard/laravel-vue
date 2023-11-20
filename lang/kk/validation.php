<?php

declare(strict_types=1);

return [
    'accepted'             => ':Attribute қабылдануы керек.',
    'accepted_if'          => ':Other :value болғанда :attribute қабылдануы керек.',
    'active_url'           => ':Attribute жарамды URL мекенжайы емес.',
    'after'                => ':Attribute мәні :date күнінен кейінгі күн болуы керек.',
    'after_or_equal'       => ':Attribute мәні :date күнінен кейінгі күн немесе тең болуы керек.',
    'alpha'                => ':Attribute тек әріптерден тұруы керек.',
    'alpha_dash'           => ':Attribute тек әріптерден, сандардан және сызықшалардан тұруы керек.',
    'alpha_num'            => ':Attribute тек әріптерден және сандардан тұруы керек.',
    'array'                => ':Attribute жиым болуы керек.',
    'ascii'                => ':Attribute тек бір байтты әріптік-сандық таңбалар мен таңбаларды қамтуы керек.',
    'before'               => ':Attribute мәні :date күнінен дейінгі күн болуы керек.',
    'before_or_equal'      => ':Attribute мәні :date күнінен дейінгі күн немесе тең болуы керек.',
    'between'              => [
        'array'   => ':Attribute жиымы :min және :max аралығындағы элементтерден тұруы керек.',
        'file'    => ':Attribute көлемі :min және :max килобайт аралығында болуы керек.',
        'numeric' => ':Attribute мәні :min және :max аралығында болуы керек.',
        'string'  => ':Attribute тармағы :min және :max аралығындағы таңбалардан тұруы керек.',
    ],
    'boolean'              => ':Attribute жолы шын немесе жалған мән болуы керек.',
    'can'                  => ':Attribute өрісінде рұқсат етілмеген мән бар.',
    'confirmed'            => ':Attribute растауы сәйкес емес.',
    'current_password'     => 'Құпия сөз дұрыс емес.',
    'date'                 => ':Attribute жарамды күн емес.',
    'date_equals'          => ':Attribute мәні :date күнімен тең болуы керек.',
    'date_format'          => ':Attribute пішімі :format пішіміне сай емес.',
    'decimal'              => ':Attribute санында :decimal ондық таңба болуы керек.',
    'declined'             => ':Attribute-ден бас тарту керек.',
    'declined_if'          => ':Other саны :value болғанда, :attribute-ден бас тарту керек.',
    'different'            => ':Attribute және :other әр түрлі болуы керек.',
    'digits'               => ':Attribute мәні :digits сан болуы керек.',
    'digits_between'       => ':Attribute мәні :min және :max аралығындағы сан болуы керек.',
    'dimensions'           => ':Attribute сурет өлшемі жарамсыз.',
    'distinct'             => ':Attribute жолында қосарланған мән бар.',
    'doesnt_end_with'      => ':Attribute келесілердің бірімен аяқталмауы мүмкін: :values.',
    'doesnt_start_with'    => ':Attribute келесілердің бірінен басталмауы мүмкін: :values.',
    'email'                => ':Attribute жарамды электрондық пошта мекенжайы болуы керек.',
    'ends_with'            => ':Attribute келесі мәндердің біреуінен аяқталуы керек: :values',
    'enum'                 => 'Таңдалған :attribute жарамсыз.',
    'exists'               => 'таңдалған :attribute жарамсыз.',
    'file'                 => ':Attribute файл болуы тиіс.',
    'filled'               => ':Attribute жолы толтырылуы керек.',
    'gt'                   => [
        'array'   => ':Attribute мәні :value элементтерден үлкен болуы керек.',
        'file'    => ':Attribute файл өлшемі :value килобайттан үлкен болуы керек.',
        'numeric' => ':Attribute мәні :value үлкен болуы керек.',
        'string'  => ':Attribute мәні :value таңбалардан үлкен болуы керек.',
    ],
    'gte'                  => [
        'array'   => ':Attribute мәні :value элементтерден үлкен немесе тең болуы керек.',
        'file'    => ':Attribute файл өлшемі :value килобайттан үлкен немесе тең болуы керек.',
        'numeric' => ':Attribute мәні :value үлкен немесе тең болуы керек.',
        'string'  => ':Attribute мәні :value таңбалардан үлкен немесе тең болуы керек.',
    ],
    'image'                => ':Attribute кескін болуы керек.',
    'in'                   => 'таңдалған :attribute жарамсыз.',
    'in_array'             => ':Attribute жолы :other ішінде жоқ.',
    'integer'              => ':Attribute бүтін сан болуы керек.',
    'ip'                   => ':Attribute жарамды IP мекенжайы болуы керек.',
    'ipv4'                 => ':Attribute жарамды IPv4 мекенжайы болуы керек.',
    'ipv6'                 => ':Attribute жарамды IPv6 мекенжайы болуы керек.',
    'json'                 => ':Attribute жарамды JSON тармағы болуы керек.',
    'lowercase'            => ':Attribute кіші әріп болуы керек.',
    'lt'                   => [
        'array'   => ':Attribute мәні :value элементтерден кіші болуы керек.',
        'file'    => ':Attribute файл өлшемі :value килобайттан кіші болуы керек.',
        'numeric' => ':Attribute мәні :value кіші болуы керек.',
        'string'  => ':Attribute мәні :value таңбалардан кіші болуы керек.',
    ],
    'lte'                  => [
        'array'   => ':Attribute мәні :value элементтерден кіші немесе тең болуы керек.',
        'file'    => ':Attribute файл өлшемі :value килобайттан кіші неменсе тең болуы керек.',
        'numeric' => ':Attribute мәні :value кіші немесе тең болуы керек.',
        'string'  => ':Attribute мәні :value таңбалардан кіші немесе тең болуы керек.',
    ],
    'mac_address'          => ':Attribute жарамды MAC мекенжайы болуы керек.',
    'max'                  => [
        'array'   => ':Attribute жиымының құрамы :max элементтен аспауы керек.',
        'file'    => ':Attribute мәні :max килобайттан көп болмауы керек.',
        'numeric' => ':Attribute мәні :max мәнінен көп болмауы керек.',
        'string'  => ':Attribute тармағы :max таңбадан ұзын болмауы керек.',
    ],
    'max_digits'           => ':Attribute саны :max цифрдан аспауы керек.',
    'mimes'                => ':Attribute мынадай файл түрі болуы керек: :values.',
    'mimetypes'            => ':Attribute мынадай файл түрі болуы керек: :values.',
    'min'                  => [
        'array'   => ':Attribute кемінде :min элементтен тұруы керек.',
        'file'    => ':Attribute көлемі кемінде :min килобайт болуы керек.',
        'numeric' => ':Attribute кемінде :min болуы керек.',
        'string'  => ':Attribute кемінде :min таңбадан тұруы керек.',
    ],
    'min_digits'           => ':Attribute саны кемінде :min цифрдан тұруы керек.',
    'missing'              => ':Attribute өрісі жоқ болуы керек.',
    'missing_if'           => ':Other саны :value болғанда :attribute өрісі болмауы керек.',
    'missing_unless'       => ':Other :value болмаса, :attribute өрісі жоқ болуы керек.',
    'missing_with'         => ':Values болған кезде :attribute өрісі жоқ болуы керек.',
    'missing_with_all'     => ':Values болған кезде :attribute өрісі жоқ болуы керек.',
    'multiple_of'          => ':Attribute :value еселенуі керек',
    'not_in'               => 'таңдалған :attribute жарамсыз.',
    'not_regex'            => 'таңдалған :attribute форматы жарамсыз.',
    'numeric'              => ':Attribute сан болуы керек.',
    'password'             => [
        'letters'       => ':Attribute саны кемінде бір әріптен тұруы керек.',
        'mixed'         => ':Attribute саны кемінде бір бас әріп пен бір кіші әріптен тұруы керек.',
        'numbers'       => ':Attribute-де кемінде бір сан болуы керек.',
        'symbols'       => ':Attribute саны кемінде бір таңбадан тұруы керек.',
        'uncompromised' => 'Берілген :attribute деректер ағып кетуде пайда болды. Басқа :attribute таңдаңыз.',
    ],
    'present'              => ':Attribute болуы керек.',
    'present_if'           => ':other саны :value болғанда :attribute өрісі болуы керек.',
    'present_unless'       => ':other саны :value болмаса, :attribute өрісі болуы керек.',
    'present_with'         => ':values болған кезде :attribute өрісі болуы керек.',
    'present_with_all'     => ':values болған кезде :attribute өрісі болуы керек.',
    'prohibited'           => ':Attribute өрісіне тыйым салынады.',
    'prohibited_if'        => ':Attribute өрісіне :other :value болған кезде тыйым салынады.',
    'prohibited_unless'    => ':Attribute өрісіне тыйым салынады, егер тек :other :values-де болмаса.',
    'prohibits'            => ':Attribute өрісі :other-нің болуына тыйым салады.',
    'regex'                => ':Attribute пішімі жарамсыз.',
    'required'             => ':Attribute жолы толтырылуы керек.',
    'required_array_keys'  => ':Attribute өрісінде :values үшін жазба болуы керек.',
    'required_if'          => ':Attribute жолы :other мәні :value болған кезде толтырылуы керек.',
    'required_if_accepted' => ':Other қабылданған кезде :attribute өрісі қажет.',
    'required_unless'      => ':Attribute жолы :other мәні :values ішінде болмағанда толтырылуы керек.',
    'required_with'        => ':Attribute жолы :values болғанда толтырылуы керек.',
    'required_with_all'    => ':Attribute жолы :values болғанда толтырылуы керек.',
    'required_without'     => ':Attribute жолы :values болмағанда толтырылуы керек.',
    'required_without_all' => ':Attribute жолы ешбір :values болмағанда толтырылуы керек.',
    'same'                 => ':Attribute және :other сәйкес болуы керек.',
    'base64_image'         => ':Attribute 1КБ пен 100КБ арасындағы жарамды кескін болуы керек.',
    'size'                 => [
        'array'   => ':Attribute жиымы :size элементтен тұруы керек.',
        'file'    => ':Attribute көлемі :size килобайт болуы керек.',
        'numeric' => ':Attribute көлемі :size болуы керек.',
        'string'  => ':Attribute тармағы :size таңбадан тұруы керек.',
    ],
    'starts_with'          => ':Attribute келесі мәндердің біреуінен басталуы керек: :values',
    'string'               => ':Attribute тармақ болуы керек.',
    'timezone'             => ':Attribute жарамды аймақ болуы керек.',
    'ulid'                 => ':Attribute жарамды ULID болуы керек.',
    'unique'               => ':Attribute бұрын алынған.',
    'uploaded'             => ':Attribute жүктелуі сәтсіз аяқталды.',
    'uppercase'            => ':Attribute бас әріп болуы керек.',
    'url'                  => ':Attribute пішімі жарамсыз.',
    'uuid'                 => ':Attribute мәні жарамды UUID болуы керек.',
    'attributes'           => [
        'address'                  => 'мекенжай',
        'age'                      => 'жасы',
        'amount'                   => 'сомасы',
        'area'                     => 'аумақ',
        'available'                => 'қолжетімді',
        'birthday'                 => 'туған күні',
        'body'                     => 'дене',
        'city'                     => 'қала',
        'content'                  => 'контент',
        'country'                  => 'ел',
        'created_at'               => 'құрылды',
        'creator'                  => 'жасаушы',
        'current_password'         => 'ағымдағы құпия сөз',
        'date'                     => 'күні',
        'date_of_birth'            => 'туған кезі',
        'day'                      => 'күн',
        'deleted_at'               => 'жойылған',
        'description'              => 'сипаттамасы',
        'district'                 => 'аудан',
        'duration'                 => 'ұзақтығы',
        'email'                    => 'e-mail мекенжай',
        'excerpt'                  => 'үзінді',
        'filter'                   => 'сүзгі',
        'first_name'               => 'аты',
        'gender'                   => 'жынысы',
        'group'                    => 'топ',
        'hour'                     => 'сағат',
        'image'                    => 'сурет',
        'last_name'                => 'тегі',
        'lesson'                   => 'сабақ',
        'line_address_1'           => 'жолдың мекенжайы 1',
        'line_address_2'           => '2-жол адресі',
        'message'                  => 'хабар',
        'middle_name'              => 'екінші аты',
        'minute'                   => 'минут',
        'mobile'                   => 'моб. нөмір',
        'month'                    => 'ай',
        'name'                     => 'аты',
        'national_code'            => 'ұлттық код',
        'number'                   => 'саны',
        'password'                 => 'құпиясөз',
        'password_confirmation'    => 'құпиясөзді растау',
        'phone'                    => 'телефон',
        'photo'                    => 'фото',
        'postal_code'              => 'Пошта Индексі',
        'price'                    => 'бағасы',
        'province'                 => 'провинция',
        'recaptcha_response_field' => 'recaptcha жауап өрісі',
        'remember'                 => 'есте сақтаңыз',
        'restored_at'              => 'қалпына келтірілді',
        'result_text_under_image'  => 'сурет астындағы нәтиже мәтіні',
        'role'                     => 'рөл',
        'second'                   => 'секунд',
        'sex'                      => 'жынысы',
        'short_text'               => 'қысқа мәтін',
        'size'                     => 'көлемі',
        'state'                    => 'күй',
        'street'                   => 'көше',
        'student'                  => 'студент',
        'subject'                  => 'пән',
        'teacher'                  => 'мұғалім',
        'terms'                    => 'шарттар',
        'test_description'         => 'сынақ сипаттамасы',
        'test_locale'              => 'сынақ тілі',
        'test_name'                => 'сынақ атауы',
        'text'                     => 'мәтін',
        'time'                     => 'уақыт',
        'title'                    => 'атауы',
        'updated_at'               => 'жаңартылған',
        'username'                 => 'лақап аты',
        'year'                     => 'жыл',
    ],
];
