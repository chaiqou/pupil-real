<template>
    <div
        class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12"
    >
        <div class="rounded-md bg-inherit p-8">
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-500"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        class="h-5 w-5 text-white"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p
                                    class="truncate text-sm font-medium text-gray-900"
                                >
                                    Extra period
                                </p>
                                <p class="truncate text-sm text-gray-500">
                                    2022.11.12.-2022.11.15.
                                </p>
                            </div>
                            <div>
                                <button
                                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </li>

                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-500"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        class="h-5 w-5 text-white"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p
                                    class="truncate text-sm font-medium text-gray-900"
                                >
                                    Hold period
                                </p>
                                <p class="truncate text-sm text-gray-500">
                                    2022.11.20.-2022.11.20.
                                </p>
                            </div>
                            <div>
                                <button
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
</script>
