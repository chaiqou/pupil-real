<template>
  <TransitionRoot as="template" :show="this.isSlideOverOpen">
    <DialogComponent
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
                        >Transaction #{{
                          this.transaction.id
                        }}
                        Details</DialogTitle
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
                      <p class="font-bold">{{ $t("message.first_name") }}:</p>
                      <p class="ml-3">
                        {{ this.transaction.student.first_name }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">{{ $t("message.last_name") }}:</p>
                      <p class="ml-3">
                        {{ this.transaction.student.last_name }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">{{ $t("message.amount") }}:</p>
                      <p class="ml-3">
                        {{ this.transaction.amount }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">
                        {{ $t("message.transaction_type") }}:
                      </p>
                      <p class="ml-3">
                        {{ this.transaction.transaction_type }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">
                        {{ $t("message.transaction_date") }}:
                      </p>
                      <p class="ml-3">
                        {{ this.transaction.transaction_date }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">
                        {{ $t("message.merchant_nickname") }}:
                      </p>
                      <p class="ml-3">
                        {{ this.transaction.merchant.merchant_nick }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">{{ $t("message.pending") }}:</p>
                      <p class="ml-3">
                        {{ this.transaction.pending }}
                      </p>
                    </div>

                    <div class="flex">
                      <p class="font-bold">{{ $t("message.comment") }}:</p>
                      <p class="ml-3">
                        {{ this.transaction.comment }}
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
    </DialogComponent>
  </TransitionRoot>
</template>

<script>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { mapActions, mapWritableState } from "pinia";
import { useTransactionStore } from "@/stores/useTransactionStore";

export default {
  components: {
    DialogComponent: Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    XMarkIcon,
  },
  computed: {
    ...mapWritableState(useTransactionStore, [
      "isSlideOverOpen",
      "transaction",
    ]),
  },
  methods: {
    ...mapActions(useTransactionStore, ["showHideSlideOver"]),
  },
};
</script>
