<template>
  <ParentCardLayout>
    <div v-for="menu in menus" :key="menu.menu_name">
      <ParentMenuOptions :menu="menu" />
    </div>
    <template v-if="menus[0].menu_type === 'choices'">
      <Button text="Submit" class="ml-auto w-1/2" type="submit" />
    </template>
  </ParentCardLayout>
</template>

<script setup>
import ParentCardLayout from "@/components/parent/Menus/ParentCardLayout.vue";
import ParentMenuOptions from "@/components/parent/Menus/ParentMenuOptions.vue";
import Button from "@/components/Ui/Button.vue";

defineProps({
  menus: {
    type: Object,
    required: true,
  },
});
</script>
