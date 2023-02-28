<template>
  <ParentCardsLayout>
    <BaseRadio
      :prop-name="menu.menu_name"
      :prop-value="menu.name"
      :prop-date="menu.date"
    />
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
});
</script>
