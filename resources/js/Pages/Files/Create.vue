<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UpdateFileForm from "@/Pages/Files/Partials/UpdateFileForm.vue";
import RouterButton from "@/Components/RouterButton.vue";
import { ChevronLeftIcon } from "@heroicons/vue/24/solid";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head :title="$t('Add') + ' ' + $t('File')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <RouterButton
                    :href="route('files')"
                >
                    <ChevronLeftIcon class="h-6 w-6"/>
                </RouterButton>
                <h1
                    class="flex-1 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center"
                >
                    {{ $t("Add") + " " + $t("File") }}
                </h1>
            </div>
        </template>

        <div class="flex w-full py-12">
            <div
                class="flex w-full max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 justify-center"
            >
                <UpdateFileForm
                    class="flex w-full sm:w-1/2 p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                    :submit="route('files.store')"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
