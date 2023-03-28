<template>
  <RenderDifferentCards />
  <div class="w-full">
    <div
      class="grid gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-1 sm:px-6 xl:grid-cols-2 xl:px-8 2xl:grid-cols-3"
    >
      <section v-for="month in monthsDays" :key="month.name" class="text-right">
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
        <div class="flex">
          <div class="mt-4 grow-0 basis-1/12">
            <div v-for="(week, weekIdx) in computedWeeks" :key="weekIdx">
              <div class="pb-2" v-if="month.name == week.month">
                <button @click="sendCorrectWeekNumber(week.days)">
                  <DownloadIcon
                    class="cursor-pointer rounded-lg bg-purple-700 p-2 hover:bg-purple-600"
                  />
                </button>
              </div>
            </div>
          </div>
          <div
            class="mt-2 ml-4 grid basis-11/12 grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200"
          >
            <button
              v-for="(day, dayIdx) in month.days"
              @click="onClickCalendar(day)"
              :key="dayIdx"
              :class="[
                month.name !== getMonthByIndex(day.getMonth())
                  ? 'bg-white text-gray-900'
                  : 'bg-gray-50 text-gray-400',
                dayIdx === 0 && 'rounded-tl-lg',
                dayIdx === 6 && 'rounded-tr-lg',
                dayIdx === month.days.length - 7 && 'rounded-bl-lg',
                dayIdx === month.days.length - 1 && 'rounded-br-lg',
                'py-1.5 hover:bg-gray-100',
              ]"
            >
              <MenuCalendarDays :day="day" />
            </button>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { format, parseISO } from "date-fns";
import { ref, onBeforeMount, computed } from "vue";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import useFindMonthDays from "@/composables/calendar/useFindMonthDays";
import useFindMonthByIndex from "@/composables/calendar/useFindMonthByIndex";
import MenuCalendarDays from "@/components/Merchant/Menu-management/MenuCalendarDays.vue";
import RenderDifferentCards from "@/components/Merchant/Menu-management/RenderDifferentCards.vue";
import DownloadIcon from "@/components/icons/DownloadIcon.vue";

const store = useLunchFormStore();
const menuManagementStore = useMenuManagementStore();
const { monthsDays } = useFindMonthDays(11);
const { getMonthByIndex } = useFindMonthByIndex();

const lunches = ref([]);
const weeks = ref([]);

const onClickCalendar = (day) => {
  const formatedDay = format(day, "yyyy-MM-dd");

  if (store.marked_days.includes(formatedDay)) {
    menuManagementStore.toggleMenuManagementCard =
      !menuManagementStore.toggleMenuManagementCard;
    menuManagementStore.selectedDay = day;
  }
};

const computedWeeks = computed(() => {
  const computedWeekdays = [];

  weeks.value.forEach((week) => {
    // Loop over weeks array and for each weeks create new array in which we have week index , month name , and days array

    for (const key in week) {
      // Find correct month name
      const monthName = getMonthByIndex(
        parseISO(week[key][0].date).getMonth() + 1,
      );

      computedWeekdays.push({ month: monthName, days: week[key] });
    }
  });

  return computedWeekdays;
});

const sendCorrectWeekNumber = async function (weekdays) {
  // eslint-disable-next-line no-unused-vars
  const response = await axios.post("/api/merchant/export-menu", weekdays);
};

// Fetch all existing lunch for merchant and mark it on calendar

onBeforeMount(() => {
  axios.get("/api/school/lunch").then((response) => {
    lunches.value = response.data.lunches.data;
    weeks.value = response.data.weeks;
    response.data.lunches.data.map((data) => {
      store.marked_days.push(...data.available_days);
    });
  });
});
</script>
