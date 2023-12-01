<script setup>
import Pagination from "@/Components/Pagination.vue";
import RouterButton from "@/Components/RouterButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteFileForm from "@/Pages/Files/Partials/DeleteFileForm.vue";
import {
ArrowDownTrayIcon,
MagnifyingGlassIcon,
PlusIcon,
TrashIcon,
} from "@heroicons/vue/24/solid";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import UpdateFileListForm from "./Partials/UpdateFileListForm.vue";

const props = defineProps({
    page: {
        type: Object,
        default: null,
    },
    count: {
        type: Number,
        default: 0,
    },
});

const files = ref(props.page?.data);

const filesUpdate = () => {
    files.value = props.page?.data;
};

const search = ref(route().params.search ?? "");

</script>

<template>
    <Head :title="$t('Files storage')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-full">
                <h1
                    class="flex-1 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center"
                >
                    {{ $t("Files storage") }}
                </h1>

                <RouterButton :href="route('files.create')">
                    <PlusIcon class="h-6 w-6" fill="none" />
                </RouterButton>
            </div>
        </template>

        <div
            class="grid grid-cols-12 w-full max-w-7xl mx-auto py-4 sm:px-6 lg:px-8"
        >
            <UpdateFileListForm
                class="col-start-1 col-span-12 md:col-start-3 md:col-span-8"
                @successUpdate="filesUpdate"
            >

                <div
                    v-if="count > 0"
                    class="text-slate-700 text-md bg-sky-200/50 sm:rounded-t-lg border border-b-0 p-2 pb-0 text-center justify-center flex flex-col md:flex-row gap-2"
                >
                    <span
                        >{{
                            $t("Number of files in storage") +
                            ": " +
                            count +
                            "."
                        }}
                    </span>
                    <span v-if="route().params.search">{{
                        $t("Found") + ": " + page.total + "."
                    }}</span>
                    <span v-if="page.from && page.to">{{
                        $t("Shown from") +
                        " " +
                        page.from +
                        " " +
                        $t("to") +
                        " " +
                        page.to +
                        "."
                    }}</span>
                </div>

                <div
                    v-if="count > 0"
                    class="flex flex-row gap-4 bg-sky-200/50 sm:rounded-b-lg border border-t-0 p-2 mb-4 sticky top-0 z-10 backdrop-blur-sm shadow-md shadow-sky-200"
                >
                    <TextInput
                        id="search"
                        type="text"
                        class="block flex-1"
                        v-model="search"
                        autocomplete="search"
                    />

                    <a
                        :href="route(route().current(), { search: search })"
                        class="w-14 inline-flex justify-center items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer"
                    >
                        <MagnifyingGlassIcon class="w-6 h-6" />
                    </a>
                </div>

                <div v-if="!files || files.length === 0">
                    <p class="text-center text-gray-600">
                        {{ $t("No files") }}
                    </p>
                </div>

                <div v-else>
                    <!-- Отображение файлов -->
                    <div class="flex flex-col gap-2">
                        <Link
                            v-for="item in files"
                            :key="item.id"
                            :href="route('files.edit', { fileId: item.id })"
                            class="w-full border p-2 bg-white shadow-sm sm:rounded-lg relative cursor-pointer group transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-md flex items-center justify-start gap-2"
                        >
                            <img
                                v-if="item.thumb_100x100_path"
                                :src="item.thumb_100x100_path"
                                alt="File preview"
                                class="h-16 object-contain"
                            />

                            <div class="flex-1">
                                <h2
                                    class="font-semibold line-clamp-1 break-all"
                                >
                                    {{
                                        item.filename ?? item.original_filename
                                    }}
                                </h2>

                                <p class="text-gray-600 text-sm text-justify">
                                    {{
                                        $t("Extension") + ": " + item.extension
                                    }}
                                </p>

                                <p class="text-gray-600 text-sm text-justify">
                                    {{
                                        $t("Size") +
                                        ": " +
                                        item.size_in_mb +
                                        "Mb"
                                    }}
                                </p>
                            </div>

                            <div class="flex flex-col md:flex-row gap-2">
                                <a
                                    :href="
                                        route('files.download', {
                                            fileId: item.id,
                                        })
                                    "
                                    download
                                    @click.stop
                                    class="w-full justify-between inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <span class="hidden sm:block mr-2">{{
                                        $t("Download")
                                    }}</span>
                                    <ArrowDownTrayIcon class="w-4 h-4" />
                                </a>

                                <DeleteFileForm
                                    :fileId="item.id"
                                    @successDelete="filesUpdate"
                                    class="w-full justify-between"
                                >
                                    <span class="hidden sm:block mr-2">
                                        {{ $t("Delete") }}
                                    </span>
                                    <TrashIcon class="h-4 w-4" />
                                </DeleteFileForm>
                            </div>
                        </Link>
                    </div>
                    <!-- Пагинация -->
                    <div
                        class="flex justify-end mt-4"
                        v-if="page.last_page > 1"
                    >
                        <Pagination
                            :currentPage="page.current_page"
                            :totalPages="page.last_page"
                        />
                    </div>
                </div>

            </UpdateFileListForm>


        </div>
    </AuthenticatedLayout>
</template>
