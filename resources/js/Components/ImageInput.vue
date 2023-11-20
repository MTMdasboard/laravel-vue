<script setup>
import { onMounted, ref } from 'vue';
import Compressor from 'compressorjs';

const props = defineProps({
    modelValue: {
        type: String,
    },
    required: {
        type: Boolean,
        default: false,
    },
    id: {
        type: String,
        default: 'base64image',
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);
const fileSize = ref({ value: null });

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const onChange = async (event, emit) => {
    const file = event.target.files[0];

    if (!file) {
        return;
    }

    const compressedFile = await compressImage(file);

    const reader = new FileReader();

    reader.onload = (e) => {
        emit('update:modelValue', e.target.result);
        fileSize.value = { value: compressedFile.size };
    };

    reader.readAsDataURL(compressedFile);
};

const compressImage = async (file) => {
    return new Promise((resolve, reject) => {
        const compressor = new Compressor(
            file,
            {
                quality: 0.6,
                success(result) {
                    resolve(result);
                },
                error(error) {
                    reject(error);
                },
            }
        );
    });
};

</script>

<template>
    <div class="relative">
        <input type="file" accept="image/jpeg, image/png, image/gif, image/webp" class="opacity-0 w-full h-full absolute inset-0 cursor-pointer"
            @change="event => onChange(event, $emit)" :id="id" :required="required" ref="input" />
        <div class="border-2 rounded-md p-3 bg-white flex items-center justify-between 
                        hover:border-blue-500 transition duration-150 ease-in-out
                        border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
            :class="fileSize.value > 102400 ? 'border-red-500' : ''">
            <div class="flex items-center">
                <svg v-if="!modelValue" class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                <img v-else :src="modelValue" alt="Uploaded Image" class="w-24 h-24 object-cover rounded-md" />
                <span v-if="!modelValue" class="ml-2 text-sm text-gray-600">{{ $t('Choose a file') }}</span>
                <span v-else class="ml-2 text-sm text-gray-600">{{ (fileSize.value / 1024).toFixed(2) }}kb</span>
            </div>
            <span class="text-sm text-gray-500">{{ $t('Max file size: 100kb') }}</span>
            <div class="absolute top-0 right-0 p-1">
                <button v-if="modelValue" type="button" @click="$emit('update:modelValue', ''); fileSize = { value: null };"
                    class="text-xs text-red-600 hover:text-red-800 focus:outline-none focus:text-red-800">
                    {{ $t('Clear') }}
                </button>
            </div>
        </div>
    </div>
</template>
