<template>
  <div v-if="store.confirmationModal">
    <ConfirmModal />
  </div>

  <div
    v-if="!store.confirmationModal"
    class="fixed z-50 flex min-h-screen w-screen flex-col items-center justify-center bg-black/50"
  >
    <div
      ref="target"
      class="absolute w-full max-w-lg rounded-lg bg-white px-6 py-10 shadow-2xl md:right-1/3 xl:right-[45%]"
    >
      <template class="flex flex-wrap justify-between border-b border-gray-200">
        <h2 class="mb-2 font-semibold text-gray-700">
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
import ConfirmModal from "@/components/Ui/ConfirmModal.vue";

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

// eslint-disable-next-line no-unused-vars
const lunchData = await getLunchData();

// Close on click outside model

const target = ref(null);

onClickOutside(target, () => {
  store.confirmationModal = true;
});
</script>
