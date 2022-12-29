<template>
    <div
        class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12"
    >
        <img
            src="/img/beams.jpg"
            alt=""
            class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2"
            width="1308"
        />
        <div
            class="absolute inset-0 bg-[url(/img/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"
        ></div>
        <div
            class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10 w-full"
        >
            <div class="mx-auto max-w-md w-full">
                <div class="flex items-start space-x-4">
                    <div class="min-w-0 flex-1">
                        <form action="#">
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
                                                aria-haspopup="listbox"
                                                aria-expanded="true"
                                                aria-labelledby="listbox-label"
                                            >
                                                <span class="block truncate"
                                                    >2 Lunches Selected</span
                                                >
                                                <span
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                                                >
                                                    <!-- Heroicon name: mini/chevron-up-down -->
                                                    <svg
                                                        class="h-5 w-5 text-gray-400"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </span>
                                            </button>
                                            <ul
                                                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                                tabindex="-1"
                                                role="listbox"
                                                aria-labelledby="listbox-label"
                                                aria-activedescendant="listbox-option-3"
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
                                                        <!-- Heroicon name: mini/check -->
                                                        <svg
                                                            class="h-5 w-5"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20"
                                                            fill="currentColor"
                                                            aria-hidden="true"
                                                        >
                                                            <path
                                                                fill-rule="evenodd"
                                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                                clip-rule="evenodd"
                                                            />
                                                        </svg>
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
                                                        <!-- Heroicon name: mini/check -->
                                                        <svg
                                                            class="h-5 w-5"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20"
                                                            fill="currentColor"
                                                            aria-hidden="true"
                                                        >
                                                            <path
                                                                fill-rule="evenodd"
                                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                                clip-rule="evenodd"
                                                            />
                                                        </svg>
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
const props = defineProps({
    selectedDay: {
        type: [Date, String],
        default: "",
        required: true,
    },
});
</script>
