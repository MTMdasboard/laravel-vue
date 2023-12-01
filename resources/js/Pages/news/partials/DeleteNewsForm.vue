<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    newsId: {
        type: Number,
        required: true,
    },
});

const confirmingNewsDeletion = ref(false);

const form = useForm({
    password: '',
});

const confirmNewsDeletion = () => {
    confirmingNewsDeletion.value = true;
};

const deleteNews = () => {
    form.delete(route('news.delete', {news: props.newsId}), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingNewsDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">

        <DangerButton @click="confirmNewsDeletion" v-bind="$attrs">
            <slot />
        </DangerButton>

        <Modal :show="confirmingNewsDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{$t('Are you sure you want to delete this publication')}}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{$t('Once a publication is deleted')}}
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> {{$t('Cancel')}} </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteNews"
                    >
                        {{$t('Delete News')}}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
