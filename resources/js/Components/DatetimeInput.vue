<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

const updateDateTime = (event, emit) => {
    const value = event.target.value;
    emit('update:modelValue', value);
};

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({
    focus: () => input.value.focus(),
});

</script>
  
<template>
    <input type="datetime-local" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input" />
</template>
  