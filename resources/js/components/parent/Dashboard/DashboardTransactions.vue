<template>
  <table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
      <tr>
        <th
          scope="col"
          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
        >
          Name
        </th>
        <th
          scope="col"
          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
        >
          Amount
        </th>
        <th
          scope="col"
          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
        >
          Type
        </th>
        <th
          scope="col"
          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
        >
          Date
        </th>
        <th
          scope="col"
          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
        >
          Merchant
        </th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
      <tr v-if="this.isTransactionsLoaded && !this.transactions.length">
        <td class="bg-white" colspan="5">
          <TransactionsNotFound role="school"></TransactionsNotFound>
        </td>
      </tr>
      <tr
        v-if="this.isTransactionsLoaded && this.transactions.length"
        v-for="transaction in transactions"
        :key="transaction.id"
      >
        <td
          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
        >
          {{ transaction.student.first_name }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          {{ transaction.amount }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          {{ transaction.transaction_type }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          {{ transaction.transaction_date }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          {{ transaction.merchant.merchant_nick }}
        </td>
        <td
          class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
        ></td>
      </tr>
      <tr v-if="!this.isTransactionsLoaded" v-for="n in 7">
        <td
          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
        >
          <div class="h-2 bg-slate-300 rounded animate-pulse"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 bg-slate-300 rounded animate-pulse"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 bg-slate-300 rounded animate-pulse"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 bg-slate-300 rounded animate-pulse"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 bg-slate-300 rounded animate-pulse"></div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import TransactionsNotFound from '@/components/not-found/TransactionsNotFound.vue';
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

  props: {
    studentId: {
      type: Number,
      required: true,
    },
  },
  methods: {
    handleGetLastFiveTransactions() {
      axios
        .get(`/api/parent/${this.studentId}/last-transactions`)
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
