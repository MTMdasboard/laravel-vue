<script setup>
import RouterButton from "@/Components/RouterButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted, computed, ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    newsList: {
        type: Object,
        default: null,
    },
});

console.log(props.newsList);
// Логика пагинации
const currentPage = ref(props.newsList.current_page);
const totalPages = ref(props.newsList.last_page);
const news = ref(props.newsList.data);

// Определение количества отображаемых страниц
const displayedPagesCount = 10;

const displayedPages = computed(() => {
    const pages = [];
    const totalPagesValue = totalPages.value;

    // Если страниц меньше, чем нужно отобразить, показываем все страницы
    if (totalPagesValue <= displayedPagesCount) {
        for (let i = 1; i <= totalPagesValue; i++) {
            pages.push(i);
        }
    } else {
        const halfDisplay = Math.floor(displayedPagesCount / 2);
        const from = Math.max(1, currentPage.value - halfDisplay);
        const to = Math.min(totalPagesValue, currentPage.value + halfDisplay);

        if (currentPage.value - 1 >= halfDisplay) {
            pages.push(1);
            pages.push("...");
        }

        for (let i = from; i <= to; i++) {
            pages.push(i);
        }

        if (totalPagesValue - currentPage.value >= halfDisplay) {
            pages.push("...");
            pages.push(totalPagesValue);
        }
    }

    return pages;
});
</script>

<template>
    <Head :title="$t('News')" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h1 class="flex-1 font-semibold text-2xl sm:text-4xl text-gray-800 leading-tight text-center">
                    {{ $t("News") }}
                </h1>

                <RouterButton :href="route('news.create')"
                    class="inline-flex h-10 items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </RouterButton>
            </div>
        </template>

        <div class="py-12 flex w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
                <div class="">
                    <!-- Отображение новостей -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <Link v-for="item in news" :key="item.id" :href="route('news.show', { news: item.id })"
                            class="border p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg relative cursor-pointer group transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-md">
                        <!-- Отображение изображения или замена на news.jpeg -->
                        <img :src="
                            item.base64image
                                ? item.base64image
                                : '/news.jpeg'
                        " alt="News Image" class="w-full h-40 object-cover mb-4" />
                        <!-- Отображение даты публикации в правом верхнем углу изображения -->
                        <p v-if="item.published_at" class="absolute top-0 right-0 bg-white p-2 text-sm rounded-bl-lg">
                            {{
                                new Date(
                                    item.published_at
                                ).toLocaleDateString()
                            }}
                        </p>
                        <!-- Отображение заголовка -->
                        <h2 class="text-lg font-semibold mb-2 text-center line-clamp-2">
                            {{ item.title }}
                        </h2>
                        <!-- Отображение текста content -->
                        <p v-if="item.content" class="text-gray-600 text-sm line-clamp-3 text-justify">
                            {{ item.content }}
                        </p>
                        </Link>
                    </div>
                    <!-- Пагинация -->
                    <div class="flex justify-end">
                        <div class="flex justify-end mt-4 bg- overflow-hidden shadow-sm sm:rounded-lg font-mono">
                            <!-- Кнопка "Previous" -->
                            <RouterButton :href="route('news', { page: currentPage - 1 })" :disabled="currentPage === 1"
                                class="px-3 py-1 text-blue-700 hover:text-blue-900 focus:outline-none font-extrabold"
                                :disabled-class="'px-3 py-1 text-blue-700 opacity-50 font-extrabold cursor-not-allowed'">
                                &lt;
                            </RouterButton>
                            <!-- Отображение номеров страниц -->
                            <template v-for="pageNumber in displayedPages" :key="pageNumber">
                                <span v-if="pageNumber === '...'" class="mx-2">{{ pageNumber }}</span>
                                <RouterButton v-else :href="route('news', { page: pageNumber })" :class="{
                                    'font-black':
                                        currentPage === pageNumber,
                                    'px-3 py-1 text-blue-700 hover:text-blue-900 focus:outline-none': true,
                                    'border border-blue-700 rounded':
                                        currentPage === pageNumber,
                                }">
                                    {{ pageNumber }}
                                </RouterButton>
                            </template>
                            <!-- Кнопка "Next" -->
                            <RouterButton :href="route('news', { page: currentPage + 1 })"
                                :disabled="currentPage === totalPages"
                                class="px-3 py-1 text-blue-700 hover:text-blue-900 disabled:opacity-50 focus:outline-none font-extrabold"
                                :disabled-class="'px-3 py-1 text-blue-700 opacity-50 font-extrabold cursor-not-allowed'">
                                &gt;
                            </RouterButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Стили для пагинации */
button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.group:hover .group-hover\:bg-highlight {
    background-color: rgba(79, 70, 229, 0.1);
}
</style>
