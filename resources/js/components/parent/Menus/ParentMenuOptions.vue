<template>
  <template class="flex flex-wrap justify-between">
    <h1 class="mb-2 font-semibold text-gray-700">
      {{ `${menu.date} - ${menu.menu_name}` }}
    </h1>
  </template>
  <Form @submit="onSubmit">
    <div v-if="menu.menu_type === 'choices'">
      <template v-for="menu in menu.menu_name" :key="menu">
        <BaseRadio name="choices" :value="menu" />
      </template>
    </div>
    <div v-if="menu.menu_type === 'fixed'">
      <BaseRadio name="fixed" :value="menu.menu_name" />
    </div>
    <template v-if="menu.menu_type === 'choices'">
      <Button text="Submit" class="ml-auto w-1/2" type="submit" />
    </template>
  </Form>
</template>

<script setup>
import BaseRadio from "@/components/Ui/form-components/BaseRadio.vue";
import Button from "@/components/Ui/Button.vue";
import { Form } from "vee-validate";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";

const store = useMenuManagementStore();

const props = defineProps({
  menu: {
    type: Object,
    required: true,
  },
});

const onSubmit = function (values) {
  axios
    .post("/api/parent/save-menu", {
      values: values,
      date: props.menu.date,
    })
    .then(() => {
      store.toggleFixedCard = false;
      store.toggleChoicesCard = false;
      store.fixedMenus = [];
      store.choicesMenus = [];
    });
};
</script>
