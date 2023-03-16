<template>
  <ParentCardLayout>
    <ParentMenuOptions :menus="menus" />
  </ParentCardLayout>
</template>

<script setup>
import ParentCardLayout from "@/components/parent/Menus/ParentCardLayout.vue";
import ParentMenuOptions from "@/components/parent/Menus/ParentMenuOptions.vue";

defineProps({
  menus: {
    type: Object,
    required: true,
  },
});
</script>
