<template>
  <ParentCardLayout>
    <BaseRadio :name="menu.menu_name" :value="value" :date="menu.date" />
  </ParentCardLayout>
</template>

<script setup>
import ParentCardLayout from "@/components/parent/Menus/ParentCardLayout.vue";
import BaseRadio from "@/components/Ui/form-components/BaseRadio.vue";

defineProps({
  menu: {
    type: Object,
    required: true,
  },
  value: {
    type: [Boolean, String],
    required: true,
  },
});
</script>
