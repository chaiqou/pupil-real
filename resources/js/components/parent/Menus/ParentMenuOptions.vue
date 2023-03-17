<template>
  <h2
    class="whitespace-wrap mb-2 w-64 overflow-hidden break-words font-semibold text-gray-700"
  >
    {{ `${menu.name} - ${menu.date}` }}
  </h2>
  <Form @submit="onSubmitForm">
    <div v-if="menu.menu_type === 'choices'">
      <template v-for="menu in menu.menu_name" :key="menu">
        <!-- <BaseRadio name="choices" :value="menu" /> -->
        <label
          class="relative mb-2 flex cursor-pointer flex-col whitespace-nowrap rounded-lg border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
        >
          <span class="flex items-center text-sm">
            <Field
              name="choices"
              type="radio"
              :value="menu"
              v-model="selectedvalue"
              class="form-checkbox checked:foucs:border-indigo-700 checked:border-indigo-700 checked:bg-indigo-700 checked:outline-indigo-500 checked:hover:bg-indigo-700 checked:focus:bg-indigo-700"
            />
            <span class="ml-3 font-medium">{{ menu }}</span>
          </span>
        </label>
      </template>
    </div>
    <div v-if="menu.menu_type === 'fixed'">
      <BaseRadio name="fixed" :value="menu.menu_name" />
    </div>
  </Form>
</template>

<script setup>
import BaseRadio from "@/components/Ui/form-components/BaseRadio.vue";
import { Form, Field } from "vee-validate";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { ref } from "vue";

const store = useMenuManagementStore();

const props = defineProps({
  menu: {
    type: Object,
    required: true,
  },
});

const selectedvalue = ref(null);

const onSubmitForm = function (values) {
  axios
    .post("/api/parent/choice-claims", {
      date: props.menu.date,
      claimable: selectedvalue.value,
      claimable_type: props.menu.name,
    })
    .then(() => {
      store.toggleFixedCard = false;
      store.toggleChoicesCard = false;
      store.fixedMenus = [];
      store.choicesMenus = [];
    });
};

defineExpose({
  onSubmitForm,
});
</script>
