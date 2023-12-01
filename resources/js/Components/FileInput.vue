<script setup>
import { PlusIcon } from "@heroicons/vue/24/solid";
import { onUnmounted } from "vue";
import { onMounted, ref, watch } from "vue";

defineOptions({
    inheritAttrs: false,
});

const maxFileSize = 8;
const mb = 1048576;

const props = defineProps({
    modelValue: {
        type: File,
        default: null,
    },
});

const emit = defineEmits(["update:modelValue"]);

const fileAsDataUrl = ref(null);
const fileSize = ref(null);
const fileExtension = ref(null);
const fileName = ref(null);

const fileIsToLarge = ref(false);

watch(
    () => props.modelValue,
    (newValue) => {
        if (newValue) {
            if (newValue.size <= mb * maxFileSize) {
                const fullname = newValue.name;
                const lastDot = fullname.lastIndexOf(".");
                fileName.value = fullname.substring(0, lastDot);
                fileExtension.value = fullname.substring(lastDot + 1);
                fileSize.value = (newValue.size / mb).toFixed(2);
                fileAsDataUrl.value = newValue.type.match("image.*")
                    ? URL.createObjectURL(newValue)
                    : "/file.png";
            } else {
                fileIsToLarge.value = true;
                emit("update:modelValue", null);
                setTimeout(() => {fileIsToLarge.value = false}, 2000);
            }
        } else {
            fileAsDataUrl.value && URL.revokeObjectURL(fileAsDataUrl.value);
            fileAsDataUrl.value = null;
            fileName.value = null;
            fileExtension.value = null;
            fileSize.value = null;
        }
    },
    { immediate: true }
);

onUnmounted(()=>{
    if(fileAsDataUrl.value)
    URL.revokeObjectURL(fileAsDataUrl.value);
})

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

</script>

<template>
    <div class="relative cursor-pointer">
        <!-- Input для загрузки файла -->
        <input
            type="file"
            class="opacity-0 w-full h-full absolute inset-0 file cursor-pointer"
            @change="$emit('update:modelValue', $event.target.files[0])"
            v-bind="$attrs"
            ref="input"
        />
        <!-- Контейнер для отображения выбранного файла или предложения выбрать файл -->
        <div
            class="border-2 rounded-md p-3 bg-white flex items-start flex-col sm:items-center sm:flex-row justify-between hover:border-blue-500 transition duration-150 ease-in-out border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm drag"
        >
            <!-- Отображение иконки или выбранного изображения -->
            <div class="flex items-center mb-4 sm:mb-0 mr-0 sm:mr-4">
                <!-- Отображение выбранного изображения или подсказка выбора файла -->
                <img
                    v-if="fileAsDataUrl"
                    :src="fileAsDataUrl"
                    alt="Uploaded Image"
                    class="w-36 h-36 object-cover rounded-md"
                />

                <!-- Иконка выбора  -->
                <PlusIcon
                    v-else
                    class="w-6 h-6 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                />

                <!-- Отображение размера файла или подсказки выбора файла -->
                <span v-if="!modelValue" class="ml-2 text-sm text-gray-600">
                    {{ $t("Choose a file") }}
                </span>
                <div v-else class="ml-2 text-sm text-gray-600">
                    <p class="line-clamp-2 break-all font-bold">
                        {{ fileName }}
                    </p>
                    <p>{{ fileExtension }}</p>
                    <p>{{ fileSize }}Mb</p>
                </div>
            </div>

            <!-- Отображение максимального размера файла -->
            <span class="text-sm text-gray-500 text-right flex-1">
                {{ $t("Max file size") + ": " + "8Mb" }}
            </span>

            <!-- Кнопка для очистки выбранного файла -->
            <div class="absolute top-0 right-0 p-1">
                <button
                    v-if="modelValue"
                    type="button"
                    @click="$emit('update:modelValue', null)"
                    class="text-xs text-red-600 hover:text-red-800 focus:outline-none focus:text-red-800"
                >
                    {{ $t("Clear") }}
                </button>
            </div>
        </div>

        <div
            class="absolute top-0 left-0 w-full h-full transform bg-red-500 text-white rounded-lg transition-opacity flex items-center justify-center text-3xl text-center pointer-events-none"
            :class="{
                'opacity-100 duration-75 ': fileIsToLarge,
                'opacity-0 duration-300': !fileIsToLarge,
            }"
        >
            <p>{{ $t("File too big") }}</p>
        </div>
    </div>
</template>

<style>
.file::file-selector-button {
    cursor: pointer;
}
</style>
