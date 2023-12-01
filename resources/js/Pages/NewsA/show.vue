<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import RouterButton from "@/Components/RouterButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    ChevronLeftIcon,
    EyeIcon,
    HandThumbUpIcon,
    PencilSquareIcon,
} from "@heroicons/vue/24/solid";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

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
                <RouterButton :href="route('news')">
                    <ChevronLeftIcon class="h-6 w-6" />
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
                    <PencilSquareIcon class="h-6 w-6" />
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
                                <EyeIcon class="mr-2 h-6 w-6 text-gray-400" />
                                <span>{{ props.newsOnce.views }}</span>
                            </div>
                            <button
                                class="reset-hover inline-flex items-center rounded-lg border border-transparent bg-white p-2 text-xs font-semibold tracking-widest shadow-lg transition duration-150 ease-in-out hover:bg-gray-700 hover:text-white focus:bg-gray-700 focus:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                                @click="incrementLikes"
                                :ref="likesButton"
                            >
                                <HandThumbUpIcon
                                    class="mr-2 h-5 w-5 text-gray-400"
                                />
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
                    <PrimaryButton
                        @click="toggleCommentField"
                        id="commentsAnchor"
                        class="w-full justify-center"
                    >
                        {{ $t("Comments") }}
                    </PrimaryButton>

                    <!-- Поле для добавления комментария с анимацией -->
                    <transition name="comment">
                        <div
                            v-if="showCommentField"
                            class="mt-4"
                            :style="{ height: showCommentField ? 'auto' : '0' }"
                        >
                            <TextAreaInput
                                v-model="newComment"
                                class="w-full"
                                rows="4"
                                placeholder="Оставьте комментарий"
                            ></TextAreaInput>

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
