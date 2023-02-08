<template>
    <div
        class="fixed flex min-h-screen w-screen flex-col z-50 justify-center items-center bg-black/50"
    >
        <div
            class="absolute md:right-1/3 xl:right-[45%] bg-white px-6 py-10 shadow-2xl max-w-lg rounded-lg w-full"
        >
            <template
                class="flex flex-wrap justify-between border-b border-gray-200"
            >
                <AnimatedPlaceholder
                    class="text-gray-700 mb-2 font-semibold w-full"
                />
            </template>

            <div v-for="lunch in store.suitableLunch">
                <div class="border-b border-gray-200">
                    <h2 class="text-gray-700 mt-2 font-semibold">
                        <AnimatedPlaceholder
                            class="text-gray-700 mb-2 font-semibold w-full"
                        />
                    </h2>
                    <div
                        class="flex flex-wrap space-y-4 w-full justify-between my-4 sm:space-y-0 sm:flex-nowrap sm:space-x-12"
                    >
                        <AnimatedPlaceholder
                            class="text-gray-700 mb-2 font-semibold w-full"
                        />
                        <AnimatedPlaceholder
                            class="text-gray-700 mb-2 font-semibold w-full"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AnimatedPlaceholder from "../../ui/AnimatedPlaceholder.vue";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";

const store = useMenuManagementStore();
</script>
