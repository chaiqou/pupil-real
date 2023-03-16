<template>
  <div v-for="menu in menus" :key="menu.name">
    <h2
      class="whitespace-wrap mb-2 w-64 overflow-hidden break-words font-semibold text-gray-700"
    >
      {{ `${menu.name} - ${menu.date}` }}
    </h2>

    <Form @submit="onSubmitForm">
      <div v-if="menu.menu_type === 'choices'">
        <template v-for="menu in menu.menu_name" :key="menu">
          <BaseRadio name="choices" :value="menu" />
        </template>
      </div>
      <div v-if="menu.menu_type === 'fixed'">
        <BaseRadio name="fixed" :value="menu.menu_name" />
      </div>
    </Form>
  </div>

  <Button text="Submit" class="ml-auto w-1/2" type="submit" />
</template>

<script setup>
import BaseRadio from "@/components/Ui/form-components/BaseRadio.vue";
import { Form } from "vee-validate";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import Button from "@/components/Ui/Button.vue";

const store = useMenuManagementStore();

const props = defineProps({
  menus: {
    type: Object,
    required: true,
  },
});

const onSubmitForm = function (values) {
  axios
    .post("/api/parent/choice-claims", {
      date: props.menu.date,
      claimable: values,
      claimable_type: props.menu.name,
    })
    .then(() => {
      store.toggleFixedCard = false;
      store.toggleChoicesCard = false;
      store.fixedMenus = [];
      store.choicesMenus = [];
    });
};
</script>
