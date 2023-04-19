<template>
  <div>
    <label class="text-md font-bold text-gray-600">{{$t('message.weekdays')}}</label>
    <div class="grid grid-cols-3 gap-3 text-center sm:grid-cols-7">
      <ul v-for="day in dayOptions" :key="day">
        <li>
          <Field
            name="weekdays"
            type="checkbox"
            :value="day.fullName"
            @input="toggleWeekdays(day)"
            rules="required"
            :id="day.fullName"
            class="peer hidden"
            v-model="store.weekdays"
          />
          <label
            :for="day.fullName"
            class="text-md flex cursor-pointer items-center rounded-lg border-2 border-gray-200 bg-white px-3 py-2 text-left font-semibold text-gray-500 hover:bg-gray-50 hover:text-gray-600 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:ring-offset-2 xl:w-full"
          >
            <h1 class="mx-auto flex text-center md:-mx-1 lg:mx-auto">
              {{ $t('message.'+day.name) }}
            </h1>
          </label>
        </li>
      </ul>
    </div>
    <span class="mt-2 text-sm text-red-500">
      <ErrorMessage name="weekdays" />
    </span>
  </div>
</template>

<script setup>
import { Field, ErrorMessage } from "vee-validate";
import { format, eachDayOfInterval } from "date-fns";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

const store = useLunchFormStore();

const toggleWeekdays = (day) => {
  const eachDay = eachDayOfInterval({
    start: store.active_range[0],
    end: store.active_range[1],
  });

  eachDay.map((date) => {
    if (
      date.getDay() === day.index &&
      store.weekdays.includes(day.fullName) &&
      store.holds.length === 0
    ) {
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
</script>
