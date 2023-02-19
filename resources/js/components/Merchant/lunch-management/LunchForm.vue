<template>
  <div class="min-w-[30vw] sm:mt-20 xl:px-4">
    <form @submit.prevent="onSubmit">
      <p class="mb-2 text-center text-xl font-black">Create new lunch plan</p>
      <BaseInput
        v-model="store.title"
        name="Title"
        label="Title"
        rules="required|min:3|max:100"
      />
      <BaseInput
        v-model="store.description"
        inputType="textarea"
        name="Description"
        label="Description"
        rules="required|min:3|max:100"
      />
      <label class="text-md flex whitespace-normal font-bold text-gray-600"
        >Active Range
      </label>
      <Datepicker
        closeOnScroll
        required
        :minDate="new Date()"
        :maxDate="addYears(new Date(), 1)"
        :partialRange="false"
        @update:modelValue="addActiveRange"
        :enableTimePicker="false"
        v-model="activeRange"
        :clearable="false"
        range
      />
      <WeekdaysChechkbox name="weekdays" />
      <ExtrasAndHolds holds="holds" extras="extras" />
      <BaseInput
        v-model="store.period_length"
        name="Period Length"
        label="Period Length"
        type="number"
        rules="required"
      />
      <label class="text-md flex whitespace-normal font-bold text-gray-600"
        >Claimables
      </label>
      <Multiselect
        v-model="store.claimables"
        mode="tags"
        name="claimables"
        :limit="10"
        :max="10"
        ref="multiselectRef"
        required
        autocomplete
        appendNewOption
        searchable
        :createOption="true"
        :close-on-select="false"
        :searchable="true"
        :options="multiselectOptions"
      />
      <VatMultiselect />
      <BaseInput
        v-model="store.price_period"
        name="Price Period"
        label="Price for period (Gross)"
        type="number"
        rules="required"
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
          Calculate after fees
        </button>
      </div>
      <BaseInput
        v-model.number="store.buffer_time"
        name="buffer_time"
        label="Buffer time"
        type="number"
        rules="required|minNumber:1|maxNumber:72"
        placeholder="from 1 to 72 hours"
      />
      <Button text="Save Lunch" />
    </form>
    <Toast ref="childrenToast" />
  </div>
</template>

<script setup>
import { useField, useForm } from 'vee-validate';
import { addYears, format, eachDayOfInterval } from 'date-fns';
import { ref, watch, computed } from 'vue';
import Multiselect from '@vueform/multiselect';
import { useLunchFormStore } from '@/stores/useLunchFormStore';

import axios from '@/config/axios/index';
import BaseInput from '@/components/Ui/form-components/BaseInput.vue';
import VatMultiselect from './VatMultiselect.vue';
import WeekdaysChechkbox from '@/components/Merchant/lunch-management/WeekdaysCechkbox.vue';
import ExtrasAndHolds from '@/components/Merchant/lunch-management/ExtrasAndHolds.vue';
import Button from '@/components/Ui/Button.vue';
import Toast from '@/components/Ui/Toast.vue';

const store = useLunchFormStore();
const { handleSubmit } = useForm();
const { value } = useField('Price Period');

const multiselectRef = ref(null);
const activeRange = ref(null);
const childrenToast = ref();
const afterFeeCanBeCalculated = ref(false);
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
    store.after_fees = '';
  },
);

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
    formatedDate.push(format(new Date(eachDay[i]), 'yyyy-MM-dd'));
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
        if (weekday === format(day, 'EEEE')) {
          store.marked_days.push(format(day, 'yyyy-MM-dd'));
        }
      });
    }
  });
};

const onSubmit = handleSubmit((values, { resetForm }) => {
  axios
    .post('/school/lunch', {
      title: store.title,
      description: store.description,
      period_length: store.period_length,
      weekdays: store.weekdays,
      active_range: [
        format(store.active_range[0], 'yyyy-MM-dd'),
        format(store.active_range[1], 'yyyy-MM-dd'),
      ],
      claimables: store.claimables,
      holds: store.holds,
      extras: store.extras,
      price_period: store.price_period,
      vat: store.vat,
      available_days: store.marked_days,
      buffer_time: store.buffer_time,
    })
    .then(() => {
      resetForm();
      multiselectRef.value.clear();
      childrenToast.value.showToaster('Lunch created successfully');
      setTimeout(() => {
        window.location.href = '/school/lunch-management/';
      }, 1000);
    });

  store.extras = [];
  store.holds = [];
  store.disabled_hold_days = [];
  store.disabled_extra_days = [];
});

const multiselectOptions = [
  'Breakfast',
  'Lunch',
  'Dinner',
  'Snack',
  'Dessert',
  'Drink',
  'Appetizer',
  'Salad',
  'Bread',
  'Cereal',
  'Soup',
  'Beverage',
  'Sauce',
  'Marinade',
  'Fingerfood',
  'Salsa',
  'Dip',
];
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
