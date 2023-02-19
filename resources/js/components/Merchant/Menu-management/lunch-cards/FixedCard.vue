<template>
  <FIxedAndChoicesLayout :menus="menus" menu-type="Fixed">
    <div
      v-for="claimable in store.parsedClaimables(claimables)"
      :key="claimable"
    >
      <h2 class="m-2 font-semibold text-gray-700">
        {{ claimable }}
      </h2>
      <BaseInput v-model="menus[claimable]" :name="claimable" class="w-full" />
    </div>
  </FIxedAndChoicesLayout>
</template>

<script setup>
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { ref, onMounted, computed } from "vue";
import BaseInput from "@/components/Ui/form-components/BaseInput.vue";
import FIxedAndChoicesLayout from "./FIxedAndChoicesLayout.vue";

const store = useMenuManagementStore();

const menus = ref({});

// Create menus array based on claimables

const claimables = computed(() => store.claimables);

onMounted(() => {
  JSON.parse(claimables.value).forEach((claimable) => {
    menus.value[claimable] = [];
  });
});
</script>
