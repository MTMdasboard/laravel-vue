<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    fileId: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(["successDelete"]);

const confirmingFileDeletion = ref(false);

const form = useForm({});

const confirmFileDeletion = (e) => {
    e.preventDefault();
    confirmingFileDeletion.value = true;
};

const deleteFile = () => {
    form.delete(route("files.delete", { fileId: props.fileId }), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            emit("successDelete", props.fileId);
        },
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingFileDeletion.value = false;

    form.reset();
};
</script>

<template>
    <DangerButton @click="confirmFileDeletion" v-bind="$attrs">
        <slot />
    </DangerButton>

    <Modal :show="confirmingFileDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ $t("Are you sure you want to delete this file") }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ $t("Once a file is deleted") }}
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    {{ $t("Cancel") }}
                </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="deleteFile"
                >
                    {{ $t("Delete file") }}
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
