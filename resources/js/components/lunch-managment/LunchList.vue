<template>
    <div
        class="relative flex px-4 flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12"
    >
        <ul
            role="list"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
        >
            <a
                class="relative block w-full rounded-lg border-4 border-dashed border-gray-300 p-14 text-center hover:border-gray-400 focus:outline-none"
                href="http://127.0.0.1:8000/school/add-lunch"
                v-if="store.lunches.length < 9"
                :class="[store.lunches.length === 0 ? 'h-68' : 'h-48']"
            >
                <span class="mt-2 block text-sm font-medium text-gray-900"
                    >Add Lunch</span
                >
            </a>
            <li
                v-for="lunch in store.lunches"
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
                                `${lunch.active_range.at(0)} -
                                ${lunch.active_range.at(-1)}`
                            }}</span>
                        </a>
                    </div>
                    <div class="-ml-px flex w-0 flex-1">
                        <a
                            class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
                        >
                            <span class="ml-3"
                                >{{
                                    intervalToDuration({
                                        start: new Date(
                                            lunch.active_range.at(0)
                                        ),
                                        end: new Date(
                                            lunch.active_range.at(-1)
                                        ),
                                    }).days
                                }}
                                available days left</span
                            >
                        </a>
                    </div>
                </div>
                <div>
                    <div class="-mt-px flex divide-x divide-gray-200">
                        <div class="flex w-0 flex-1">
                            <button
                                class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
                                @click="currentLunchEditId(lunch.id)"
                            >
                                Manage
                            </button>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { intervalToDuration } from "date-fns";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

const store = useLunchFormStore();

onMounted(() => {
    axios.get("/api/school/lunch").then((response) => {
        store.lunches.push(...response.data.data);
    });
});

const currentLunchEditId = (id) => {
    localStorage.setItem("lunchId", id);
    window.location.href = "/school/lunch-management/" + id + "/edit";
};
</script>
