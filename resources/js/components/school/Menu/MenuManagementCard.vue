<template>
    <div
        class="fixed flex min-h-screen w-screen flex-col z-50 justify-center items-center bg-black/50"
    >
        <div
            ref="target"
            class="absolute md:right-1/3 xl:right-[45%] bg-white px-6 py-10 shadow-2xl max-w-lg rounded-lg w-full"
        >
            <template
                class="flex flex-wrap justify-between border-b border-gray-200"
            >
                <h1 class="text-gray-700 mb-2 font-semibold">
                    {{ format(props.selectedDay, "yyyy MMMM dd") }}
                </h1>
            </template>

            <div v-for="lunch in store.suitableLunch">
                <SingleLunchCard :name="lunch.title" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { onClickOutside } from "@vueuse/core";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { format } from "date-fns";
import SingleLunchCard from "./SingleLunchCard.vue";

const props = defineProps({
    selectedDay: {
        type: [Date, String],
        default: "",
        required: false,
    },
});

const store = useMenuManagementStore();

// Close on click outside model

const target = ref(null);
onClickOutside(target, () => (store.toggleCard = false));
</script>
