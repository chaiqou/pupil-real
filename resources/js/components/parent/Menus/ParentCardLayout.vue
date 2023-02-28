<template>
  <div
    class="fixed z-50 flex min-h-screen w-screen flex-col items-center justify-center bg-black/50"
  >
    <div
      ref="target"
      class="absolute w-full max-w-lg rounded-lg bg-white px-6 py-10 shadow-2xl md:right-1/3 xl:right-[45%]"
    >
      <fieldset>
        <div class="relative -space-y-px rounded-md bg-white">
          <slot></slot>
        </div>
      </fieldset>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { onClickOutside } from "@vueuse/core";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";

const store = useMenuManagementStore();

const target = ref(null);

onClickOutside(target, () => {
  store.toggleFixedCard = false;
  store.toggleChoicesCard = false;
});
</script>
