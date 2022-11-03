<template>
    <label class="text-md flex font-bold text-gray-600 whitespace-normal"
        >{{ label }}
    </label>
</template>

<script setup>
import { defineProps } from "vue";

defineProps({
    label: {
        type: String,
        required: true,
    },
});
</script>
