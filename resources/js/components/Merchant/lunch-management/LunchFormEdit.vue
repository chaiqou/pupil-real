<template>
  <div v-if="dataIsLoaded" class="min-w-[30vw] sm:mt-20 xl:px-4">
    <form>
      <p class="mb-2 text-center text-xl font-black">
        {{ $t("message.create_a_new_lunch_plan") }}
      </p>
      <BaseInput
        v-model="store.title"
        name="Title"
        :label="$t('message.title')"
      />
      <BaseInput
        v-model="store.description"
        inputType="textarea"
        name="Description"
        :label="$t('message.description')"
      />
      <label class="text-md flex whitespace-normal font-bold text-gray-600"
        >{{ $t("message.active_range") }}
      </label>
      <Datepicker
        closeOnScroll
        :minDate="new Date()"
        :maxDate="addYears(new Date(), 1)"
        :partial-range="true"
        range
        @update:modelValue="addActiveRange"
        v-model="store.active_range"
        :enableTimePicker="false"
        :clearable="false"
      />
      <div>
        <label class="text-md font-bold text-gray-600">{{
          $t("message.weekdays")
        }}</label>
        <div class="grid grid-cols-3 gap-3 text-center sm:grid-cols-7">
          <ul v-for="day in dayOptions" :key="day">
            <li>
              <Field
                name="Weekdays"
                type="checkbox"
                :value="day.fullName"
                @input="toggleWeekdays(day)"
                :id="day.fullName"
                class="peer hidden"
                v-model="store.weekdays"
              />
              <label
                :for="day.fullName"
                class="text-md flex cursor-pointer items-center rounded-lg border-2 border-gray-200 bg-white px-3 py-2 text-left font-semibold text-gray-500 hover:bg-gray-50 hover:text-gray-600 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:ring-offset-2 xl:w-full"
              >
                <h1 class="mx-auto flex text-center md:-mx-1 lg:mx-auto">
                  {{ $t("message." + day.name) }}
                </h1>
              </label>
            </li>
          </ul>
        </div>
        <span class="mt-2 text-sm text-red-500">
          <ErrorMessage name="weekdays" />
        </span>
      </div>
      <div
        class="flex max-h-screen flex-col justify-center overflow-hidden bg-inherit"
      >
        <label
          class="text-md mt-2 flex whitespace-normal font-bold text-gray-600"
          >{{ $t("message.extras_and_holds") }}
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
                      {{ $t("message.extra_period") }}
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
                      {{ $t("message.remove") }}
                    </button>
                  </div>
                </div>
              </li>
              <li
                v-for="(hold, holdIdx) in store.holds"
                :key="hold"
                class="py-4"
              >
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
                      {{ $t("message.hold_period") }}
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
                      {{ $t("message.remove") }}
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
            range
            :partial-range="false"
            :minDate="new Date()"
            :enableTimePicker="false"
            no-disabled-range
          >
            <template #trigger>
              <p
                class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
              >
                {{ $t("message.add_extra") }}
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
            :partial-range="false"
            range
            :maxDate="addYears(new Date(), 1)"
            @update:modelValue="handleHoldsDate"
            :enableTimePicker="false"
            no-disabled-range
          >
            <template #trigger>
              <p
                class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
              >
                {{ $t("message.add_holds") }}
              </p>
            </template>
          </Datepicker>
        </div>
      </div>
      <BaseInput
        v-model="store.period_length"
        name="Period Length"
        :label="$t('message.period_length')"
        type="number"
      />
      <label class="text-md flex whitespace-normal font-bold text-gray-600"
        >{{ $t("message.claimables") }}
      </label>
      <Multiselect
        :value="claimablesArray"
        v-model="claimablesArray"
        mode="tags"
        name="claimables"
        :limit="10"
        :max="10"
        required
        autocomplete
        :close-on-select="false"
        :searchable="true"
        :options="multiselectOptions"
        selectAll
      />
      <VatMultiselect :value="store.vat" />
      <BaseInput
        v-model="store.price_period"
        name="Price Period"
        :label="$t('message.price_for_period') + ` (${$t('message.gross')})`"
        type="number"
      />
      <div class="my-5">
        <button
          :disabled="store.price_period && !afterFeeCanBeCalculated"
          @click="afterFeesCalculate"
          type="button"
          :class="
            calculateAvailable && afterFeeCanBeCalculated
              ? 'inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2'
              : 'inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2'
          "
        >
          {{ $t("message.calculate_after_fees") }}
        </button>
      </div>
      <BaseInput
        v-model="store.buffer_time"
        name="Buffer Time"
        :label="$t('message.buffer_time')"
        type="number"
        required
      />
      <Button
        @click="isOpen = !isOpen"
        type="button"
        :text="$t('message.save_lunch')"
      />
      <ConfirmationModal v-if="isOpen" />
    </form>
  </div>
</template>

<script setup>
import { addYears, format, eachDayOfInterval, parseISO } from "date-fns";
import { ref, onMounted, watch, computed } from "vue";
import { Field, ErrorMessage, useField } from "vee-validate";
import Multiselect from "@vueform/multiselect";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

