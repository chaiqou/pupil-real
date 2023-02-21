<template>
  <div
    class="flex max-h-screen flex-col justify-center overflow-hidden bg-inherit"
  >
    <label class="text-md mt-2 flex whitespace-normal font-bold text-gray-600"
      >Extras and Holds
    </label>
    <div class="rounded-md bg-inherit">
      <div class="mt-6 flow-root">
        <ul role="list" class="-my-5 divide-y divide-gray-200">
          <li
            v-for="(extra, extraIdx) in store.extras"
            :key="extra"
            class="py-4"
          >
            <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                <span
                  class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-500"
                >
                  <ExtrasIcon />
                </span>
              </div>
              <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-900">
                  Extra period
                </p>
                <p class="truncate text-sm text-gray-500">
                  {{ `${extra[0]} - ${extra[1]}` }}
                </p>
              </div>
              <div>
                <button
                  type="button"
                  @click="removeExtra(extraIdx, extra)"
                  class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                >
                  Remove
                </button>
              </div>
            </div>
          </li>
          <li v-for="(hold, holdIdx) in store.holds" :key="hold" class="py-4">
            <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                <span
                  class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-500"
                >
                  <HoldsIcon />
                </span>
              </div>
              <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-900">
                  Hold period
                </p>
                <p class="truncate text-sm text-gray-500">
                  {{ `${hold[0]} - ${hold[1]}` }}
                </p>
              </div>
              <div>
                <button
                  type="button"
                  @click="removeHold(holdIdx, hold)"
                  class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                >
                  Remove
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="mt-6 grid grid-cols-2 grid-rows-1 space-x-2">
      <Datepicker
        closeOnScroll
        @update:modelValue="handleExtrasDate"
        :disabledDates="[
          ...store.disabled_hold_days,
          ...store.disabled_extra_days,
        ]"
        :maxDate="addYears(new Date(), 1)"
        :partialRange="false"
        :minDate="new Date()"
        :enableTimePicker="false"
        no-disabled-range
        range
      >
        <template #trigger>
          <p
            class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
          >
            Add extra
          </p>
        </template>
      </Datepicker>
      <Datepicker
        closeOnScroll
        :minDate="new Date()"
        :disabledDates="[
          ...store.disabled_hold_days,
          ...store.disabled_extra_days,
        ]"
        :partialRange="false"
        :maxDate="addYears(new Date(), 1)"
        @update:modelValue="handleHoldsDate"
        :enableTimePicker="false"
        no-disabled-range
        range
      >
        <template #trigger>
          <p
            class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
          >
            Add holds
          </p>
        </template>
      </Datepicker>
    </div>
  </div>
</template>

<script setup>
import { addYears, format } from "date-fns";
import ExtrasIcon from "@/components/icons/ExtrasIcon.vue";
import HoldsIcon from "@/components/icons/HoldsIcon.vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

const store = useLunchFormStore();

defineProps({
  extras: {
    type: String,
    required: true,
  },
  holds: {
    type: String,
    required: true,
  },
});

// Extras

const removeExtra = (extraIdx, extra) => {
  store.extras.splice(extraIdx, 1);

  const dates = [];
  const startDate = new Date(extra[0]);
  const endDate = new Date(extra[1]);

  while (startDate <= endDate) {
    dates.push(new Date(startDate));
    startDate.setDate(startDate.getDate() + 1);
  }

  const formattedDates = dates.map((date) => format(date, "yyyy-MM-dd"));

  store.formatDateForHumans("disabled_extra_days", store.disabled_extra_days);

  store.disabled_extra_days = store.disabled_extra_days.filter(
    (date) => !formattedDates.includes(date),
  );

  store.removeDaysFromMarkedDays(extra);

  store.add_marked_extras = [];
};

const handleExtrasDate = (modelData) => {
  store.extras.push([
    format(modelData[0], "yyyy-MM-dd"),
    format(modelData[1], "yyyy-MM-dd"),
  ]);

  store.disabledDaysDate(modelData[0], modelData[1]).forEach((data) => {
    store.disabled_extra_days.push(data);
  });

  // add extras to marked days

  store.findMiddleRangeDates("add_extras", store.extras);
  let deUnique = store.add_marked_extras;
  const uniqueValues = new Set(deUnique);
  deUnique = Array.from(uniqueValues);

  store.remove_marked_holds.map((hold) => {
    if (deUnique.includes(hold)) {
      deUnique.splice(deUnique.indexOf(hold), 1);
    }
  });

  deUnique.map((extra) => {
    if (!store.marked_days.includes(extra)) {
      store.marked_days.push(extra);
    }
  });
};

// Holds

const removeHold = (holdIdx, hold) => {
  store.holds.splice(holdIdx, 1);

  const dates = [];
  const startDate = new Date(hold[0]);
  const endDate = new Date(hold[1]);

  while (startDate <= endDate) {
    dates.push(format(new Date(startDate), "yyyy-MM-dd"));
    startDate.setDate(startDate.getDate() + 1);
  }

  store.marked_days = [...store.marked_days, ...dates];

  store.formatDateForHumans("disabled_hold_days", store.disabled_hold_days);

  store.disabled_hold_days = store.disabled_hold_days.filter(
    (date) => !dates.includes(date),
  );
};

const handleHoldsDate = (modelData) => {
  store.holds.push([
    format(modelData[0], "yyyy-MM-dd"),
    format(modelData[1], "yyyy-MM-dd"),
  ]);

  store.disabledDaysDate(modelData[0], modelData[1]).forEach((date) => {
    store.disabled_hold_days.push(date);
  });

  // Remove holds from marked days

  store.findMiddleRangeDates("remove_holds", store.holds);
  const daysToDelete = new Set(store.remove_marked_holds);

  store.add_marked_extras.map((extra) => {
    if (daysToDelete.has(extra)) {
      daysToDelete.delete(extra);
    }
  });

  const removedDaysArray = store.marked_days.filter(
    (day) => !daysToDelete.has(day),
  );

  store.marked_days = removedDaysArray;
};
</script>
