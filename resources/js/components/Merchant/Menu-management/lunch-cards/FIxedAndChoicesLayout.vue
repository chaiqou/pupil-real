<template>
  <div
    class="fixed z-50 flex min-h-screen w-screen flex-col items-center justify-center bg-black/50"
  >
    <div
      class="absolute w-full max-w-lg rounded-lg bg-white px-6 py-10 shadow-2xl md:right-1/3 xl:right-[45%]"
    >
      <template class="flex flex-wrap justify-between border-b border-gray-200">
        <h1 class="mb-2 font-semibold text-gray-700">
          {{ store.lunchName }}
        </h1>
      </template>
      <slot></slot>

      <SaveAndDiscardButtons
        :day="store.selectedDay"
        :menus="menus"
        :is-disabled="buttonIsDisabled"
        :menu-type="menuType"
      />
    </div>
  </div>
</template>

<script setup>
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import SaveAndDiscardButtons from "@/components/Merchant/Menu-management/components/SaveAndDiscardButtons.vue";
import useSaveButtonIsDisabled from "@/composables/menu-management/useSaveButtonIsDisabled";

const props = defineProps({
  menus: {
    type: Object,
    required: true,
  },
  menuType: {
    type: String,
    required: true,
  },
});

const store = useMenuManagementStore();

// disable button if at least one array inside menus is empty
const { buttonIsDisabled } = useSaveButtonIsDisabled(props.menus);
</script>
