<template>
  <div v-if="isVisible" class="mt-4 rounded-md bg-green-50 p-4">
    <div class="flex">
      <div class="flex-shrink-0">
        <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
      </div>
      <div class="ml-3">
        <p class="text-sm font-medium text-green-800">
          {{ toasterMessage }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { CheckCircleIcon } from '@heroicons/vue/20/solid';
import { ref } from 'vue';

const isVisible = ref(false);
const toasterMessage = ref('');

const showToaster = (message) => {
  toasterMessage.value = message;
  isVisible.value = true;
  setTimeout(() => {
    isVisible.value = false;
  }, 3000);
};

defineExpose({
  showToaster,
});
</script>
