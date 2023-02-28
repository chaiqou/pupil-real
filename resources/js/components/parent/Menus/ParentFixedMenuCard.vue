<template>
  <ParentCardsLayout>
    <BaseRadio :name="menu.menu_name" :value="value" :date="menu.date" />
  </ParentCardsLayout>
</template>

<script setup>
import ParentCardsLayout from "@/components/parent/Menus/ParentCardsLayout.vue";
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
