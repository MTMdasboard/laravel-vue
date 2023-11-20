<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LaravelLogo from '@/Components/media/LaravelLogo.vue';
import MySqlLogo from '@/Components/media/MySqlLogo.vue';
import VueLogo from '@/Components/media/VueLogo.vue';
import SelfImage from '@/Components/media/SelfImage.vue';
import RouterButton from '@/Components/RouterButton.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <Head :title='$t("home")' />

    <AuthenticatedLayout :canLogin=canLogin :canRegister=canRegister :auth=$page.props.auth>

        <template #header>
            <h1 class="font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center">{{ $t('Welcome!') }}</h1>
        </template>

        <div class="py-6 space-y-6 flex flex-col w-full justify-center">

            <div class="flex justify-center">
                <SelfImage />
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 sm:p-6 text-gray-600 text-center font-semibold">
                        <p>{{ $t('I invite you to familiarize') }}</p>
                        <p>{{ $t('yourself with my demo project') }}</p>
                        <RouterButton :href="route('news')"
                            class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ $t('Get started') }}
                        </RouterButton>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center space-y-4 p-4">

                    <div class="flex space-x-4">
                        <LaravelLogo />
                        <MySqlLogo />
                        <VueLogo />
                    </div>

                    <div class="text-gray-600 text-center">
                        <p v-html="$t('The backend of this site is built on Laravel')"></p>
                        <p v-html="$t('The frontend is a monolithic Vue')"></p>
                        <p v-html="$t('The database hangs in the MySQL cloud')"></p>
                    </div>
                </div>
            </div>

        </div>


    </AuthenticatedLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
