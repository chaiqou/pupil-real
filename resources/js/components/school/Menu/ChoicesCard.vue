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
                    {{ props.name }}
                </h1>
            </template>
            <div
                v-for="claimable in store.parsedClaimables(props.claimables)"
                :key="claimable"
            >
                <h2 class="text-gray-700 m-2 font-semibold">
                    {{ claimable }}
                </h2>
                <button
                    class="flex w-full justify-center rounded-md mt-4 mb-4 bg-indigo-700 px-4 py-2 text-base font-medium text-white"
                    @click="onClickAddInput"
                >
                    Add Input
                </button>
                <template v-for="(input, index) in inputs" :key="index">
                    <BaseInput />
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { onClickOutside } from "@vueuse/core";
import { ref } from "vue";
import BaseInput from "@/components/form-components/BaseInput.vue";

const props = defineProps({
    claimables: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
});

const store = useMenuManagementStore();

const inputs = ref([]);

const onClickAddInput = () => {
    inputs.value.push({});
};

// Close on click outside

const target = ref(null);
onClickOutside(target, () => {
    store.toggleChoicesCard = false;
});
</script>
