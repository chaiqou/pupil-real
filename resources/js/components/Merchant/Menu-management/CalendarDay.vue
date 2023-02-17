<template>
  <time
    :datetime="format(day, 'yyyy-MM-dd')"
    class="mx-auto flex h-6 w-6 p-4 items-center justify-center rounded-md"
  >
    <div class="flex-col">
      <h1>
        {{ format(day, "d") }}
      </h1>
      <div
        v-if="ifDaysMatch(day) && isToday(day)"
        class="w-4 h-0.5 mx-auto bg-white rounded-full"
      ></div>
      <div
        v-if="ifDaysMatch(day) && !isToday(day)"
        class="w-4 h-0.5 mx-auto bg-indigo-600 rounded-full"
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
