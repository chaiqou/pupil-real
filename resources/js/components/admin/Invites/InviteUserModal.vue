<template>
  <TransitionRoot as="template" :show="this.isInviteUserVisible">
    <DialogComponent
      as="div"
      class="relative z-10"
      @close="this.isInviteUserVisible = false"
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
              <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button
                  type="button"
                  class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                  @click="this.isInviteUserVisible = false"
                >
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <div class="absolute top-0 left-0 hidden pt-4 pl-4 sm:block">
                <p>
                  {{ $t("message.invite_users_by_their_email_addresses") }}.
                </p>
              </div>
              <div>
                <invites-multiselect></invites-multiselect>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </DialogComponent>
  </TransitionRoot>
</template>

<script>
import {
  Dialog as DialogComponent,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { mapActions, mapWritableState } from "pinia";
import { useModalStore } from "@/stores/useModalStore";
import InvitesMultiselect from "@/components/admin/Invites/InvitesMultiselect.vue";

export default {
  components: {
    DialogComponent,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
    XMarkIcon,
    InvitesMultiselect,
  },
  computed: {
    ...mapWritableState(useModalStore, ["isInviteUserVisible"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideInviteUser"]),
  },
};
</script>
