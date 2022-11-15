<template>
    <li v-for="(extra, extraIdx) in extrasData" class="py-4">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-500"
                >
                    <ExtrasIcon />
                </span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-900">
                    Extra period
                </p>
                <p class="truncate text-sm text-gray-500">
                    {{ extra }}
                </p>
            </div>
            <div>
                <button
                    type="button"
                    @click="removeExtra(extraIdx)"
                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Remove
                </button>
            </div>
        </div>
    </li>
    <div class="mt-6 grid grid-cols-2 grid-rows-1 space-x-2">
        <Datepicker v-model="extrasData" v-if="toggleDatePickerExtras" range />
        <button
            type="button"
            @click="showDatePickerOnClickExtras"
            class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
        >
            Add extra
        </button>
    </div>
</template>

<script setup>
import { ref } from "vue";
import ExtrasIcon from "../icons/ExtrasIcon.vue";

const extrasData = ref(["2021-08-04", "2021-08-05", "2021-08-06"]);
const toggleDatePickerExtras = ref(false);

const showDatePickerOnClickExtras = () => {
    toggleDatePickerExtras.value = !toggleDatePickerExtras.value;
};

const removeExtra = (extraIdx) => {
    extrasData.value.splice(extraIdx, 1);
};
</script>
