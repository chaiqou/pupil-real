<template>
    <button
        :type="type"
        class="inline-flex mt-4 w-full text-center items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    >
        {{ text }}
    </button>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    text: {
        type: String,
        required: true,
    },

    type: {
        type: String,
        required: false,
        default: "submit",
    },
});
</script>
