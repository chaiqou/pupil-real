<template>
  <div
    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
  >
    <table class="min-w-full divide-y divide-gray-300">
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
          >
            {{ $t("message.name") }}
          </th>
          <th
            scope="col"
            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
          >
            {{ $t("message.amount") }}
          </th>
          <th
            scope="col"
            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
          >
            {{ $t("message.merchant") }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-if="this.isTransactionsLoaded && !this.transactions.length">
          <td class="bg-white" colspan="5">
            <TransactionsNotFound role="school"></TransactionsNotFound>
          </td>
        </tr>
        <template v-if="this.isTransactionsLoaded && this.transactions.length">
          <tr v-for="transaction in transactions" :key="transaction.id">
            <td
              class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
            >
              {{ transaction.student.first_name }}
              <p class="text-[11px] text-gray-400">
                {{ transaction.transaction_date }}
              </p>
            </td>
            <td
              class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900"
            >
              {{ transaction.amount || "none" }}
              <p class="text-[11px] text-gray-400">
                {{ transaction.transaction_type }}
              </p>
            </td>
            <td
              class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900"
            >
              {{ transaction.merchant.merchant_nick }}
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
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
import TransactionsNotFound from "@/components/not-found/TransactionsNotFound.vue";

export default {
  components: {
    TransactionsNotFound,
  },
  data() {
    return {
      transactions: [],
      isTransactionsLoaded: false,
    };
  },
  methods: {
    handleGetLastFiveTransactions() {
      axios
        .get(`/api/school/last-transactions?page=${this.currentPage}`)
        .then((res) => {
          this.transactions = res.data.data;
        })
        .finally(() => (this.isTransactionsLoaded = true));
    },
  },
  created() {
    this.handleGetLastFiveTransactions();
  },
};
</script>
