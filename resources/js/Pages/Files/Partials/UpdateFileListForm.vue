<script setup>
import FileDragArea from "@/Components/FileDragArea.vue";
import FileListInput from "@/Components/FileListInput.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["successUpdate"]);

const form = useForm({
    _method: "patch",
    filelist: null,
});

const uploadFileList = () => {
    form.post(route("files.multiple"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            emit("successUpdate");
        },
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    form.reset();
};

</script>

<template>
    <FileDragArea v-model="form.filelist" v-bind="$attrs" multiple>
        <slot />
    </FileDragArea>

    <Modal :show="form.filelist && form.filelist.length>0" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ $t("Multiple file uploads") }}
            </h2>

            <FileListInput v-model="form.filelist" class="mt-6" />
            
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    {{ $t("Cancel") }}
                </SecondaryButton>

                <PrimaryButton
                    v-if="form.filelist && form.filelist.length>0"
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="uploadFileList"
                >
                    {{ $t("Upload files") }}
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
