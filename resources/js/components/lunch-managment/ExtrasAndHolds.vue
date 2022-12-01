<template>
    <div
        class="flex max-h-screen flex-col justify-center overflow-hidden bg-inherit"
    >
        <label
            class="text-md flex mt-2 font-bold text-gray-600 whitespace-normal"
            >Extras and Holds
        </label>
        <div class="rounded-md bg-inherit">
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
                                    {{ `${extra[0]} - ${extra[1]}` }}
                                </p>
                            </div>
                            <div>
                                <button
                                    type="button"
                                    @click="removeExtra(extraIdx, extra)"
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
                                    {{ `${hold[0]} - ${hold[1]}` }}
                                </p>
                            </div>
                            <div>
                                <button
                                    type="button"
                                    @click="removeHold(holdIdx, hold)"
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
            <Datepicker
                closeOnScroll
                @update:modelValue="handleExtrasDate"
                :disabledDates="disabledExtrasDays"
                :maxDate="addYears(new Date(), 1)"
                :partialRange="false"
                :minDate="new Date()"
                :enableTimePicker="false"
                range
            >
                <template #trigger>
                    <p
                        class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Add extra
                    </p>
                </template>
            </Datepicker>
            <Datepicker
                closeOnScroll
                :minDate="new Date()"
                :disabledDates="disableHoldsDays"
                :partialRange="false"
                :maxDate="addYears(new Date(), 1)"
                @update:modelValue="handleHoldsDate"
                :enableTimePicker="false"
                range
            >
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
import ExtrasIcon from "../icons/ExtrasIcon.vue";
import HoldsIcon from "../icons/HoldsIcon.vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { computed } from "vue";
import { addYears, format } from "date-fns";

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

const removeExtra = (extraIdx, extra) => {
    store.extras.splice(extraIdx, 1);

    store.removeDaysFromMarkedDays(extra);

    store.disabledDaysForHolds = [];
};

const handleExtrasDate = (modelData) => {
    store.extras.push([
        format(modelData[0], "yyyy-MM-dd"),
        format(modelData[1], "yyyy-MM-dd"),
    ]);

    store.disabledDaysDate(modelData[0], modelData[1]).forEach((data) => {
        store.disabledDaysForHolds.push(data);
    });

    store.addExtrasToMarkedDays;
};

const disabledExtrasDays = computed(() => {
    return [...store.disabledDaysForExtras, ...store.disabledDaysForHolds];
});

// Holds

const removeHold = (holdIdx, hold) => {
    store.holds.splice(holdIdx, 1);

    store.addDaysToMarkedDays(hold);

    store.disabledDaysForExtras = [];
};

const handleHoldsDate = (modelData) => {
    store.holds.push([
        format(modelData[0], "yyyy-MM-dd"),
        format(modelData[1], "yyyy-MM-dd"),
    ]);

    store.disabledDaysDate(modelData[0], modelData[1]).forEach((date) => {
        store.disabledDaysForExtras.push(date);
    });

    store.removeHoldsFromMarkedDays;
};

const disableHoldsDays = computed(() => {
    return [...store.disabledDaysForHolds, ...store.disabledDaysForExtras];
});
</script>
