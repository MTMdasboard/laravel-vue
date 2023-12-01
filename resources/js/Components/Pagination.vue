<script setup>
import { computed } from "vue";

const displayedPagesCount = 4;

const props = defineProps({
    currentPage: {
        type: Number,
        required: true,
    },
    totalPages: {
        type: Number,
        required: true,
    },
});

// Определение количества отображаемых страниц
const displayedPages = computed(() => {
    const pages = [];
    const totalPagesValue = props.totalPages;

    // Если страниц меньше, чем нужно отобразить, показываем все страницы
    if (totalPagesValue <= displayedPagesCount) {
        for (let i = 1; i <= totalPagesValue; i++) {
            pages.push(i);
        }
    } else {
        const halfDisplay = Math.floor(displayedPagesCount / 2);
        const from = Math.max(1, props.currentPage - halfDisplay);
        const to = Math.min(totalPagesValue, props.currentPage + halfDisplay);

        if (props.currentPage - 2 >= halfDisplay) {
            // pages.push(1);
            pages.push("<<");
        }

        for (let i = from; i <= to; i++) {
            pages.push(i);
        }

        if (totalPagesValue - props.currentPage >= halfDisplay + 2) {
            pages.push(">>");
            // pages.push(totalPagesValue);
        }
    }

    return pages;
});

const routParams = (page) => {
    return {
        ...route().params,
        page: page,
    };
};

</script>

<template>
    <div
        class="flex justify-end p-1 bg-white overflow-hidden shadow-sm sm:rounded-lg font-mono"
    >
        <!-- Кнопка "Previous" -->
        <a
            v-if="currentPage > 1"
            :href="route(route().current(), routParams(currentPage - 1))"
            class="px-3 py-1 text-blue-700 hover:text-blue-900 disabled:opacity-50 focus:outline-none font-extrabold"
        >
            &lt;
        </a>
        <!-- Отображение номеров страниц -->
        <template v-for="pageNumber in displayedPages" :key="pageNumber">
            <!-- Кнопка "<<" -->
            <a
                v-if="pageNumber === '<<'"
                :href="route(route().current(), routParams(1))"
                class="px-3 py-1 text-blue-700 hover:text-blue-900 focus:outline-none font-extrabold"
            >
                &lt;&lt;
            </a>
            <!-- Кнопка ">>" -->
            <a
                v-else-if="pageNumber === '>>'"
                :href="route(route().current(), routParams(totalPages))"
                class="px-3 py-1 text-blue-700 hover:text-blue-900 focus:outline-none font-extrabold"
            >
                &gt;&gt;
            </a>
            <!-- Кнопка страниц -->
            <a
                v-else
                :href="route(route().current(), routParams(pageNumber))"
                :class="{
                    'font-black border border-blue-700 rounded':
                        currentPage === pageNumber,
                    'px-3 py-1 text-blue-700 hover:text-blue-900 focus:outline-none': true,
                }"
            >
                {{ pageNumber }}
            </a>
        </template>
        <!-- Кнопка "Next" -->
        <a
            v-if="currentPage < totalPages"
            :href="route(route().current(), routParams(currentPage + 1))"
            class="px-3 py-1 text-blue-700 hover:text-blue-900 disabled:opacity-50 focus:outline-none font-extrabold"
        >
            &gt;
        </a>
    </div>
</template>
