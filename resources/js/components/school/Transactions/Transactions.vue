<template>
  <div
    @scroll="onScroll"
    :class="
      this.isTransactionsLoaded && this.transactions
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
            {{ $t("message.name") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.amount") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.type") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.date") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.merchant") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8"
          >
            <span class="sr-only">Details</span>
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr v-if="this.isTransactionsLoaded && !this.transactions.length">
          <td class="bg-white" colspan="6">
            <TransactionsNotFound role="school"></TransactionsNotFound>
          </td>
        </tr>
        <template v-if="this.isTransactionsLoaded && this.transactions.length">
          <tr v-for="transaction in transactions" :key="transaction.id">
            <td
              class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
            >
              {{ transaction.student.first_name }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ transaction.amount }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ transaction.transaction_type }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ transaction.transaction_date }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ transaction.merchant.merchant_nick }}
            </td>
            <td
              class="relative whitespace-nowrap border-b border-gray-200 py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
            >
              <button
                @click="
                  showHideSlideOver();
                  currentTransactionDetails(transaction.id);
                "
                class="text-indigo-600 hover:text-indigo-900"
              >
                {{ $t("message.details") }}
              </button>
            </td>
          </tr>
        </template>
        <template v-if="!this.isTransactionsLoaded">
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
    <transaction-slide-over></transaction-slide-over>
  </div>
</template>

<script>
import { mapActions, mapWritableState } from "pinia";
import TransactionsNotFound from "@/components/not-found/TransactionsNotFound.vue";
import TransactionSlideOver from "@/components/school/Transactions/TransactionSlideOver.vue";
import { useTransactionStore } from "@/stores/useTransactionStore";

export default {
  components: {
    TransactionsNotFound,
    TransactionSlideOver,
  },
  data() {
    return {
      currentPage: 1,
      lastPage: 2,
    };
  },
  props: {
    student: {
      type: Object,
      required: true,
    },
    schoolId: {
      type: Number,
      required: true,
    },
  },
  computed: {
    ...mapWritableState(useTransactionStore, [
      "isTransactionsLoaded",
      "isSlideOverOpen",
      "transactions",
    ]),
  },
  methods: {
    ...mapActions(useTransactionStore, [
      "showHideSlideOver",
      "currentTransactionDetails",
    ]),
    handleGetTransactionsRequest() {
      axios
        .get(
          `/api/school/${this.schoolId}/transactions?page=${this.currentPage}`,
        )
        .then((res) => {
          this.currentPage++;
          this.lastPage = res.data.meta.last_page;
          this.transactions.push(...res.data.data);
        })
        .finally(() => (this.isTransactionsLoaded = true));
    },

    onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
      if (scrollTop + clientHeight >= scrollHeight) {
        if (this.currentPage > this.lastPage) {
          return;
        }
        this.handleGetStudentRequest();
      }
    },
  },
  created() {
    this.handleGetTransactionsRequest();
  },
};
</script>
