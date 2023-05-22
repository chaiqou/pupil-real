<template>
  <div class="flex w-full flex-col items-center justify-center py-10">
    <BuildingOffice2Icon class="h-10 w-10"></BuildingOffice2Icon>
    <h3 class="mt-2 text-sm font-medium text-gray-900">
      There is no schools registered at the moment.
    </h3>
  </div>
</template>

<script>
import { BuildingOffice2Icon } from "@heroicons/vue/24/outline";

export default {
  components: {
    BuildingOffice2Icon,
  },
};
</script>
