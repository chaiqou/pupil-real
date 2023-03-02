<template>
  <ParentCardLayout>
    <div v-for="menu in menus" :key="menu">
      <BaseRadio
        :name="menu"
        :value="value"
        :menu_name="menu.menu_name"
        :date="menu.date"
      />
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
