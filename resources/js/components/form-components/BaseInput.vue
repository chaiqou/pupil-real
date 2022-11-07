<template>
    <div>
        <label class="text-md flex font-bold text-gray-600 whitespace-normal"
            >{{ label }}
        </label>
        <input
            @input="handleChange"
            @change="handleChange"
            @blur="handleChange"
            v-model="value"
            :type="type"
            :placeholder="placeholder"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <span class="mt-2 text-sm text-red-500 whitespace-nowrap">{{
            errorMessage
        }}</span>
    </div>
</template>

<script setup>
import { useField } from "vee-validate";
import { defineProps, toRef } from "vue";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
    },
    type: {
        type: String,
        required: false,
        default: "text",
    },
});

function required(value) {
    if (value && value.trim()) {
        return true;
    }
    return "This field is required";
}

const nameRef = toRef(props, "name");
const { handleChange, errorMessage, value } = useField(nameRef, required);
</script>
