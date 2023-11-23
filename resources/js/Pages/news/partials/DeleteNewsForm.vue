<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    newsOnce: {
        type: Object,
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
    form.delete(route('news.delete', {news: props.newsOnce.id}), {
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

        <DangerButton @click="confirmNewsDeletion" class="h-10">                    
            <svg
                        class="h-4 w-4"
                        fill="currentColor"
                        stroke="currentColor"
                        viewBox="0 0 1049 1024"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M524.816493 830.218181a35.83281 35.83281 0 0 0 35.788334-35.803159v-412.292279a35.803159 35.803159 0 0 0-71.591493 0v412.292279A35.83281 35.83281 0 0 0 524.816493 830.218181zM705.374122 830.218181a35.83281 35.83281 0 0 0 35.788334-35.803159v-412.292279a35.803159 35.803159 0 0 0-71.591493 0v412.292279A35.83281 35.83281 0 0 0 705.374122 830.218181zM344.199563 830.218181a35.83281 35.83281 0 0 0 35.788334-35.803159v-412.292279a35.803159 35.803159 0 0 0-71.591493 0v412.292279c0.756092 19.688031 16.826743 35.803159 35.803159 35.803159z"
                        />
                        <path
                            d="M1013.770526 128.639342H766.721316V86.920879A87.00983 87.00983 0 0 0 679.800437 0H370.633117a87.00983 87.00983 0 0 0-86.906054 86.920879v41.718463H35.788334a35.788334 35.788334 0 0 0 0 71.576668H154.183377V885.071883a139.031895 139.031895 0 0 0 138.868816 138.868816h463.439649A139.031895 139.031895 0 0 0 895.360658 885.071883V199.400617h118.409868A35.83281 35.83281 0 0 0 1049.632986 163.612283c0-19.613905-15.803796-34.972941-35.86246-34.972941zM354.414211 86.920879A15.996525 15.996525 0 0 1 370.633117 70.761275h309.16732a15.996525 15.996525 0 0 1 16.159604 16.159604v41.718463H354.414211zM823.769165 885.071883a67.35145 67.35145 0 0 1-67.277323 67.277323H293.067018A67.366275 67.366275 0 0 1 225.774869 885.071883V199.400617h597.994296z"
                        />
                    </svg>
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
