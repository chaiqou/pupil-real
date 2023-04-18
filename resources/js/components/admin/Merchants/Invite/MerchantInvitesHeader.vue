<template>
  <div class="mt-32 px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="flex items-end justify-between sm:flex-auto">
        <div>
          <h1 class="text-xl font-semibold text-gray-900">
              {{ $t('message.all_merchant_invites_belonging_to_school') }} #{{
              this.school.short_name
            }}
          </h1>
          <p class="mt-2 text-sm text-gray-700">
              {{$t('message.a_list_of_all_the_merchant_invites_including_their_email_invite_state_and_send_date_update_date')}}.
          </p>
        </div>
        <span
          @click="showHideInviteMerchant()"
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
              d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
            />
          </svg>
          <p class="ml-1.5">{{$t('message.invite_merchants')}}</p>
        </span>
      </div>
    </div>
  </div>
  <invite-merchant-modal :school-id="this.school.id"></invite-merchant-modal>
</template>

<script>
import { mapWritableState, mapActions } from "pinia";
import { useModalStore } from "@/stores/useModalStore";
import InviteMerchantModal from "@/components/admin/Merchants/Invite/InviteMerchantModal.vue";

export default {
  components: {
    InviteMerchantModal,
  },
  props: {
    school: {
      required: true,
      type: Object,
    },
  },
  computed: {
    ...mapWritableState(useModalStore, ["isInviteMerchantVisible"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideInviteMerchant"]),
  },
};
</script>
