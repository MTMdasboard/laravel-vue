<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import UpdateNewsForm from "@/Pages/news/partials/UpdateNewsForm.vue";
import RouterButton from "@/Components/RouterButton.vue";
import DeleteNewsForm from "./partials/DeleteNewsForm.vue";

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
                <RouterButton
                    :href="route('news.show', { news: newsOnce.id })"
                    class="inline-flex h-10 items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                        />
                    </svg>
                </RouterButton>
                <h1
                    class="flex-1 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center"
                >
                    {{ $t("Change a post:") }}
                </h1>
                <!-- <RouterButton
                    :href="route('news.delete', { news: newsOnce.id })"
                    method="delete"
                    class="inline-flex h-10 items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer"
                >
                    <svg
                        class="h-4 w-4"
                        fill="currentColor"
                        stroke="currentColor"
                        viewBox="0 0 1049 1024"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M524.816493 830.218181a35.83281 35.83281 0 0 0 35.788334-35.803159v-412.292279a35.803159 35.803159 0 0 0-71.591493 0v412.292279A35.83281 35.83281 0 0 0 524.816493 830.218181zM705.374122 830.218181a35.83281 35.83281 0 0 0 35.788334-35.803159v-412.292279a35.803159 35.803159 0 0 0-71.591493 0v412.292279A35.83281 35.83281 0 0 0 705.374122 830.218181zM344.199563 830.218181a35.83281 35.83281 0 0 0 35.788334-35.803159v-412.292279a35.803159 35.803159 0 0 0-71.591493 0v412.292279c0.756092 19.688031 16.826743 35.803159 35.803159 35.803159z"
                        />
                        <path
                            d="M1013.770526 128.639342H766.721316V86.920879A87.00983 87.00983 0 0 0 679.800437 0H370.633117a87.00983 87.00983 0 0 0-86.906054 86.920879v41.718463H35.788334a35.788334 35.788334 0 0 0 0 71.576668H154.183377V885.071883a139.031895 139.031895 0 0 0 138.868816 138.868816h463.439649A139.031895 139.031895 0 0 0 895.360658 885.071883V199.400617h118.409868A35.83281 35.83281 0 0 0 1049.632986 163.612283c0-19.613905-15.803796-34.972941-35.86246-34.972941zM354.414211 86.920879A15.996525 15.996525 0 0 1 370.633117 70.761275h309.16732a15.996525 15.996525 0 0 1 16.159604 16.159604v41.718463H354.414211zM823.769165 885.071883a67.35145 67.35145 0 0 1-67.277323 67.277323H293.067018A67.366275 67.366275 0 0 1 225.774869 885.071883V199.400617h597.994296z"
                        />
                    </svg>
                </RouterButton> -->
                <DeleteNewsForm 
                    :newsOnce="newsOnce"
                />
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
