<script setup>
import Pagination from "@/Components/Pagination.vue";
import RouterButton from "@/Components/RouterButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { PlusIcon } from "@heroicons/vue/24/solid";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    page: {
        type: Object,
        default: null,
    },
});

const news = ref(props.page?.data);
</script>

<template>
    <Head :title="$t('News')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h1
                    class="flex-1 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center"
                >
                    {{ $t("News") }}
                </h1>

                <RouterButton :href="route('news.create')">
                    <PlusIcon class="h-6 w-6" fill="none" />
                </RouterButton>
            </div>
        </template>

        <div class="py-12 flex w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
                <div v-if="!news || news.length === 0">
                    <p class="text-center text-gray-600 mt-8">
                        {{ $t("No news") }}
                    </p>
                </div>
                <div v-else>
                    <!-- Отображение новостей -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <Link
                            v-for="item in news"
                            :key="item.id"
                            :href="route('news.show', { news: item.id })"
                            class="border p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg relative cursor-pointer group transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-md"
                        >
                            <!-- Отображение изображения или замена на news.jpeg -->
                            <img
                                :src="
                                    item.base64image
                                        ? item.base64image
                                        : '/news.jpeg'
                                "
                                alt="News Image"
                                class="w-full h-40 object-cover mb-4"
                            />
                            <!-- Отображение даты публикации в правом верхнем углу изображения -->
                            <p
                                v-if="item.published_at"
                                class="absolute top-0 right-0 bg-white p-2 text-sm rounded-bl-lg"
                            >
                                {{
                                    new Date(
                                        item.published_at
                                    ).toLocaleDateString()
                                }}
                            </p>
                            <!-- Отображение заголовка -->
                            <h2
                                class="text-lg font-semibold mb-2 text-center line-clamp-2"
                            >
                                {{ item.title }}
                            </h2>
                            <!-- Отображение текста content -->
                            <p
                                v-if="item.content"
                                class="text-gray-600 text-sm line-clamp-3 text-justify"
                            >
                                {{ item.content }}
                            </p>
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>
