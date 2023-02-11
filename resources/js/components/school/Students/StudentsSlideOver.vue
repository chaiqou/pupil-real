<template>
  <TransitionRoot as="template" :show="this.isSlideOverOpen">
    <Dialog
      as="div"
      class="relative z-10"
      @close="this.isSlideOverOpen = false"
    >
      <div class="fixed inset-0" />

      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div
            class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10"
          >
            <TransitionChild
              as="template"
              enter="transform transition ease-in-out duration-500 sm:duration-700"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transform transition ease-in-out duration-500 sm:duration-700"
              leave-from="translate-x-0"
              leave-to="translate-x-full"
            >
              <DialogPanel class="pointer-events-auto w-screen max-w-md">
                <div
                  class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl"
                >
                  <div class="px-4 sm:px-6">
                    <div class="flex items-start justify-between">
                      <DialogTitle class="text-lg font-medium text-gray-900"
                        >Student #{{ this.student.id }} Details</DialogTitle
                      >
                      <div class="ml-3 flex h-7 items-center">
                        <button
                          @click="showHideSlideOver()"
                          type="button"
                          class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                          <span class="sr-only">Close panel</span>
                          <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="relative mt-6 flex-1 px-4 sm:px-6">
                    <!-- Replace with your content -->
                    <div class="flex">
                      <p class="font-bold">First name:</p>
                      <p class="ml-3">
                        {{ this.student.first_name }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">Last name:</p>
                      <p class="ml-3">
                        {{ this.student.last_name }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">Middle name:</p>
                      <p class="ml-3">
                        {{ this.student.middle_name || 'Not given' }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">Card number:</p>
                      <p class="ml-3">
                        {{ this.student.card_number }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">User information:</p>
                      <p class="ml-3">
                        {{ this.student.user_information }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">Balances:</p>
                      <p class="ml-3">
                        {{ this.student.balances }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">Parent:</p>
                      <p class="ml-3">
                        {{ this.student.user }}
                      </p>
                    </div>
                    <!-- /End replace -->
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
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
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useStudentStore } from '@/stores/useStudentStore';
import { mapActions, mapWritableState } from 'pinia';

export default {
  components: {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    XMarkIcon,
  },
  computed: {
    ...mapWritableState(useStudentStore, ['isSlideOverOpen', 'student']),
  },
  methods: {
    ...mapActions(useStudentStore, ['showHideSlideOver']),
  },
};
</script>
