<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import UpdateNewsForm from "@/Pages/News/Partials/UpdateNewsForm.vue";
import RouterButton from "@/Components/RouterButton.vue";
import DeleteNewsForm from "@/Pages/News/Partials/DeleteNewsForm.vue";
import { ChevronLeftIcon, TrashIcon } from "@heroicons/vue/24/solid";

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
    <Head :title="$t('Change a post')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <RouterButton :href="route('news.show', { news: newsOnce.id })">
                    <ChevronLeftIcon class="h-6 w-6" />
                </RouterButton>
                <h1
                    class="flex-1 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center"
                >
                    {{ $t("Change a post:") }}
                </h1>
                <DeleteNewsForm :newsId="newsOnce.id">
                    <TrashIcon class="h-6 w-6" />
                </DeleteNewsForm>
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
                        :submit="route('news.update', { news: newsOnce.id })"
                        :newsOnce="newsOnce"
                        :userList="userList"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