import axios from "@/config/axios/index";
import BaseInput from "@/components/Ui/form-components/BaseInput.vue";
import Button from "@/components/Ui/Button.vue";
import ExtrasIcon from "@/components/icons/ExtrasIcon.vue";
import HoldsIcon from "@/components/icons/HoldsIcon.vue";
import ConfirmationModal from "@/components/Merchant/lunch-management/ConfirmationModal.vue";
import VatMultiselect from "./VatMultiselect.vue";

// Composables

const store = useLunchFormStore();

// Data

const isOpen = ref(false);
const dataIsLoaded = ref(false);
// Fetch appropriate lunch from API
const afterFeeCanBeCalculated = ref(false);

const { value } = useField("Price Period");

const afterFeesCalculate = () => {
  store.after_fees = Math.round(
    (Number(store.price_period) + 85) / (1 - 7 / 500),
  );
  store.price_period = store.after_fees;
  afterFeeCanBeCalculated.value = false;
  value.value = store.price_period;
};

const calculateAvailable = computed(() => !!store.price_period);

watch(
  () => store.price_period,
  () => {
    if (store.after_fees !== store.price_period) {
      afterFeeCanBeCalculated.value = true;
    }
    store.after_fees = "";
  },
);

// When we have custom values for claimables if we need fill input with custom values we need to update multiselectOptions array

const claimablesArray = ref([]);

watch(store, () => {
  store.claimables.forEach((element) => {
    claimablesArray.value = [...claimablesArray.value, ...element.split(" ")];
  });

  multiselectOptions.value = [
    ...multiselectOptions.value,
    ...claimablesArray.value,
  ];
});

onMounted(() => {
  axios
    .get(`/school/lunch/${localStorage.getItem("lunchId")}`)
    .then((response) => {
      dataIsLoaded.value = true;
      store.title = response.data.data.title;
      store.description = response.data.data.description;
      store.period_length = response.data.data.period_length;
      store.weekdays = response.data.data.weekdays;
      store.active_range = response.data.data.active_range;
      store.marked_days = response.data.data.available_days;
      store.claimables = response.data.data.claimables;
      store.price_period = response.data.data.price_period;
      store.extras = response.data.data.extras;
      store.holds = response.data.data.holds;
      store.lunch_id = response.data.data.id;
      store.buffer_time = response.data.data.buffer_time;
      store.vat = response.data.data.vat;
    });
});

// Extras part

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

// Holds Part

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

// Weekdays part

const toggleWeekdays = (day) => {
  let eachDay = [];

  if (store.active_range !== null) {
    eachDay = eachDayOfInterval({
      start: parseISO(store.active_range[0]),
      end: parseISO(store.active_range[1]),
    });
  }

  eachDay.map((date) => {
    if (date.getDay() === day.index && store.weekdays.includes(day.fullName)) {
      store.marked_days.push(format(new Date(date), "yyyy-MM-dd"));
    } else if (
      date.getDay() === day.index &&
      !store.weekdays.includes(day.fullName)
    ) {
      const filteredDays = store.marked_days.filter(
        (item) => item !== format(new Date(date), "yyyy-MM-dd"),
      );
      store.marked_days = [...filteredDays, ...store.add_marked_extras];
    }
  });
};

const dayOptions = [
  { name: "m", fullName: "Monday", index: 1 },
  { name: "t", fullName: "Tuesday", index: 2 },
  { name: "w", fullName: "Wednesday", index: 3 },
  { name: "t", fullName: "Thursday", index: 4 },
  { name: "f", fullName: "Friday", index: 5 },
  { name: "s", fullName: "Saturday", index: 6 },
  { name: "s", fullName: "Sunday", index: 0 },
];

// Active range part

const addActiveRange = (modelData) => {
  if (store.active_range.length < 2) {
    store.active_range.push(...modelData);
  } else {
    store.active_range.splice(0, 2, ...modelData);
  }

  const eachDay = eachDayOfInterval({
    start: modelData[0],
    end: modelData[1],
  });

  // format each day to YYYY-MM-DD'

  const formatedDate = [];

  for (let i = 0; i < eachDay.length; i++) {
    formatedDate.push(format(new Date(eachDay[i]), "yyyy-MM-dd"));
  }

  // if marked days doesnot contain any of the days in the range, remove all marked days

  if (store.marked_days.length > 0) {
    for (let i = 0; i < store.marked_days.length; i++) {
      if (!formatedDate.includes(store.marked_days[i])) {
        store.marked_days.splice(0, store.marked_days.length);
      }
    }
  }

  // if weekdays are selected and matched with each day of active range then add them to store
  eachDay.map((day) => {
    if (store.weekdays) {
      store.weekdays.map((weekday) => {
        if (weekday === format(day, "EEEE")) {
          store.marked_days.push(format(day, "yyyy-MM-dd"));
        }
      });
    }
  });
};

// Multiselect options and styles

const multiselectOptions = ref([
  "Breakfast",
  "Lunch",
  "Dinner",
  "Snack",
  "Dessert",
  "Drink",
  "Appetizer",
  "Salad",
  "Bread",
  "Cereal",
  "Soup",
  "Beverage",
  "Sauce",
  "Marinade",
  "Fingerfood",
  "Salsa",
  "Dip",
]);
</script>

<style src="@vueform/multiselect/themes/default.css" />
<style>
body {
  --ms-bg: transparent;
  --ms-tag-bg: #6c757d;
  --ms-border-color: #6c757d;
}
.multiselect-tags-search {
  background-color: inherit;
}
</style>
