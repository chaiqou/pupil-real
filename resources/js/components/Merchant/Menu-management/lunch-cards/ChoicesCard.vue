<template>
  <FIxedAndChoicesLayout :menus="menus" menu-type="Choices">
    <div
      v-for="(claimable, index) in store.parsedClaimables(claimables)"
      :key="index"
    >
      <h2 class="m-2 font-semibold text-gray-700">
        {{ claimable }}
      </h2>
      <button
        class="mb-4 mt-4 flex w-full justify-center rounded-md bg-indigo-700 px-4 py-2 text-base font-medium text-white"
        :class="{
          'bg-indigo-700': inputCounts[claimable]?.length < 5,
          'cursor-none bg-red-500': inputCounts[claimable]?.length >= 5,
        }"
        @click="onClickAddInput(claimable)"
      >
        {{
          inputCounts[claimable]?.length < 5
            ? $t("message.choices_add_option")
            : `${$t("message.choices_can_not_add_more_option")} ${claimable}`
        }}
      </button>
      <div
        class="flex items-center justify-center space-x-2 space-y-2"
        v-for="(input, index) in inputCounts[claimable]"
        :key="index"
      >
        <BaseInput
          v-model="menus[claimable][input]"
          :name="claimable"
          class="w-full"
        />
        <button
          class="basis-1/2 rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-center text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          @click="onClickRemoveInput(claimable, index)"
        >
          {{ $t("message.choices_remove_option") }}
        </button>
      </div>
    </div>
  </FIxedAndChoicesLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import BaseInput from "@/components/Ui/form-components/BaseInput.vue";
import FIxedAndChoicesLayout from "./FIxedAndChoicesLayout.vue";

const store = useMenuManagementStore();

const claimables = computed(() => store.claimables);

// Create Menus and inputCounts array
const menus = ref({});
const inputCounts = ref({});

onMounted(() => {
  JSON.parse(claimables.value).forEach((claimable) => {
    inputCounts.value[claimable] = [];
    menus.value[claimable] = [];
  });
});

// Add one input for specific lunch
function onClickAddInput(claimable) {
  if (inputCounts.value[claimable].length < 5) {
    inputCounts.value[claimable].push(inputCounts.value[claimable].length);
  }
}

// Remove input by its index
function onClickRemoveInput(claimable, index) {
  inputCounts.value[claimable].splice(index, 1);
  menus.value[claimable].splice(index, 1);
}
</script>
