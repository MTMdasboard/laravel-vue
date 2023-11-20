# laravel-vue
 
1. сначала ставим Laravel Lang
```
composer require laravel-lang/common --dev
php artisan lang:add en ru
php artisan lang:update
```

2. в конфиге config/app.php устанавливаем язык по умолчанию
'locale' => 'ru',

3. Создаем мидлвэйр
```
php artisan make:middleware Localization
```

4. Вносим код в app/Http/Middleware/Localization.php
```
<?php
namespace App\\Http\\Middleware;
use Closure;
use Illuminate\\Support\\Facades\\App;
class Localization
{
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setlocale(session()->get('locale'));
        }
        return $next($request);
    }
}
```

4. В app\Http\Kernel.php регаем мидлвэйр
```
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\Localization::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ],
```

5. Добавляем конечную точку api в routes/web.php - по хорошему он должен весеть в api.php, но там нет возможности регать данные в session
```
<?php
use Illuminate\\Support\\Facades\\Route;
use Illuminate\\Support\\Facades\\App;
Route::post('locale', function () {
    // Validate
    $validated = request()->validate([
        'language' => ['required'],
    ]);
    // Set locale
    App::setLocale($validated['language']);
    // Session
    session()->put('locale', $validated['language']);
    // Response
    return redirect()->back();
});
```

6. Накатываем npm-пакет Vue-i18
```
npm install vue-i18n@latest
```

7. Создаем в каталоге lang файл messages.js для компановки переводов Laravel Lang в Vue-i18
```
import en from './en.json' assert {type: 'json'};
import ru from './ru.json' assert {type: 'json'};

export default {
    en: en,
    ru: ru
}
```

8. Вносим использование пакета Vue-i18 в resources/js/app.js
```
import { createI18n } from 'vue-i18n';
import messages from '../../lang/messages';
const i18n = createI18n({
    locale: 'ru',
    fallbackLocale: 'en',
    messages
});

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue, Ziggy)
            .mount(el);
```

9. Создаем компанент LocaleSelector.vue
```
<script>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

export default {
    setup() {
        return {
            responsiveSettingsLanguage: ref(false)
        }
    },
    methods: {
        setLocale(locale) {
            router.post("/locale", {
                'language': locale,
            });
            this.$i18n.locale = locale;
            this.responsiveSettingsLanguage = false;
        }
    }
}

</script>

<template>
    <!-- Locale Selector -->
    <div class="space-x-1 flex flex-row items-center justify-center">
        <button v-if="!responsiveSettingsLanguage" @click="responsiveSettingsLanguage = !responsiveSettingsLanguage"
        class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5
         text-blue-500 hover:text-blue-700 hover:border-blue-300 focus:outline-none focus:text-blue-700
          focus:border-blue-300 transition duration-150 ease-in-out">
            {{ $t("language_full") }}
        </button>
        <button v-if="responsiveSettingsLanguage" @click="setLocale('en')" class="flex">
            <p class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5
             text-blue-500 hover:text-blue-700 hover:border-blue-300 focus:outline-none focus:text-blue-700
              focus:border-blue-300 transition duration-150 ease-in-out">en</p>
        </button>
        <button v-if="responsiveSettingsLanguage" @click="setLocale('ru')" class="flex">
            <p class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5
             text-blue-500 hover:text-blue-700 hover:border-blue-300 focus:outline-none focus:text-blue-700 
             focus:border-blue-300 transition duration-150 ease-in-out">ru</p>
        </button>
    </div>
</template>
```

10. Ставим расширение для Visual Studio - i18n Ally