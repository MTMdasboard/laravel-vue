<script setup>
import FileDragArea from "@/Components/FileDragArea.vue";
import FileInput from "@/Components/FileInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    file: {
        type: Object,
        default: null,
    },
    submit: {
        type: String,
        required: true,
    },
});

const form = useForm({
    _method: "patch",
    filename: props.file?.filename ?? "",
    file: props.file?.file ?? null,
});
</script>

<template>
    <FileDragArea v-model="form.file">
        <form
            class="space-y-6 flex flex-col w-full"
            @submit.prevent="form.post(submit, { wantsJson: true })"
            enctype="multipart/form-data"
        >
            <div>
                <InputLabel for="filename" :value="$t('File name')" />

                <TextInput
                    id="filename"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.filename"
                    autofocus
                    autocomplete="filename"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="file" :value="$t('Attach Document')" />

                <FileInput
                    id="file"
                    name="file"
                    class="mt-1 block w-full"
                    v-model="form.file"
                    :required="!form.file"
                />

                <InputError class="mt-2" :message="form.errors.file" />
            </div>

            <div class="flex items-center gap-4 justify-end">
                <progress
                    v-if="form.progress"
                    :value="form.progress.percentage"
                    max="100"
                >
                    {{ form.progress.percentage }}%
                </progress>
                <PrimaryButton v-else :disabled="form.processing">{{
                    $t("Save")
                }}</PrimaryButton>
            </div>
        </form>
    </FileDragArea>
</template>
