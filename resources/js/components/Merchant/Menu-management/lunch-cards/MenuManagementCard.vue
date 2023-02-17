<template>
  <div
    class="fixed flex min-h-screen w-screen flex-col z-50 justify-center items-center bg-black/50"
  >
    <div
      ref="target"
      class="absolute md:right-1/3 xl:right-[45%] bg-white px-6 py-10 shadow-2xl max-w-lg rounded-lg w-full"
    >
      <template class="flex flex-wrap justify-between border-b border-gray-200">
        <h2 class="text-gray-700 mb-2 font-semibold">
          {{ format(store.selectedDay, "yyyy MMMM dd") }}
        </h2>
      </template>

      <template v-for="lunch in store.suitableLunch" :key="lunch.id">
        <SingleLunchCard
          :lunch-id="lunch.id"
          :claimables="lunch.claimables"
          :name="lunch.title"
        />
      </template>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { format } from "date-fns";
import { onClickOutside } from "@vueuse/core";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import SingleLunchCard from "./SingleLunchCard.vue";

const store = useMenuManagementStore();

// Get suitable lunch for these days and return top await

const getLunchData = async () => {
  try {
    const response = await axios.get("/api/lunch/suitable-lunch/date", {
      params: { date: format(store.selectedDay, "yyyy-MM-dd") },
    });

    store.suitableLunch = response.data.lunches;

    return response;
  } catch (error) {
    console.log(error);
  }
};

const lunchData = await getLunchData();

// Close on click outside model

const target = ref(null);

onClickOutside(target, () => {
  store.toggleMenuManagementCard = false;
  store.suitableLunch = [];
  store.selectedDay = "";
});
</script>
