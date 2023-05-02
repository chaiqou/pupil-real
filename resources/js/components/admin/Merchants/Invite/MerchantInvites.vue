<template>
  <div
    @scroll="onScroll"
    :class="
      this.isInvitesLoaded && this.invites
        ? 'max-h-[17.5rem] overflow-hidden overflow-y-scroll shadow ring-1 ring-black ring-opacity-5 md:max-h-[19.3rem] md:rounded-lg'
        : 'overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg'
    "
  >
    <table
      class="min-w-full border-separate divide-y divide-gray-300"
      style="border-spacing: 0"
    >
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8"
          >
            {{ $t("message.email") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.state") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.school_code") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.send_date") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.update_date") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8"
          >
            <span class="sr-only">Actions</span>
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-if="this.isInvitesLoaded && !this.invites.length">
          <td class="bg-white" colspan="8">
            <InvitesNotFound invite="merchant"></InvitesNotFound>
          </td>
        </tr>

        <template v-if="this.isInvitesLoaded && this.invites.length">
          <tr v-for="invite in invites" :key="invite.id">
            <td
              class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900"
            >
              {{ invite.email }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ invite.state }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ invite.school.school_code }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ invite.created_at }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ invite.updated_at }}
            </td>
            <td
              class="relative whitespace-nowrap border-b border-gray-200 py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
            >
              <button class="text-indigo-600 hover:text-indigo-900">
                <dropdown-animated
                  role="admin"
                  inviteUserRole="merchant"
                  :items="['resend', 'delete']"
                  :invite-id="invite.id"
                >
                  {{ $t("message.actions") }}</dropdown-animated
                >
              </button>
            </td>
          </tr>
        </template>
        <template v-if="!this.isInvitesLoaded">
          <tr v-for="n in 7" :key="n">
            <td
              class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
            >
              <div class="h-2 animate-pulse rounded bg-slate-300"></div>
            </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
              <div class="h-2 animate-pulse rounded bg-slate-300"></div>
            </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
              <div class="h-2 animate-pulse rounded bg-slate-300"></div>
            </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
              <div class="h-2 animate-pulse rounded bg-slate-300"></div>
            </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
              <div class="h-2 animate-pulse rounded bg-slate-300"></div>
            </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
              <div class="h-2 animate-pulse rounded bg-slate-300"></div>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
  <merchant-edit-modal
    v-if="this.merchantId"
    :schoolId="this.schoolId"
  ></merchant-edit-modal>
</template>

<script>
import { mapActions, mapWritableState } from "pinia";
import { useMerchantStore } from "@/stores/useMerchantStore";
import InvitesNotFound from "@/components/not-found/InvitesNotFound.vue";
import MerchantEditModal from "@/components/admin/Merchants/MerchantEditModal.vue";
import { useModalStore } from "@/stores/useModalStore";
import { useInviteStore } from "@/stores/useInviteStore";
import DropdownAnimated from "@/components/Ui/Invites/DropdownAnimated.vue";

export default {
  components: {
    DropdownAnimated,
    InvitesNotFound,
    MerchantEditModal,
  },
  data() {
    return {
      currentPage: 1,
      lastPage: 2,
    };
  },
  props: {
    school: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...mapWritableState(useMerchantStore, [
      "isMerchantsLoaded",
      "merchants",
      "merchantId",
    ]),

    ...mapWritableState(useModalStore, ["isSchoolEditVisible"]),
    ...mapWritableState(useInviteStore, ["isInvitesLoaded", "invites"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideMerchantEdit"]),
    ...mapActions(useMerchantStore, ["currentMerchantEdit"]),
    handleGetMerchantInvitesRequest() {
      axios
        .get(
          `/api/admin/school/${this.school.id}/merchant-invites/?page=${this.currentPage}`,
        )
        .then((res) => {
          this.currentPage++;
          this.lastPage = res.data.meta.last_page;
          this.invites.push(...res.data.data);
          this.invites.map((item) => {
            item.created_at = item.created_at
              .substring(0, 16)
              .replaceAll("T", " ");
            item.updated_at = item.updated_at
              .substring(0, 16)
              .replaceAll("T", " ");
          });
        })
        .finally(() => (this.isInvitesLoaded = true));
    },
    onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
      if (scrollTop + clientHeight >= scrollHeight) {
        if (this.currentPage > this.lastPage) {
          return;
        }
        this.handleGetMerchantInvitesRequest();
      }
    },
  },
  created() {
    this.handleGetMerchantInvitesRequest();
  },
};
</script>
