<template>
    <button
        :type="type"
        class="flex w-full justify-center mt-4 rounded-md px-4 py-2 text-base font-medium text-white"
    >
        <p class="text-center">{{ text }}</p>
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
