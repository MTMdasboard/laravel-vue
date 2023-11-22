<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import RouterButton from "@/Components/RouterButton.vue";
import { onMounted, ref, watchEffect } from "vue";

const props = defineProps({
    newsOnce: {
        type: Object,
        default: null,
    },
});

const likesButton = ref(null);

const incrementLikes = async () => {
    try {
        const response = await fetch(`/news/${props.newsOnce.id}/like`, {
            method: "GET",
        });

        if (response.ok) {
            const data = await response.json();
            props.newsOnce.likes = data.likes;
        }

        const button = document.activeElement;
        button.blur();
        button.classList.add("reset-hover");
        setTimeout(() => {
            button.classList.remove("reset-hover");
        }, 10);
    } catch (error) {
        console.error("Произошла ошибка:", error);
    }
};

const comments = ref(['Комментарий 1', 'Комментарий 2', 'Комментарий 3']); // Пример оставленных комментариев
const showCommentField = ref(false); // Отображение/скрытие поля для добавления комментария
const newComment = ref(''); // Новый комментарий

const toggleCommentField = () => {
  showCommentField.value = !showCommentField.value;
};

const addComment = () => {
  if (newComment.value.trim() !== '') {
    comments.value.push(newComment.value);
    newComment.value = '';
    showCommentField.value = false;
  }
};
</script>

<template>
    <Head :title="newsOnce.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <RouterButton
                    :href="route('news')"
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
                    {{ newsOnce.title }}
                </h1>
                <RouterButton
                    :href="route('news.edit', { news: newsOnce.id })"
                    class="inline-flex h-10 items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"
                        />
                        <path
                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"
                        />
                    </svg>
                </RouterButton>
            </div>
        </template>

        <div class="py-12 flex justify-center w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <div
                        class="relative w-fit flex items-center justify-center mb-4"
                    >
                        <img
                            :src="
                                props.newsOnce.base64image
                                    ? props.newsOnce.base64image
                                    : '/news.jpeg'
                            "
                            alt="News Image"
                            class="object-cover rounded-lg p-2"
                        />

                        <div
                            class="absolute bottom-0 left-0 right-0 flex justify-between"
                        >
                            <div
                                class="flex items-center p-2 rounded-lg bg-white shadow-lg font-semibold text-xs tracking-widest"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 mr-2 text-gray-400"
                                    viewBox="0 0 488.85 488.85"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M244.425,98.725c-93.4,0-178.1,51.1-240.6,134.1c-5.1,6.8-5.1,16.3,0,23.1c62.5,83.1,147.2,134.2,240.6,134.2
                                                s178.1-51.1,240.6-134.1c5.1-6.8,5.1-16.3,0-23.1C422.525,149.825,337.825,98.725,244.425,98.725z M251.125,347.025
                                                c-62,3.9-113.2-47.2-109.3-109.3c3.2-51.2,44.7-92.7,95.9-95.9c62-3.9,113.2,47.2,109.3,109.3
                                                C343.725,302.225,302.225,343.725,251.125,347.025z M248.025,299.625c-33.4,2.1-61-25.4-58.8-58.8c1.7-27.6,24.1-49.9,51.7-51.7
                                                c33.4-2.1,61,25.4,58.8,58.8C297.925,275.625,275.525,297.925,248.025,299.625z"
                                    />
                                </svg>
                                <span>{{ props.newsOnce.views }}</span>
                            </div>
                            <button
                                class="reset-hover inline-flex items-center p-2 rounded-lg bg-white shadow-lg border border-transparent font-semibold text-xs hover:text-white focus:text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                @click="incrementLikes"
                                :ref="likesButton"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2 text-gray-400"
                                    viewBox="0 0 1024 1024"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M939.516933 410.236936H666.879976C772.478959 19.839997 591.998988 0 591.998988 0c-73.598989 0-58.239991 59.519991-63.99999 69.759989 0 191.99797-202.877968 340.476947-202.877969 340.476947v541.436915c0 53.119992 74.879988 72.319989 101.759984 72.319989h409.596936c38.399994 0 69.759989-101.119984 69.759989-101.119984 101.118984-344.957946 101.118984-447.99693 101.118985-447.99693a63.99999 63.99999 0 0 0-68.47999-63.99999z m-725.754886 0H49.922072a33.279995 33.279995 0 0 0-33.918995 33.279995l33.919995 545.916914a33.919995 33.919995 0 0 0 34.559995 34.559995h141.438978c29.439995 0 29.439995-23.039996 29.439995-23.039996V451.836929a40.319994 40.319994 0 0 0-41.599993-41.599993z"
                                    />
                                </svg>
                                <span>{{ props.newsOnce.likes }}</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6"
                >
                    <div
                        v-if="props.newsOnce.content"
                        class="text-gray-900 text-lg mt-4 text-justify"
                    >
                        {{ props.newsOnce.content }}
                    </div>
                    <div class="grid grid-cols-2 text-gray-600 text-sm mt-4">
                        <div
                            v-if="props.newsOnce.user?.name"
                            class="flex items-center"
                        >
                            {{ props.newsOnce.user.name }}
                        </div>
                        <div
                            v-if="props.newsOnce.published_at"
                            class="flex items-center col-start-2 justify-end"
                        >
                            {{
                                new Date(
                                    props.newsOnce.published_at
                                ).toLocaleDateString()
                            }}
                        </div>
                    </div>
                </div>

                <!-- ... -->
                <div
                    class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6"
                >
                    <!-- ... -->

                    <!-- Комментарии -->
                    <!-- <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Комментарии</h2>

                        <div
                            v-for="(comment, index) in comments"
                            :key="index"
                            class="mb-4"
                        >
                            <p class="text-gray-600 text-sm">{{ comment }}</p>
                        </div>

                        <div v-if="showCommentField">
                            <textarea
                                v-model="newComment"
                                class="w-full rounded-lg border border-gray-300 p-2 focus:outline-none"
                                rows="4"
                                placeholder="Оставьте комментарий"
                            ></textarea>
                            <div class="flex justify-end mt-2">
                                <button
                                    @click="addComment"
                                    class="bg-gray-800 text-white px-4 py-2 rounded-lg focus:outline-none"
                                >
                                    Добавить
                                </button>
                            </div>
                        </div>

                        <div v-else>
                            <button
                                @click="toggleCommentField"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg focus:outline-none"
                            >
                                Добавить комментарий
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
