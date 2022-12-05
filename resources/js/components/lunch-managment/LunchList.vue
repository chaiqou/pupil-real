<template>
    <div
        class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12"
    >
        <ul
            role="list"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
        >
            <li
                v-for="lunch in lunches"
                class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow"
            >
                <div
                    class="flex w-full items-center justify-between space-x-6 p-6"
                >
                    <div class="flex-1 truncate">
                        <div class="flex items-center space-x-3">
                            <h3
                                class="truncate text-sm font-medium text-gray-900"
                            >
                                {{ lunch.title }}
                            </h3>
                        </div>
                        <p class="mt-1 truncate text-sm text-gray-500">
                            {{ lunch.description }}
                        </p>
                    </div>
                </div>
                <div class="-mt-px flex divide-x divide-gray-200">
                    <div class="flex w-0 flex-1">
                        <a
                            class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
                        >
                            <span class="ml-3">{{
                                lunch.active_range[0]
                            }}</span>
                        </a>
                    </div>
                    <div class="-ml-px flex w-0 flex-1">
                        <a
                            href="tel:+1-202-555-0170"
                            class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
                        >
                            <span class="ml-3">94 available days left</span>
                        </a>
                    </div>
                </div>
                <div>
                    <div class="-mt-px flex divide-x divide-gray-200">
                        <div class="flex w-0 flex-1">
                            <a
                                class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
                            >
                                Manage
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            <!-- More people... -->
        </ul>
    </div>
</template>

<script setup>
import { onMounted } from "vue";

onMounted(() => {
    axios.get("/api/school/lunch").then((response) => {
        lunches.push(...response.data.data);
    });
});

const lunches = [];
</script>
