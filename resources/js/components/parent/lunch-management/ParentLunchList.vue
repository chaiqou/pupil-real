<template>
  <div
    class="relative flex flex-col justify-center overflow-hidden bg-gray-50 px-4 py-6 sm:py-12"
  >
    <ul
      role="list"
      class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
    >
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
                {{ $t("message.days_left") }}</span
              >
            </a>
          </div>
        </div>
        <div>
          <div class="-mt-px flex divide-x divide-gray-200">
            <div class="flex w-0 flex-1">
              <button
                class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-b-lg border border-transparent py-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-indigo-700 hover:text-white focus:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                @click="currentLunchEditId(lunch.id)"
              >
                {{ $t("message.details") }}
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="ml-2 -mr-1 h-5 w-5"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </li>
    </ul>
    <div v-if="store.lunches.length < 1">
      <div
        class="mt-48 flex min-h-full justify-center py-12 px-4 sm:px-6 lg:px-8"
      >
        <div class="w-full max-w-md space-y-8">
          <div>
            <img
              class="mx-auto h-16 w-auto"
              src="@/components/images/pupilpay-black-color.png"
              alt="PupilPay"
            />
            <h2
              class="mt-6 text-center text-2xl font-bold tracking-tight text-gray-900"
            >
              {{ $t("message.no_lunch_is_currently_available_to_order") }}
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { differenceInCalendarDays, format, parseISO } from "date-fns";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

const store = useLunchFormStore();

const props = defineProps({
  studentId: {
    type: [Number, String],
  },
});

onMounted(() => {
  axios.get("/api/school/lunch").then((response) => {
    store.lunches.push(...response.data.lunches.data);
  });
});

const currentLunchEditId = (lunchId) => {
  localStorage.setItem("lunchId", lunchId);
  window.location.href = `/parent/lunch-details/${props.studentId}`;
};
</script>
