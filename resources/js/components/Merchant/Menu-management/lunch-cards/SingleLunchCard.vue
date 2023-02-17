<template>
  <div class="border-b border-gray-200">
    <h2 class="text-gray-700 mt-2 font-semibold">{{ name }}</h2>
    <div
      class="flex flex-wrap space-y-4 w-full justify-between my-4 sm:space-y-0 sm:flex-nowrap sm:space-x-12"
    >
      <template v-for="option in options">
        <button
          type="button"
          @click="onClickShowCard(option)"
          class="items-center p-4 w-full rounded-md border border-gray-300 bg-white text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
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
