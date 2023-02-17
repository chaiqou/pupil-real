<template>
  <div
    class="fixed flex min-h-screen w-screen flex-col z-50 justify-center items-center bg-black/50"
  >
    <div
      ref="target"
      class="absolute md:right-1/3 xl:right-[45%] bg-white px-6 py-10 shadow-2xl max-w-lg rounded-lg w-full"
    >
      <template class="flex flex-wrap justify-between border-b border-gray-200">
        <h1 class="text-gray-700 mb-2 font-semibold">
          {{ store.lunchName }}
        </h1>
      </template>
      <div
        v-for="claimable in store.parsedClaimables(claimables)"
        :key="claimable"
      >
        <h2 class="text-gray-700 m-2 font-semibold">
          {{ claimable }}
        </h2>
        <BaseInput
          v-model="menus[claimable]"
          :name="claimable"
          class="w-full"
        />
      </div>
      <SaveAndDiscardButtons
        :day="store.selectedDay"
        :menus="menus"
        :is-disabled="buttonIsDisabled"
        menu-type="Fixed"
      />
    </div>
  </div>
</template>

<script setup>
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { onClickOutside } from "@vueuse/core";
import { ref, onMounted, computed } from "vue";
import BaseInput from "@/components/Ui/form-components/BaseInput.vue";
import SaveAndDiscardButtons from "@/components/Merchant/Menu-management/SaveAndDiscardButtons.vue";
import useSaveButtonIsDisabled from "@/composables/menu-management/useSaveButtonIsDisabled";

const store = useMenuManagementStore();

const menus = ref({});

// Close on click outside

const target = ref(null);
onClickOutside(target, () => {
  store.toggleFixedCard = false;
});

// Create menus array based on claimables

const claimables = computed(() => store.claimables);

onMounted(() => {
  JSON.parse(claimables.value).forEach((claimable) => {
    menus.value[claimable] = [];
  });
});

// disable button if at least one array inside menus is empty

const { buttonIsDisabled } = useSaveButtonIsDisabled(menus.value);
</script>
