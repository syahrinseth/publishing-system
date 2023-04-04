<script setup>
const props = defineProps({
    text: {
        type: String,
        required: true
    },
    tooltip: {
        type: String,
        required: false
    }
});
</script>
<template>
    <span class="group relative w-max">
        <span class="bg-red-500 rounded-full px-3 py-1 text-white">
            {{ text }}
        </span>
        <span
        class="pointer-events-none absolute -top-7 left-0 w-max opacity-0 transition-opacity group-hover:opacity-100 bg-slate-500 text-white rounded px-2 py-1"
        >
            {{ tooltip }}
        </span>
    </span>
</template>