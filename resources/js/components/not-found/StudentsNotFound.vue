<template>
  <div class="flex w-full flex-col items-center justify-center py-10">
    <UsersIcon class="h-10 w-10"></UsersIcon>
    <h3 class="mt-2 text-sm font-medium text-gray-900">
        {{$t('message.no_students_available')}}.
    </h3>
  </div>
</template>

<script>
import { UsersIcon } from "@heroicons/vue/24/outline";

export default {
  components: {
    UsersIcon,
  },
};
</script>
