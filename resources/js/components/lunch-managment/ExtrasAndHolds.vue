<template>
    <div
        class="flex max-h-screen flex-col justify-center overflow-hidden bg-inherit"
    >
        <div class="rounded-md bg-inherit p-8">
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    <li v-for="(extra, extraIdx) in extrasArray" class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-500"
                                >
                                    <ExtrasIcon />
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p
                                    class="truncate text-sm font-medium text-gray-900"
                                >
                                    Extra period
                                </p>
                                <p class="truncate text-sm text-gray-500">
                                    {{ extra.date }}
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

                    <li v-for="(holds, holdIdx) in holdsArray" class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-500"
                                >
                                    <HoldsIcon />
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p
                                    class="truncate text-sm font-medium text-gray-900"
                                >
                                    Hold period
                                </p>
                                <p class="truncate text-sm text-gray-500">
                                    {{ holds.date }}
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
                </ul>
            </div>
            <div class="mt-6 grid grid-cols-2 grid-rows-1 space-x-2">
                <Datepicker
                    v-if="toggleDatePickerHolds"
                    v-model="holdsData"
                    range
                />
                <button
                    type="button"
                    @click="showDatePickerOnClickHolds"
                    class="appearance-0 flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Add holds
                </button>
                <Datepicker
                    v-model="extrasData"
                    v-if="toggleDatePickerExtras"
                    range
                />
                <button
                    type="button"
                    @click="showDatePickerOnClickExtras"
                    class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Add extra
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import ExtrasIcon from "../icons/ExtrasIcon.vue";
import HoldsIcon from "../icons/HoldsIcon.vue";

const toggleDatePickerHolds = ref(false);
const toggleDatePickerExtras = ref(false);

const showDatePickerOnClickHolds = () => {
    toggleDatePickerHolds.value = !toggleDatePickerHolds.value;
};

const showDatePickerOnClickExtras = () => {
    toggleDatePickerExtras.value = !toggleDatePickerExtras.value;
};

const holdsData = ref([]);
const extrasData = ref([]);

const extrasArray = ref([
    {
        date: "2022.11.20.-2022.11.20.",
    },
    {
        date: "2022.11.20.-2022.11.20.",
    },
    {
        date: "2022.11.20.-2022.11.20.",
    },
]);

const holdsArray = ref([
    {
        date: "2022.11.20.-2022.11.20.",
    },
    {
        date: "2022.11.20.-2022.11.20.",
    },
    {
        date: "2022.11.20.-2022.11.20.",
    },
]);

const removeExtra = (extraIdx) => {
    extrasArray.value.splice(extraIdx, 1);
};

const removeHold = (holdIdx) => {
    holdsArray.value.splice(holdIdx, 1);
};
</script>
