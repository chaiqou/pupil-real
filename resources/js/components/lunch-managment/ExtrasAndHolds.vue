<template>
    <div
        class="flex max-h-screen flex-col justify-center overflow-hidden bg-inherit"
    >
        <div class="rounded-md bg-inherit p-8">
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    <li v-for="(extra, extraIdx) in store.extras" class="py-4">
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
                    <li v-for="(hold, holdIdx) in store.holds" class="py-4">
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
                                    {{ hold }}
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
        </div>
        <div class="mt-6 grid grid-cols-2 grid-rows-1 space-x-2">
            <Datepicker @update:modelValue="handleExtrasDate" range>
                <template #trigger>
                    <p
                        class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Add extra
                    </p>
                </template>
            </Datepicker>
            <Datepicker @update:modelValue="handleHoldsDate" range>
                <template #trigger>
                    <p
                        class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Add holds
                    </p>
                </template>
            </Datepicker>
        </div>
    </div>
</template>

<script setup>
import { format } from "date-fns";
import ExtrasIcon from "../icons/ExtrasIcon.vue";
import HoldsIcon from "../icons/HoldsIcon.vue";
import { useLunchFormStore } from "../../stores/useLunchFormStore";

const store = useLunchFormStore();

const props = defineProps({
    extras: {
        type: String,
        required: true,
    },
    holds: {
        type: String,
        required: true,
    },
});

// Extras

const removeExtra = (extraIdx) => {
    store.extras.splice(extraIdx, 1);
};

const handleExtrasDate = (modelData) => {
    store.extras.push(modelData);
    console.log(store.extras);
};

// Holds

const removeHold = (holdIdx) => {
    store.holds.splice(holdIdx, 1);
};

const handleHoldsDate = (modelData) => {
    store.holds.push(modelData);
    console.log(store.holds);
};
</script>
