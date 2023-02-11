<template>
  <TransitionRoot as="template" :show="this.isQrCodeVisible">
    <Dialog
      as="div"
      class="relative z-10"
      @close="this.isQrCodeVisible = false"
    >
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div
          class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
            >
              <div>
                <h1>Details:</h1>
                <div class="mb-2 bg-gray-400 text-sm text-white rounded-md p-3">
                  <p>1. Open "PupilPOS" on your terminal or SoftPOS device.</p>
                  <p>2. Scan the QR Code visible below.</p>
                  <p>3. Continue in the PupilPOS App.</p>
                </div>
              </div>
              <div class="flex justify-center items-center">
                <qrcode-vue
                  :value="this.QRKeys"
                  :size="300"
                  :level="'M'"
                ></qrcode-vue>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';
import QrcodeVue from 'qrcode.vue';
import { ExclamationTriangleIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { mapWritableState } from 'pinia';
import { useModalStore } from '@/stores/useModalStore';
import { useTerminalStore } from '@/stores/useTerminalStore';
export default {
  components: {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    ExclamationTriangleIcon,
    XMarkIcon,
    QrcodeVue,
  },
  computed: {
    ...mapWritableState(useModalStore, ['isQrCodeVisible']),
    ...mapWritableState(useTerminalStore, ['QRKeys']),
  },
};
</script>
