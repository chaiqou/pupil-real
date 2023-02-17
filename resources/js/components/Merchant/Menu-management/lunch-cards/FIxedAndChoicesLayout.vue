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
import { ref } from "vue";
import { onClickOutside } from "@vueuse/core";
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

// Close on click outside
const target = ref(null);

onClickOutside(target, () => {
  store.toggleFixedCard = false;
  store.toggleChoicesCard = false;
});

// disable button if at least one array inside menus is empty
const { buttonIsDisabled } = useSaveButtonIsDisabled(props.menus);
</script>
