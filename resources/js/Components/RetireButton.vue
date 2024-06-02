<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['', 'active']);

const classes = computed(() => props.active
    ? 'flex items-center mb-2 mt-6 py-2 px-1 bg-gray-700 bg-opacity-25 text-gray-100'
    : 'flex items-center mb-2 mt-6 py-2 px-1 text-gray-100'
);
</script>

<template>
    <button
        :class="classes"
        :type="type"
        class="inline-flex items-center justify-center   px-2 py-1 bg-white border border-red-500 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest shadow-xs hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>

