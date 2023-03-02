<template>
  <template class="flex flex-wrap justify-between">
    <h1 class="mb-2 font-semibold text-gray-700">
      {{ `${menu.date} - ${menu.menu_type}` }}
    </h1>
  </template>
  <div v-if="menu.menu_type === 'choices'">
    <template v-for="menu in menu.menu_name" :key="menu">
      <BaseRadio v-model="choicesValue" :label="menu" name="choices" />
    </template>
  </div>
  <div v-if="menu.menu_type === 'fixed'">
    <BaseRadio v-model="fixedValue" :label="menu.menu_name" name="fixed" />
  </div>
</template>

<script setup>
import { ref } from "vue";
import BaseRadio from "@/components/Ui/form-components/BaseRadio.vue";

defineProps({
  menu: {
    type: Object,
    required: true,
  },
});

const choicesValue = ref("");
const fixedValue = ref(true);
</script>
