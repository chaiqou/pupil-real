<template>
  <div
    class="relative flex px-4 flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12"
  >
    <ul
      role="list"
      class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
    >
      <a
        class="mt-4 rounded-lg border-4 border-dashed border-gray-300 p-14 text-center hover:border-gray-500 focus:outline-none"
        href="/school/add-lunch"
        v-if="store.lunches.length < 32"
        :class="[store.lunches.length === 0 ? 'h-68' : 'h-48']"
      >
        <span class="mt-6 block text-md font-medium text-gray-900"
          >Add Lunch</span
        >
      </a>
      <li
        v-for="lunch in store.lunches"
        :key="lunch"
        class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow"
      >
        <div class="flex w-full items-center justify-between space-x-6 p-6">
          <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
              <h3 class="truncate text-sm font-medium text-gray-900">
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
              <span class="whitespace-pre-line">{{
                `${format(parseISO(lunch.active_range.at(0)), "yyyy MMM dd")}
 ${format(parseISO(lunch.active_range.at(-1)), "yyyy MMM dd")}`
              }}</span>
            </a>
          </div>
          <div class="-ml-px flex w-0 flex-1">
            <a
              class="relative flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500"
            >
              <span class="ml-3"
                >{{
                  differenceInCalendarDays(
                    new Date(lunch.active_range.at(-1)),
                    new Date(),
                  )
                }}
                days left</span
              >
            </a>
          </div>
        </div>
        <div>
          <div class="-mt-px flex divide-x divide-gray-200">
            <div class="flex w-0 flex-1">
              <button
                class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-b-lg border border-transparent py-4 hover:text-white text-sm font-medium text-gray-700 focus:text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                @click="currentLunchEditId(lunch.id)"
              >
                Manage
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  strokeWidth="{1.5}"
                  stroke="currentColor"
                  class="ml-2 -mr-1 h-5 w-5"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"
                  />
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
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
import { differenceInCalendarDays, format, parseISO } from "date-fns";
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
