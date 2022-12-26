<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <div
                                class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block"
                            >
                                <button
                                    type="button"
                                    class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    @click="open = false"
                                >
                                    <span class="sr-only">Close</span>
                                    <XMarkIcon
                                        class="h-6 w-6"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <ExclamationTriangleIcon
                                        class="h-6 w-6 text-red-600"
                                        aria-hidden="true"
                                    />
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                                >
                                    <DialogTitle
                                        as="h3"
                                        class="text-lg font-medium leading-6 text-gray-900"
                                        >Confirm lunch update</DialogTitle
                                    >
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Are you sure you want to update this
                                            lunch menu?
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"
                            >
                                <button
                                    type="button"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                    @click="saveWithoutShifting"
                                >
                                    Save without shifting
                                </button>
                                <button
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                    @click="saveWithShifting"
                                >
                                    Save with shifting
                                </button>
                                <button
                                    type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm"
                                    @click="open = false"
                                >
                                    Cancel
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from "vue";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationTriangleIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

// Data

const open = ref(true);

// Composables

const store = useLunchFormStore();

// Save data with changes

const saveWithShifting = () => {
    axios
        .put("/api/school/lunch/" + localStorage.getItem("lunchId"), {
            title: store.title,
            description: store.description,
            period_length: store.period_length,
            weekdays: store.weekdays,
            active_range: store.active_range,
            claimables: store.claimables,
            price_period: store.price_period,
            extras: store.extras,
            holds: store.holds,
            buffer_time: store.buffer_time,
        })
        .then((response) => {
            store.extras = [];
            store.holds = [];
            store.disabled_hold_days = [];
            store.disabled_extra_days = [];
            open.value = false;
            store.lunches = response.data.data;
            window.location.href = "/school/lunch-management/";
        });
};

// save data without change data

const saveWithoutShifting = () => {
    axios
        .get("/api/school/lunch/" + localStorage.getItem("lunchId"))
        .then((response) => {
            store.title = response.data.data.title;
            store.description = response.data.data.description;
            store.period_length = response.data.data.period_length;
            store.weekdays = response.data.data.weekdays;
            store.active_range = response.data.data.active_range;
            store.claimables = response.data.data.claimables;
            store.price_period = response.data.data.price_period;
            store.extras = response.data.data.extras;
            store.holds = response.data.data.holds;
            store.lunch_id = response.data.data.id;
        })
        .then(() => {
            store.extras = [];
            store.holds = [];
            store.disabled_hold_days = [];
            store.disabled_extra_days = [];
            open.value = false;
            window.location.href = "/school/lunch-management/";
        });
};
</script>
