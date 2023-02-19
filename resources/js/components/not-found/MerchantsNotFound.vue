<template>
  <div class="flex w-full flex-col items-center justify-center py-10">
    <BuildingStorefrontIcon class="h-10 w-10"></BuildingStorefrontIcon>
    <h3 class="mt-2 text-sm font-medium text-gray-900">
      This school does not have any merchants, check invites if they haven't
      onboarding yet
    </h3>
  </div>
</template>

<script>
import { BuildingStorefrontIcon } from "@heroicons/vue/24/outline";
export default {
  components: {
    BuildingStorefrontIcon,
  },
};
</script>
