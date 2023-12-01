<script setup>
import { CloudArrowUpIcon } from "@heroicons/vue/24/solid";
import { ref } from "vue";

const props = defineProps({
    modelValue: {
        type: [File, Array],
        default: null,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue"]);

const hasFiles = ({ dataTransfer: { types = [] } }) =>
    types.indexOf("Files") > -1;

const draggedover = ref(false);

function setDraggedover(value) {
    draggedover.value = value;
}

let counter = 0;

function dropHandler(e) {
    e.preventDefault();
    if (props.multiple) {
        emit("update:modelValue", Array.from(e.dataTransfer.files));
    } else {
        emit("update:modelValue", e.dataTransfer.files[0]);
    }
    setDraggedover(false);
    counter = 0;
}

function dragEnterHandler(e) {
    e.preventDefault();
    if (!hasFiles(e)) {
        return;
    }
    ++counter && setDraggedover(true);
}

function dragLeaveHandler(e) {
    1 > --counter && setDraggedover(false);
}

function dragOverHandler(e) {
    if (hasFiles(e)) {
        e.preventDefault();
    }
}
</script>

<template>
    <section
        class="relative min-h-[8rem]"
        @drop="dropHandler($event)"
        @dragover="dragOverHandler($event)"
        @dragleave="dragLeaveHandler($event)"
        @dragenter="dragEnterHandler($event)"
    >
        <div
            v-if="draggedover"
            class="absolute w-full h-full top-0 left-0 pointer-events-none z-50 rounded-md bg-sky-100/90 border-double border-sky-500 border-2"
        >
            <div
                class="sticky top-1/2 flex flex-col items-center justify-center"
            >
                <i>
                    <CloudArrowUpIcon
                        class="fill-current w-12 h-12 mb-3 text-blue-700"
                    />
                </i>
                <p class="text-lg text-blue-700">
                    {{ $t("Drop files to upload") }}
                </p>
            </div>
        </div>
        <slot />
    </section>
</template>
