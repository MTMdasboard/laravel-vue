<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import ImageInput from "@/Components/ImageInput.vue";
import DatetimeInput from "@/Components/DatetimeInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
    newsOnce: {
        type: Object,
        default: null,
    },
    userList: {
        type: Object,
        default: null,
    },
    submit: {
        type: String,
        required: true,
    },
});

const form = useForm({
    user_id: props.newsOnce?.user_id ?? null,
    title: props.newsOnce?.title ?? "",
    content: props.newsOnce?.content ?? "",
    published_at: props.newsOnce?.published_at ?? null,
    base64image: props.newsOnce?.base64image ?? "",
});
</script>

<template>
    <section class="flex w-full">
        <form
            @submit.prevent="form.patch(submit)"
            class="space-y-6 flex flex-col w-full"
        >
            <div>
                <InputLabel for="title" :value="$t('Title')" />

                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    autofocus
                    required
                    autocomplete="title"
                />

                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div>
                <InputLabel for="base64image" :value="$t('Image')" />

                <ImageInput
                    id="base64image"
                    type="file"
                    class="mt-1 block w-full"
                    v-model="form.base64image"
                    autocomplete="base64image"
                />

                <InputError class="mt-2" :message="form.errors.base64image" />
            </div>

            <div>
                <InputLabel for="content" :value="$t('Content')" />

                <TextAreaInput
                    id="content"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.content"
                    rows="4"
                    autocomplete="content"
                />

                <InputError class="mt-2" :message="form.errors.content" />
            </div>

            <div>
                <InputLabel
                    for="published_at"
                    :value="$t('Publication date')"
                />
                <DatetimeInput
                    id="published_at"
                    class="mt-1 block w-full"
                    v-model="form.published_at"
                    autocomplete="published_at"
                />

                <InputError class="mt-2" :message="form.errors.published_at" />
            </div>

            <div>
                <InputLabel for="user_id" :value="$t('Author')" />

                <SelectInput
                    id="user_id"
                    class="mt-1 block w-full"
                    v-model="form.user_id"
                    :options="userList"
                    autocomplete="Author"
                />

                <InputError class="mt-2" :message="form.errors.user_id" />
            </div>

            <div class="flex items-center gap-4 justify-end">
                <PrimaryButton :disabled="form.processing">{{
                    $t("Save")
                }}</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        {{ $t("Saved.") }}
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
