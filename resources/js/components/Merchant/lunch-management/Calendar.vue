<template>
  <div>
    <div
      class="bg-inherit md:h-[70vh] md:w-[30vw] xl:h-[50vh] xl:w-[40vw] 2xl:h-[100vh] 2xl:w-[50vw]"
      :class="classes"
    >
      <div
        class="mx-auto grid max-w-3xl grid-cols-1 gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-1 sm:px-6 xl:max-w-none xl:grid-cols-2 xl:px-8 2xl:grid-cols-3"
      >
        <section
          v-for="month in monthsDays"
          :key="month.name"
          class="text-center"
        >
          <h2 class="font-semibold text-gray-900">
            {{ month.name }} {{ month.year }}
          </h2>
          <div class="mt-6 grid grid-cols-7 text-xs leading-6 text-gray-500">
            <div>M</div>
            <div>T</div>
            <div>W</div>
            <div>T</div>
            <div>F</div>
            <div>S</div>
            <div>S</div>
          </div>
          <div
            class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200"
          >
            <button
              v-for="(day, dayIdx) in month.days"
              :key="day.date"
              type="button"
              :class="[
                month.name !== getMonthByIndex(day.getMonth()) &&
                month.name === monthFullNames[day.getMonth()]
                  ? 'bg-white text-gray-900'
                  : 'bg-gray-50 text-gray-400',
                dayIdx === 0 && 'rounded-tl-lg',
                dayIdx === 6 && 'rounded-tr-lg',
                dayIdx === month.days.length - 7 && 'rounded-bl-lg',
                dayIdx === month.days.length - 1 && 'rounded-br-lg',
                'py-1.5 hover:bg-gray-100 focus:z-10',
              ]"
            >
              <time
                :datetime="format(day, 'yyyy-MM-dd')"
                :class="[
                  isToday(day) && [
                    getMonthByIndex(day.getMonth()) &&
                    month.name === monthFullNames[day.getMonth()]
                      ? 'aspect-auto border-b-2 border-indigo-600  bg-indigo-600 font-semibold text-white'
                      : 'aspect-auto border-b-2   border-indigo-600 bg-indigo-400 text-gray-50',
                  ],
                  'mx-auto flex h-6 w-6 items-center justify-center rounded-md p-4',
                ]"
              >
                <div class="flex-col">
                  <h1>
                    {{ format(day, "d") }}
                  </h1>
                  <div
                    v-if="ifDaysMatch(day) && isToday(day)"
                    class="mx-auto h-0.5 w-4 rounded-full bg-white"
                  ></div>
                  <div
                    v-if="ifDaysMatch(day) && !isToday(day)"
                    class="mx-auto h-0.5 w-4 rounded-full bg-indigo-600"
                  ></div>
                </div>
              </time>
            </button>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import { format, isToday } from "date-fns";
import { onBeforeMount } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import useFindMonthDays from "@/composables/calendar/useFindMonthDays";
import useFindMonthByIndex from "@/composables/calendar/useFindMonthByIndex";
import useCheckIfDaysMatches from "@/composables/calendar/useCheckIfDaysMatches";

const { ifDaysMatch } = useCheckIfDaysMatches();
const { getMonthByIndex, monthFullNames } = useFindMonthByIndex();
const { monthsDays } = useFindMonthDays(11);

const store = useLunchFormStore();

const props = defineProps({
  months: {
    type: Number,
    required: true,
  },
  classes: {
    type: Array,
    required: false,
    default: "",
  },
});

onBeforeMount(() => {
  const targetPath = `/school/lunch-management/${localStorage.getItem(
    "lunchId",
  )}/edit`;
  const currentPath = window.location.pathname;

  if (currentPath == targetPath) {
    axios.get("/api/school/lunch").then((response) => {
      response.data.data.map((data) => {
        if (localStorage.getItem("lunchId") == data.id) {
          store.marked_days.push(...data.available_days);
        }
      });
    });
  }
});
</script>
