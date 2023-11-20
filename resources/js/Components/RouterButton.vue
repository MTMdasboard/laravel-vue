<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    class: {
        type: String,
        default: 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' 
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    disabledClass: {
        type: String,
        default: 'opacity-50 cursor-not-allowed'
    }
});

</script>

<template>
    <span v-if="disabled" :class="disabledClass"> <slot /> </span>
    <Link v-else :href="href" :class="class">
    <slot />
    </Link>
</template>
