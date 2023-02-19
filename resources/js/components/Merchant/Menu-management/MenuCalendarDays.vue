<template>
  <BaseTooltip
    v-if="!store.marked_days.includes(format(day, 'yyyy-MM-dd'))"
    content="No lunch for the day"
    placement="top"
  >
    <CalendarDay :day="day" />
  </BaseTooltip>

  <template v-else>
    <CalendarDay :day="day" />
  </template>
</template>

<script setup>
import { format } from 'date-fns';
import { useLunchFormStore } from '@/stores/useLunchFormStore';
import BaseTooltip from '@/components/Ui/BaseTooltip.vue';
import CalendarDay from '@/components/Merchant/Menu-management/CalendarDay.vue';

const store = useLunchFormStore();

const props = defineProps({
  day: {
    type: Date,
    required: true,
  },
});
</script>
