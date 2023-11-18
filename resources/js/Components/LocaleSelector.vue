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
            router.post("/api/locale", {
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
        <button v-if="responsiveSettingsLanguage" @click="setLocale('kk')" class="flex">
            <p class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5
             text-blue-500 hover:text-blue-700 hover:border-blue-300 focus:outline-none focus:text-blue-700 
             focus:border-blue-300 transition duration-150 ease-in-out">kz</p>
        </button>
    </div>
</template>