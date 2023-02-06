<template>
    <div
        class="fixed flex min-h-screen w-screen flex-col z-50 justify-center items-center bg-black/50"
    >
        <div
            class="bg-white px-6 py-10 shadow-2xl sm:max-w-lg rounded-lg w-full"
        >
            <template
                class="flex flex-wrap justify-between border-b border-gray-200"
            >
                <h1 class="text-gray-700 mb-2 font-semibold">
                    {{ format(store.selected_day, "yyyy MMMM dd") }}
                </h1>
                <h2 class="text-gray-700 mb-2 font-semibold">Lunch Name</h2>
            </template>

            <Form ref="target">
                <template
                    class="flex flex-wrap space-y-4 w-full justify-between sm:space-y-0 sm:flex-nowrap sm:space-x-12 my-4"
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
                </template>
                <template
                    class="border-y p-2 border-gray-200 focus-within:border-indigo-600"
                >
                    <Field
                        name="Comment"
                        as="textarea"
                        class="block w-full resize-none border-transparent p-0 pb-2 focus:border-indigo-600 focus:rounded-lg focus:border-none focus:ring-0 sm:text-sm"
                        placeholder="Menu description..."
                    ></Field>
                </template>
            </Form>
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

// Close on click outside model

const target = ref(null);
onClickOutside(target, () => (store.toggle_tooltip = false));
</script>
