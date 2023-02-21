<template>
  <div v-if="claimDays">
    <div
      class="bg-inherit md:h-[70vh] md:w-[30vw] xl:h-[50vh] xl:w-[40vw] 2xl:h-[100vh] 2xl:w-[50vw]"
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
              :key="day"
              type="button"
              :class="[
                markAllDisabledDays(day),
                markAllPossibleDays(day, month),
                markAllPossibleDaysForStripe(day, month),
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
                class="mx-auto flex h-6 w-6 items-center justify-center rounded-md p-4"
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
                    class="mx-auto h-0.5 w-4 rounded-full bg-white"
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
import { format, isToday, parseISO } from "date-fns";
import { computed } from "vue";
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
    default: 11,
  },
  stripeDays: {
    required: false,
  },
});

const markAllDisabledDays = (day) =>
  store.disabledDaysForLunchOrdering.map((highlight) =>
    format(highlight, "yyy-MM-dd") == format(day, "yyyy-MM-dd")
      ? "bg-indigo-400 hover:bg-indigo-500 !text-white"
      : "",
  );

const markAllPossibleDays = (day, month) =>
  claimDays.value.length > 0
    ? claimDays.value.map((claim) =>
        format(claim, "yyyy-MM-dd") == format(day, "yyyy-MM-dd") &&
        month.name !== getMonthByIndex(day.getMonth()) &&
        month.name === monthFullNames[day.getMonth()]
          ? "!bg-indigo-600 text-white hover:!bg-indigo-800"
          : "",
      )
    : "";

const markAllPossibleDaysForStripe = (day, month) => {
  if (dates.value) {
    return dates.value.length > 0
      ? dates.value.map((claim) =>
          format(claim, "yyyy-MM-dd") == format(day, "yyyy-MM-dd") &&
          month.name !== getMonthByIndex(day.getMonth()) &&
          month.name === monthFullNames[day.getMonth()]
            ? "!bg-indigo-600 text-white hover:!bg-indigo-800"
            : "",
        )
      : "";
  }
};

const claimDays = computed(() => {
  const days = store.availableDatesForStartOrdering
    .filter((date) => new Date(date) >= new Date(store.first_day))
    .slice(0, store.period_length);

  store.claim_days = days;
  return days;
});

let dates = computed(() => {
  if (props.stripeDays) {
    const getDays = Object.keys(JSON.parse(props.stripeDays.claims));
    return getDays.map((day) => parseISO(day));
  }
});
</script>
