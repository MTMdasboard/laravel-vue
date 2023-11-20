<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import UpdateNewsForm from '@/Pages/news/partials/UpdateNewsForm.vue';
import RouterButton from '@/Components/RouterButton.vue';

defineProps({
    newsOnce: {
        type: Object,
        required: true,
    },
    userList: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <Head :title="$t('Change a post:')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <RouterButton :href="route('news.show', { news: newsOnce.id })"
                    class="inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </RouterButton>
                <h1 class="flex-1 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center">
                    {{ $t('Change a post:') }}
                </h1>
            </div>
        </template>

        <div class="flex w-full py-12 ">
            <div class="flex w-full max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 justify-center">
                <div class="flex w-full sm:w-1/2 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateNewsForm 
                    :submit="route('news.update', { news: newsOnce.id })"
                    :newsOnce="newsOnce"
                    :userList="userList" 
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
