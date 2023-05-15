<template>
  <div
    class="m-64 mt-32 flex flex-col items-center justify-center rounded-md border-4 border-dashed p-8"
  >
    <ExclamationCircleIcon
      class="h-12 w-12 text-red-500"
    ></ExclamationCircleIcon>
    <h3 class="mt-2 text-sm font-semibold text-gray-900">
      You are on admin Dashboard
    </h3>
    <p class="mt-1 text-sm text-gray-500">
      Be careful, you are on admin dashboard.
    </p>
    <div class="mt-6">
      <button
        type="button"
        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
      >
        Admin Panel
      </button>
    </div>
  </div>
</template>

<script>
import { ExclamationCircleIcon } from "@heroicons/vue/24/solid";

export default {
  components: {
    ExclamationCircleIcon,
  },
};
</script>
