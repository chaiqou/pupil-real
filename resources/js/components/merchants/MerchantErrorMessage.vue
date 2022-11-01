<template>
    <p class="mt-2 text-sm text-red-500">
        <ErrorMessage :name="name" />
    </p>
</template>

<script setup>
import { ErrorMessage } from "vee-validate";
import { defineProps } from "vue";
4;

defineProps({
    name: {
        type: String,
        required: true,
    },
});
</script>
