<template>
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
        class="mx-auto h-0.5 w-4 rounded-full bg-indigo-600"
      ></div>
    </div>
  </time>
</template>

<script setup>
import { format, isToday } from "date-fns";
import useCheckIfDaysMatches from "@/composables/calendar/useCheckIfDaysMatches";

const props = defineProps({
  day: {
    type: Date,
    required: true,
  },
});

const { ifDaysMatch } = useCheckIfDaysMatches();
</script>
