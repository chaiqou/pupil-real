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
              <div class="pb-1" v-if="month.name === week.month">
                <div v-if="week.blank" class="invisible p-2">
                  <DownloadIcon
                    class="cursor-pointer rounded-lg bg-purple-700 p-2 hover:bg-purple-600"
                  />
                </div>
                <button
                  v-if="week.blank === false"
                  @click="handleLunchesExport(week.days)"
                  :disabled="week.days.length < 1"
                >
                  <DownloadIcon
                    class="cursor-pointer rounded-lg bg-purple-700 p-2 hover:bg-purple-600"
                  />
                </button>
              </div>
            </div>
          </div>
          <div
            class="ml-4 mt-2 grid basis-11/12 grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200"
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

      let blankState = week[key][0].blank;
      if (blankState == null) {
        blankState = false;
      }

      computedWeekdays.push({
        month: monthName,
        days: week[key],
        blank: blankState,
      });
    }
  });

  return computedWeekdays;
});

const handleLunchesExport = async (dayAndWeek) => {
  try {
    const { data } = await axios.get("/api/merchant/request-export-menu", {
      params: {
        dayAndWeek: JSON.stringify(dayAndWeek),
      },
      responseType: "blob",
    });

    const url = URL.createObjectURL(new Blob([data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", "weekly_orders.xlsx");

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } catch (error) {
    console.error("An error occurred while exporting lunches:", error);
  }
};

// Fetch all existing lunch for merchant and mark it on calendar

const fetchData = async () => {
  try {
    const response = await axios.get("/api/school/download-excel-lunches");
    const lunches = response.data.lunches.data;
    let weeks = response.data.weeks;

    let first = response.data.first_week;
    let last = parseInt(
      Object.keys(response.data.weeks.slice(-1)[0]).slice(-1),
    );
    let unsortedArr = weeks;
    let newArr = [];
    //Pop the parent elements, combine childs
    for (var i = 0; i < unsortedArr.length; i++) {
      let parent = unsortedArr[i];
      for (var j = 0; j < Object.keys(parent).length; j++) {
        let child = parent[Object.keys(parent)[j]];
        newArr.push({ [Object.keys(parent)[j]]: child });
      }
    }
    for (let i = first; i <= last; i++) {
      if (!newArr.some((el) => Object.keys(el).includes(i.toString()))) {
        let firstDate = new Date(new Date().getFullYear(), 0, 1);
        firstDate.setDate(firstDate.getDate() + i * 7 - firstDate.getDay());
        let lastDate = new Date(new Date().getFullYear(), 0, 1);
        lastDate.setDate(lastDate.getDate() + i * 7 - lastDate.getDay() + 6);
        //Array of dates between firstDate and lastDate
        let dateArray = [];
        let currentDate = firstDate;
        while (currentDate <= lastDate) {
          dateArray.push(new Date(currentDate));
          currentDate.setDate(currentDate.getDate() + 1);
        }
        //Create an array of objects with date and week number
        let dateAndWeekArray = [];
        dateArray.forEach((date) => {
          dateAndWeekArray.push({
            date: format(date, "yyyy-MM-dd"),
            week: i,
            blank: true,
          });
        });
        //Push the new object to the newArr
        newArr.push({ [i]: dateAndWeekArray });
      }
    }
    //sort weeks.value by week number
    newArr.sort((a, b) => {
      return Object.keys(a)[0] - Object.keys(b)[0];
    });
    weeks = newArr;

    response.data.lunches.map((data) => {
      store.marked_days.push(...data.available_days);
    });

    return { lunches, weeks };
  } catch (error) {
    console.log("We don't have a lunches for this merchant account");
  }
};

onBeforeMount(async () => {
  const data = await fetchData();
  if (data) {
    lunches.value = data.lunches;
    weeks.value = data.weeks;
  }
});
</script>
