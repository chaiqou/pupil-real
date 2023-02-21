<template>
  <div class="border-b border-gray-200">
    <h2 class="mt-2 font-semibold text-gray-700">{{ name }}</h2>
    <div
      class="my-4 flex w-full flex-wrap justify-between space-y-4 sm:flex-nowrap sm:space-y-0 sm:space-x-12"
    >
      <template v-for="option in options">
        <button
          type="button"
          @click="onClickShowCard(option)"
          class="w-full items-center rounded-md border border-gray-300 bg-white p-4 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          {{ option }}
        </button>
      </template>
    </div>
  </div>
</template>

<script setup>
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  claimables: {
    type: String,
    required: true,
  },
  lunchId: {
    type: Number,
    required: true,
  },
});

const store = useMenuManagementStore();

const onClickShowCard = (cardName) => {
  store.toggleMenuManagementCard = false;
  store.claimables = props.claimables;
  store.lunchName = props.name;
  store.lunchId = props.lunchId;

  cardName === "Fixed"
    ? (store.toggleFixedCard = true)
    : (store.toggleChoicesCard = true);
};

const options = ["Fixed", "Choices"];
</script>
