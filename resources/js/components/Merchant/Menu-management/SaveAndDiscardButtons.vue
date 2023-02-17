<template>
  <div class="flex gap-4 mt-4">
    <button
      type="button"
      @click="onClickDiscard"
      class="basis-1/2 text-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    >
      Discard
    </button>
    <button
      :disabled="isDisabled"
      @click="onClickSaveMenu"
      type="button"
      class="basis-1/2 text-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
      :class="[isDisabled ? 'opacity-50 cursor-not-allowed' : '']"
    >
      Save
    </button>
  </div>
</template>

<script setup>
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";

const store = useMenuManagementStore();

const props = defineProps({
  isDisabled: {
    type: Boolean,
    required: true,
  },
  menuType: {
    type: String,
    required: true,
  },
  menus: {
    type: Object,
    required: true,
  },
  day: {
    type: Date,
    required: true,
  },
});

// Discard button
const onClickDiscard = () => {
  store.toggleFixedCard = false;
  store.toggleChoicesCard = false;
};

// Send information to backend on clikc save button

const onClickSaveMenu = () => {
  axios
    .post("/api/merchant/create-menu", {
      menu_type: props.menuType,
      menus: props.menus,
      day: props.day,
      lunch_id: store.lunchId,
    })
    .then(() => {
      store.toggleFixedCard = false;
      store.toggleChoicesCard = false;
    });
};
</script>
