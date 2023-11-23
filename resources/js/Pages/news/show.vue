<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import RouterButton from "@/Components/RouterButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
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

const showCommentField = ref(false); // Отображение/скрытие поля для добавления комментария
const newComment = ref(""); // Новый комментарий

const toggleCommentField = () => {
    showCommentField.value = !showCommentField.value;
    if (showCommentField.value) {
        setTimeout(() => {
            const commentsAnchor = document.getElementById("commentsAnchor");
            commentsAnchor.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }, 250);
    }
};

const addComment = async () => {
    if (newComment.value.trim() !== "") {
        try {
            // Получение CSRF-токена из мета-тега

            const token = document.head.querySelector(
                'meta[name="csrf-token"]'
            ).content;

            const response = await fetch(
                `/news/${props.newsOnce.id}/comments`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: JSON.stringify({ content: newComment.value }),
                }
            );

            if (response.ok) {
                props.newsOnce.comments.unshift({ content: newComment.value });
                newComment.value = "";
            }
        } catch (error) {
            console.error("Произошла ошибка:", error);
        }
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
                    class="inline-flex h-10 cursor-pointer items-center rounded-md border border-transparent bg-gray-800 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
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
                    class="flex-1 text-center text-2xl font-semibold leading-tight text-gray-800 sm:text-4xl"
                >
                    {{ newsOnce.title }}
                </h1>
                <RouterButton
                    :href="route('news.edit', { news: newsOnce.id })"
                    class="inline-flex h-10 cursor-pointer items-center rounded-md border border-transparent bg-gray-800 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
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

        <div class="flex w-full justify-center py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Изображение -->
                <div class="flex justify-center">
                    <div
                        class="relative mb-4 flex w-fit items-center justify-center"
                    >
                        <img
                            :src="
                                props.newsOnce.base64image
                                    ? props.newsOnce.base64image
                                    : '/news.jpeg'
                            "
                            alt="News Image"
                            class="rounded-lg object-cover p-2"
                        />

                        <div
                            class="absolute bottom-0 left-0 right-0 flex justify-between"
                        >
                            <div
                                class="flex items-center rounded-lg bg-white p-2 text-xs font-semibold tracking-widest shadow-lg"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="mr-2 h-6 w-6 text-gray-400"
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
                                class="reset-hover inline-flex items-center rounded-lg border border-transparent bg-white p-2 text-xs font-semibold tracking-widest shadow-lg transition duration-150 ease-in-out hover:bg-gray-700 hover:text-white focus:bg-gray-700 focus:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                                @click="incrementLikes"
                                :ref="likesButton"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="mr-2 h-5 w-5 text-gray-400"
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

                <!-- Контент -->
                <div
                    class="overflow-hidden bg-white p-6 shadow-lg sm:rounded-lg"
                >
                    <div
                        v-if="props.newsOnce.content"
                        class="mt-4 text-justify text-lg text-gray-900"
                    >
                        {{ props.newsOnce.content }}
                    </div>
                    <div class="mt-4 grid grid-cols-2 text-sm text-gray-600">
                        <div
                            v-if="props.newsOnce.user?.name"
                            class="flex items-center"
                        >
                            {{ props.newsOnce.user.name }}
                        </div>
                        <div
                            v-if="props.newsOnce.published_at"
                            class="col-start-2 flex items-center justify-end"
                        >
                            {{
                                new Date(
                                    props.newsOnce.published_at
                                ).toLocaleDateString()
                            }}
                        </div>
                    </div>
                </div>

                <!-- Комментарии -->
                <div class="p-6 md:w-2/3 md:mx-auto">
                    <button
                        @click="toggleCommentField"
                        id="commentsAnchor"
                        class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                    >
                        {{ $t("Comments") }}
                    </button>

                    <!-- Поле для добавления комментария с анимацией -->
                    <transition name="comment">
                        <div
                            v-if="showCommentField"
                            class="mt-4"
                            :style="{ height: showCommentField ? 'auto' : '0' }"
                        >
                            <textarea
                                v-model="newComment"
                                class="w-full rounded-lg border border-gray-300 p-2 focus:outline-none"
                                rows="4"
                                placeholder="Оставьте комментарий"
                            ></textarea>
                            
                            <div class="mt-2 flex justify-end">
                                <PrimaryButton @click="addComment">
                                    {{ $t("Add") }}
                                </PrimaryButton>
                            </div>

                            <!-- Отображение комментариев -->
                            <div
                                class="overflow-hidden bg-white mt-4 shadow-lg sm:rounded-lg"
                                v-if="
                                    props.newsOnce.comments &&
                                    props.newsOnce.comments.length
                                "
                            >
                                <div
                                    v-for="(comment, index) in props.newsOnce
                                        .comments"
                                    :key="index"
                                    class="border border-indigo-300 rounded-lg p-3 m-4 text-justify text-lg text-gray-900"
                                >
                                    <p>{{ comment.content }}</p>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.comment-enter-active,
.comment-leave-active {
    transition: max-height 1s ease-in-out;
}

.comment-enter-from,
.comment-leave-to {
    max-height: 0;
    overflow: hidden;
    transition-delay: 0s; /* Убрать задержку */
}

.comment-enter-to,
.comment-leave-from {
    max-height: 1000px; /* Замените на достаточно большое значение */
    overflow: hidden;
}

.comment-leave-active {
    transition-duration: 0.2s; /* Уменьшить продолжительность анимации при закрытии */
}
</style>
