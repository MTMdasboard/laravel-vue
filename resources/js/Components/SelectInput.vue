<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: [String, Number],
    },
    options: {
        type: Array,
        default: [],
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        ref="input"
    >
        <option :value=null></option>
        <option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
    </select>
</template>
