<template>
    <div
        class="fixed flex min-h-screen min-w-[90vw] flex-col z-50 justify-center overflow-hidden bg-black/50 py-6 sm:py-12"
    >
        <div
            class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10 w-full"
        >
            <div class="mx-auto max-w-md w-full">
                <div class="flex items-start space-x-4">
                    <div class="min-w-0 flex-1">
                        <form ref="target" action="#">
                            <div
                                class="border-b border-gray-200 focus-within:border-indigo-600"
                            >
                                <label for="comment" class="sr-only"
                                    >Add your comment</label
                                >
                                <textarea
                                    rows="3"
                                    name="comment"
                                    id="comment"
                                    class="block w-full resize-none border-0 border-b border-transparent p-0 pb-2 focus:border-indigo-600 focus:ring-0 sm:text-sm"
                                    placeholder="Menu description..."
                                ></textarea>
                            </div>
                            <div class="flex justify-between pt-2">
                                <div class="flex items-center space-x-5"></div>
                                <div class="flex-shrink-0">
                                    <div>
                                        <div class="relative mt-1">
                                            <button
                                                type="button"
                                                class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                            >
                                                <span class="block truncate"
                                                    >2 Lunches Selected</span
                                                >
                                                <span
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                                                >
                                                    <LunchesArrowIcon />
                                                </span>
                                            </button>
                                            <ul
                                                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                            >
                                                <li
                                                    class="relative cursor-default select-none py-2 pl-8 pr-4 text-gray-900"
                                                    id="listbox-option-0"
                                                    role="option"
                                                >
                                                    <span
                                                        class="block truncate font-semibold"
                                                        >Test lunch</span
                                                    >
                                                    <span
                                                        class="absolute inset-y-0 left-0 flex items-center pl-1.5 text-indigo-600"
                                                    >
                                                        <CheckIcon />
                                                    </span>
                                                </li>
                                                <li
                                                    class="relative cursor-default select-none py-2 pl-8 pr-4 text-gray-900"
                                                    id="listbox-option-0"
                                                    role="option"
                                                >
                                                    <span
                                                        class="block truncate font-semibold"
                                                        >Lunch title</span
                                                    >
                                                    <span
                                                        class="absolute inset-y-0 left-0 flex items-center pl-1.5 text-indigo-600"
                                                    >
                                                        <CheckIcon />
                                                    </span>
                                                </li>
                                                <li
                                                    class="relative cursor-default select-none py-2 pl-8 pr-4 text-gray-900"
                                                    id="listbox-option-0"
                                                    role="option"
                                                >
                                                    <span
                                                        class="block truncate font-normal"
                                                        >Not selected</span
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <button
                            type="button"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Add another
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import LunchesArrowIcon from "@/components/icons/LunchesArrowIcon.vue";
import CheckIcon from "@/components/icons/checkIcon.vue";
import { ref } from "vue";
import { onClickOutside } from "@vueuse/core";
import { useGlobalStore } from "@/components/stores/useGlobalStore";

const target = ref(null);
const globalStore = useGlobalStore();

onClickOutside(target, (event) => (globalStore.toggleTooltip = false));

const props = defineProps({
    selectedDay: {
        type: [Date, String],
        default: "",
        required: false,
    },
});
</script>
