<template>
  <div>
    <BaseTooltip
      v-if="!store.marked_days.includes(format(day, 'yyyy-MM-dd'))"
      content="No lunch for the day"
      placement="top"
    >
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
    </BaseTooltip>
    <div v-else>
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
    </div>
  </div>
</template>

<script setup>
import { format, isToday } from "date-fns";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import BaseTooltip from "@/components/Ui/BaseTooltip.vue";
import useCheckIfDaysMatches from "@/composables/calendar/useCheckIfDaysMatches";

const store = useLunchFormStore();
const { ifDaysMatch } = useCheckIfDaysMatches();

const props = defineProps({
  day: {
    type: Date,
    required: true,
  },
});
</script>
