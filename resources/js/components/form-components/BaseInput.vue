<template>
    <div>
        <label class="text-md flex font-bold text-gray-600 whitespace-normal"
            >{{ label }}
        </label>
        <input
            :name="name"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            @change="handleChange"
            @blur="handleChange"
            :type="type"
            :min="min"
            :max="max"
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
    min: {
        type: [Number, String],
        required: false,
    },
    max: {
        type: [Number, String],
        required: false,
    },
    modelValue: {
        type: [String, Number, Array],
        default: "",
    },
});

function required(value) {
    if (value) {
        return true;
    }
    return "This field is required";
}

const nameRef = toRef(props, "name");
const { handleChange, errorMessage } = useField(nameRef, required);
</script>
