<template>
    <div
        class="fixed flex min-h-screen min-w-[100vw] md:min-w-[90vw] flex-col z-50 justify-center overflow-hidden bg-black/50 py-6 sm:py-12"
    >
        <div
            class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10 w-full"
        >
            <template
                class="flex flex-wrap justify-between border-b border-gray-200"
            >
                <h1 class="text-gray-700 mb-2 font-semibold">
                    {{ format(store.selected_day, "yyyy MMMM dd") }}
                </h1>
                <h2 class="text-gray-700 mb-2 font-semibold">Lunch Name</h2>
            </template>

            <div class="mx-auto max-w-md w-full">
                <div class="flex items-start space-x-4">
                    <Form class="min-w-0 flex-1" ref="target">
                        <div
                            class="flex w-full justify-between space-x-12 my-4"
                        >
                            <button
                                type="button"
                                class="items-center p-4 w-full rounded-md border border-gray-300 bg-white text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Fixed
                            </button>
                            <button
                                type="button"
                                class="items-center p-4 w-full rounded-md border border-gray-300 bg-white text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Choices
                            </button>
                        </div>
                        <div
                            class="border-y p-2 border-gray-200 focus-within:border-indigo-600"
                        >
                            <Field
                                name="Comment"
                                as="textarea"
                                class="block w-full resize-none border-transparent p-0 pb-2 focus:border-indigo-600 focus:rounded-lg focus:border-none focus:ring-0 sm:text-sm"
                                placeholder="Menu description..."
                            ></Field>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { onClickOutside } from "@vueuse/core";
import { useTooltipStore } from "@/stores/useTooltipStore";
import { Field, Form } from "vee-validate";
import { format } from "date-fns";

const props = defineProps({
    selectedDay: {
        type: [Date, String],
        default: "",
        required: false,
    },
});

const store = useTooltipStore();

// Close clickoutside
const target = ref(null);
onClickOutside(target, () => (store.toggle_tooltip = false));

// close select component

const toggleSelect = () => {
    store.toggle_select = !store.toggle_select;
};
</script>
