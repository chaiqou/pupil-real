<template>
    <div class="flex-shrink-0">
        <div>
            <div class="relative mt-1">
                <button
                    type="button"
                    class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                >
                    <span class="block truncate">2 Lunches Selected</span>
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
                        <span class="block truncate font-semibold"
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
                        <span class="block truncate font-semibold"
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
                        <span class="block truncate font-normal"
                            >Not selected</span
                        >
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import LunchesArrowIcon from "@/components/icons/LunchesArrowIcon.vue";
import CheckIcon from "@/components/icons/checkIcon.vue";
</script>
