<template>
  <h2
    class="whitespace-wrap mb-2 w-64 overflow-hidden break-words font-semibold text-gray-700"
  >
    {{ `${menu.name} - ${menu.date}` }}
  </h2>
  <Form @submit="onSubmitForm">
    <div v-if="menu.menu_type === 'choices'">
      <template v-for="menu in menu.menu_name" :key="menu">
        <BaseRadio name="choices" :value="menu" @update:radio="radioUpdated" />
      </template>
    </div>
    <div v-if="menu.menu_type === 'fixed'">
      <BaseRadio name="fixed" :value="menu.menu_name" />
    </div>
  </Form>
</template>

<script setup>
import BaseRadio from "@/components/Ui/form-components/BaseRadio.vue";
import { Form } from "vee-validate";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { ref, onMounted } from "vue";

const store = useMenuManagementStore();

const props = defineProps({
  menu: {
    type: Object,
    required: true,
  },
});

let selectedRadio = ref(null);

let radioUpdated = function (value) {
  selectedRadio.value = value;
};

onMounted(() => {
  if (selectedRadio.value === null) {
    selectedRadio.value = props.menu.menu_name[0];
  }

  const url = window.location.href;
  const eachUrlSegment = url.split("/");
  const userId = eachUrlSegment[eachUrlSegment.length - 1];
  studentId.value = userId;
});

const studentId = ref();

const onSubmitForm = function () {
  axios
    .post("/api/parent/choice-claims", {
      date: props.menu.date,
      claimable: selectedRadio.value,
      claimable_type: props.menu.name,
      student_id: studentId.value,
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
