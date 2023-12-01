<script setup>
import { DocumentIcon, TrashIcon } from "@heroicons/vue/24/solid";
import { onBeforeMount, onUnmounted, ref, watch } from "vue";

defineOptions({
    inheritAttrs: false,
});

const maxFileSize = 8;
const mb = 1048576;

const props = defineProps({
    modelValue: {
        type: Array,
        default: null,
    },
});

const emit = defineEmits(["update:modelValue"]);

const selectedFiles = ref([]);

const fileIsToLarge = ref(false);

let stopWatch;
let startWatch;

onBeforeMount(() => {
    stopWatch = watch(
        () => props.modelValue,
        () => {},
        { immediate: true }
    );

    startWatch = watch(
        () => props.modelValue,
        (newValue) => {

            if (newValue && newValue.length > 0) {
                let size = 0;
                let index = 0;
                for (const file of newValue) {
                    if (file.size + size <= mb * maxFileSize) {
                        selectedFiles.value.push({
                            index: index++,
                            fileName: file.name,
                            fileSize: (file.size / mb).toFixed(2),
                            fileAsDataUrl: file.type.match("image.*")
                                ? URL.createObjectURL(file)
                                : null,
                        });

                        size += file.size;
                    } else {
                        fileIsToLarge.value = true;
                        setTimeout(() => {
                            emit("update:modelValue", null);
                            fileIsToLarge.value = false;
                        }, 2000);
                        break;
                    }
                }
            } else {
                if (selectedFiles.value.length > 0)
                    for (const file of selectedFiles.value)
                        if (file.fileAsDataUrl.value)
                            URL.revokeObjectURL(file.fileAsDataUrl.value);

                selectedFiles.value = [];
            }
        },
        { immediate: true }
    );
});

const unselectFile = (fileIndex) => {
    const fileToRemove = selectedFiles.value[fileIndex];

    if (fileToRemove.fileAsDataUrl) {
        URL.revokeObjectURL(fileToRemove.fileAsDataUrl);
    }

    selectedFiles.value.splice(fileIndex, 1);

    const updatedFiles = props.modelValue.filter(
        (file, index) => index !== fileIndex
    );

    stopWatch();

    emit("update:modelValue", updatedFiles);

    startWatch();
};

onUnmounted(() => {
    if (selectedFiles?.value.length > 0)
        for (const file of selectedFiles.value)
            if (file.fileAsDataUrl) URL.revokeObjectURL(file.fileAsDataUrl);
});

</script>

<template>
    <div class="relative min-h-[3rem]" v-bind="$attrs">

        <div
            v-if="selectedFiles && selectedFiles.length > 0"
            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2"
        >
            <div v-for="item in selectedFiles" :key="item.index" class="h-16">
                <article
                    class="group w-full h-full rounded-md focus:outline-none focus:shadow-outline bg-blue-100 cursor-pointer relative shadow-md transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl"
                >
                    <img
                        v-if="item.fileAsDataUrl"
                        :src="item.fileAsDataUrl"
                        alt="Uploaded Image"
                        class="w-full h-full sticky object-cover rounded-md bg-fixed"
                    />

                    <section
                        class="flex-col rounded-md text-xs w-full h-full z-20 absolute top-0 p-2"
                        :class="[
                            item.fileAsDataUrl
                                ? 'hidden group-hover:flex hover:text-white bg-blue-700/75'
                                : 'flex hover:text-blue-800',
                        ]"
                    >
                        <h6 class="flex-1 line-clamp-1 break-all font-semibold">
                            {{ item.fileName }}
                        </h6>

                        <div class="flex items-center gap-2">
                            <span class="">
                                <i>
                                    <DocumentIcon
                                        class="fill-current w-4 h-4 ml-auto"
                                    />
                                </i>
                            </span>

                            <p class="size text-xs">
                                {{ item.fileSize + "Mb" }}
                            </p>

                            <button
                                class="ml-auto focus:outline-none hover:bg-blue-300 hover:text-blue-900 rounded-md"
                                @click="() => unselectFile(item.index)"
                            >
                                <TrashIcon
                                    class="pointer-events-none fill-current w-4 h-4 ml-auto"
                                />
                            </button>
                        </div>
                    </section>
                </article>
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
