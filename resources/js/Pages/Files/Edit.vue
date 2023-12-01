<script setup>
import RouterButton from "@/Components/RouterButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteFileForm from "@/Pages/Files/Partials/DeleteFileForm.vue";
import UpdateFileForm from "@/Pages/Files/Partials/UpdateFileForm.vue";
import { ChevronLeftIcon, TrashIcon } from "@heroicons/vue/24/solid";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    file: {
        type: Object,
        required: true,
    },
});

let binaryData = atob(props.file.file);
let arrayBuffer = new ArrayBuffer(binaryData.length);
let uint8Array = new Uint8Array(arrayBuffer);

for (let i = 0; i < binaryData.length; i++) {
    uint8Array[i] = binaryData.charCodeAt(i);
}

props.file.file = new File([uint8Array], props.file.original_filename, {
    type: props.file.mime_type,
});
</script>

<template>
    <Head :title="$t('Edit') + ' ' + $t('File')" />

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
                    {{ $t("Edit") + " " + $t("File") }}
                </h1>
                <DeleteFileForm :fileId="file.id">
                    <TrashIcon class="h-6 w-6" />
                </DeleteFileForm>
            </div>
        </template>

        <div class="flex w-full py-12">
            <div
                class="flex w-full max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 justify-center"
            >
                <div
                    class="flex w-full sm:w-1/2 p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                >
                    <UpdateFileForm
                        :submit="route('files.update', { fileId: file.id })"
                        :file="file"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
