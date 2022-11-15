<template>
    <li v-for="(holds, holdIdx) in holdsData" class="py-4">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-500"
                >
                    <HoldsIcon />
                </span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-900">
                    Hold period
                </p>
                <p class="truncate text-sm text-gray-500">
                    {{ holds }}
                </p>
            </div>
            <div>
                <button
                    type="button"
                    @click="removeHold(holdIdx)"
                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Remove
                </button>
            </div>
        </div>
    </li>
    <div class="mt-6 grid grid-cols-2 grid-rows-1 space-x-2">
        <Datepicker v-if="toggleDatePickerHolds" v-model="holdsData" range />
        <button
            type="button"
            @click="showDatePickerOnClickHolds"
            class="appearance-0 flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
        >
            Add holds
        </button>
    </div>
</template>

<script setup>
import { ref } from "vue";
import HoldsIcon from "../icons/HoldsIcon.vue";

const toggleDatePickerHolds = ref(false);

const showDatePickerOnClickHolds = () => {
    toggleDatePickerHolds.value = !toggleDatePickerHolds.value;
};

const holdsData = ref(["2021-08-01", "2021-08-02", "2021-08-03"]);

const removeHold = (holdIdx) => {
    holdsData.value.splice(holdIdx, 1);
};
</script>
