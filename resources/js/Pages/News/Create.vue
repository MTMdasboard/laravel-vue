<script setup>
import RouterButton from "@/Components/RouterButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UpdateNewsForm from "@/Pages/News/Partials/UpdateNewsForm.vue";
import { ChevronLeftIcon } from "@heroicons/vue/24/solid";
import { Head } from "@inertiajs/vue3";

defineProps({
    userList: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <Head :title="$t('Create a post') + ': ' + $t('News')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <RouterButton :href="route('news')">
                    <ChevronLeftIcon
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                    />
                </RouterButton>
                <h1
                    class="flex-1 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center"
                >
                    {{ $t("Create a post") + ": " + $t("News") }}
                </h1>
            </div>
        </template>

        <div class="flex w-full py-12">
            <div
                class="flex w-full max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 justify-center"
            >
                <div
                    class="flex w-full sm:w-1/2 p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                >
                    <UpdateNewsForm
                        :submit="route('news.store')"
                        :userList="userList"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
