<template>
  <div
    @scroll="onScroll"
    :class="
      this.isMerchantsLoaded && this.merchants
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
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.nickname") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.company_legal_name") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.details") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.activated") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 backdrop-blur backdrop-filter"
          >
            <span class="sr-only">Edit</span>
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-if="this.isMerchantsLoaded && !this.merchants.length">
          <td class="bg-white" colspan="8">
            <MerchantsNotFound></MerchantsNotFound>
          </td>
        </tr>
        <template v-if="this.isMerchantsLoaded && this.merchants.length">
          <tr v-for="merchant in merchants" :key="merchant.id">
            <td
              class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900"
            >
              {{ merchant.merchant_nick }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ merchant.company_legal_name }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ merchant.company_details }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ merchant.activated }}
            </td>
            <td
              class="relative whitespace-nowrap border-b border-gray-200 text-right text-sm font-medium"
            >
              <button
                @click="
                  showHideMerchantEdit();
                  currentMerchantEdit(merchant.id);
                "
                class="pr-6 text-indigo-600 hover:text-indigo-900"
              >
                {{ $t("message.edit") }}
              </button>
            </td>
          </tr>
        </template>
        <template v-if="!this.isMerchantsLoaded">
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
import MerchantsNotFound from "@/components/not-found/MerchantsNotFound.vue";
import MerchantEditModal from "@/components/admin/Merchants/MerchantEditModal.vue";
import { useModalStore } from "@/stores/useModalStore";

export default {
  components: {
    MerchantsNotFound,
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
  },
  methods: {
    ...mapActions(useModalStore, ["showHideMerchantEdit"]),
    ...mapActions(useMerchantStore, ["currentMerchantEdit"]),
    handleGetMerchantsRequest() {
      axios
        .get(
          `/api/admin/school/${this.school.id}/merchants/?page=${this.currentPage}`,
        )
        .then((res) => {
          this.currentPage++;
          this.lastPage = res.data.meta.last_page;
          this.merchants.push(...res.data.data);
        })
        .finally(() => (this.isMerchantsLoaded = true));
    },
    onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
      if (scrollTop + clientHeight >= scrollHeight) {
        if (this.currentPage > this.lastPage) {
          return;
        }
        this.handleGetMerchantsRequest();
      }
    },
  },
  created() {
    this.handleGetMerchantsRequest();
  },
};
</script>
