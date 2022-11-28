<template>
    <div>
        <label class="text-md flex font-bold text-gray-600 whitespace-normal"
            >{{ label }}
        </label>
        <Datepicker
            range
            closeOnScroll
            :name="name"
            :value="modelValue"
            :minDate="new Date()"
            :maxDate="addYears(new Date(), 1)"
            @input="$emit('update:modelValue', $event.target.value)"
            v-model="value"
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
import { addYears } from "date-fns";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
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
const { handleChange, errorMessage, value } = useField(nameRef, required);
</script>
