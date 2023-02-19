<template>
  <div class="mt-32 px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="flex items-end justify-between sm:flex-auto">
        <div>
          <h1 class="text-xl font-semibold text-gray-900">All Terminals</h1>
          <p class="mt-2 text-sm text-gray-700">
            A list of all terminals depend to your school including terminal
            name, serial number, private and public keys.
          </p>
        </div>
        <span
          @click="showHideTerminalCreate()"
          class="hidden cursor-pointer items-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 md:flex"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 6v12m6-6H6"
            />
          </svg>
          <p class="ml-1.5">Create a new terminal</p>
        </span>
      </div>
    </div>
  </div>
  <terminal-create-modal></terminal-create-modal>
  <qr-code-modal></qr-code-modal>
</template>

<script>
import { mapWritableState, mapActions } from 'pinia';
import { useModalStore } from '@/stores/useModalStore';
import TerminalCreateModal from '@/components/school/Terminals/TerminalCreateModal.vue';
import QrCodeModal from '@/components/school/Terminals/QrCodeModal.vue';

export default {
  components: {
    QrCodeModal,
    TerminalCreateModal,
  },
  computed: {
    ...mapWritableState(useModalStore, ['isTerminalCreateVisible']),
  },
  methods: {
    ...mapActions(useModalStore, ['showHideTerminalCreate']),
  },
};
</script>
