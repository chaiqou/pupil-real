<template>
  <ParentCardLayout>
    <div v-for="menu in menus" :key="menu.menu_name">
      <BaseRadio :name="menu.menu_name" :value="value" :date="menu.date" />
    </div>
  </ParentCardLayout>
</template>

<script setup>
import ParentCardLayout from "@/components/parent/Menus/ParentCardLayout.vue";
import BaseRadio from "@/components/Ui/form-components/BaseRadio.vue";

defineProps({
  menus: {
    type: Object,
    required: true,
  },
  value: {
    type: [Boolean, String],
    required: true,
  },
});
</script>
