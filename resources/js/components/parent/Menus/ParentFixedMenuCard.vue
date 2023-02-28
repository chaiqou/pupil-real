<template>
  <ParentCardsLayout>
    <BaseRadio :prop-name="menu.name" :prop-value="menu.menu_type" />
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
