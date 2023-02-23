<template>
  <RenderDifferentCards />
  <div class="w-full">
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
              getLunchesDays(day)
                ? 'bg-purple-700 text-white hover:bg-purple-600'
                : '',
              getMenusDays(day) ? ' !bg-white bg-gray-50 !text-gray-900' : '',
              'py-1.5 hover:bg-gray-100',
            ]"
          >
            <time
              :datetime="format(day, 'yyyy-MM-dd')"
              class="mx-auto flex h-6 w-6 items-center justify-center rounded-md p-4"
            >
              <div class="flex-col">
                <h2>
                  {{ format(day, "d") }}
                </h2>
                <div
                  v-if="getMenusDays(day)"
                  class="mx-auto h-0.5 w-4 rounded-full bg-indigo-600"
                ></div>
              </div>
            </time>
          </button>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import useFindMonthDays from "@/composables/calendar/useFindMonthDays";
import useFindMonthByIndex from "@/composables/calendar/useFindMonthByIndex";
import { format, parseISO } from "date-fns";
import RenderDifferentCards from "@/components/Merchant/Menu-management/RenderDifferentCards.vue";
import { onBeforeMount, ref } from "vue";

const { monthsDays } = useFindMonthDays(11);
const { getMonthByIndex } = useFindMonthByIndex();

const onClickCalendar = () => {};

const props = defineProps({
  studentId: {
    type: Number,
    required: true,
  },
});

const lunches = ref([]);
const menus = ref([]);

onBeforeMount(async () => {
  try {
    const response = await axios.get(
      `/api/parent/menu-retrieve/${props.studentId}`,
    );
    lunches.value = response.data.lunches;
    menus.value = response.data.menus;
  } catch (error) {
    console.log(error);
  }
});

// Create function which detects days on which user have a lunch

const getLunchesDays = (day) => {
  if (!lunches.value) {
    return [];
  }

  const dates = [];
  for (let i = 0; i < lunches.value.length; i++) {
    const claimsObject = JSON.parse(lunches.value[i].claims);
    const objectKeys = Object.keys(claimsObject);
    dates.push(...objectKeys);
  }

  let determineIfLunchDayMatch = dates.some(
    (date) => format(parseISO(date), "yyyy-MM-dd") == format(day, "yyyy-MM-dd"),
  );

  return determineIfLunchDayMatch;
};

// Create function which detects days on which we have a choices for lunches

const getMenusDays = (day) => {
  if (!menus.value) {
    return [];
  }

  let menuArray = [];
  for (let obj of Object.values(menus.value)) {
    let menusObj = JSON.parse(obj.menus);
    let menusKeys = Object.keys(menusObj);
    menuArray.push(...menusKeys);
  }

  let determineIfManuDayMatch = menuArray.some(
    (menuDay) =>
      format(parseISO(menuDay), "yyyy-MM-dd") == format(day, "yyyy-MM-dd"),
  );

  return determineIfManuDayMatch;
};
</script>
