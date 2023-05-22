import { defineStore } from "pinia";

export const useTransactionStore = defineStore("transaction", {
  state: () => {
    return {
      isTransactionsLoaded: false,
      isSlideOverOpen: false,
      transactions: [],
      transaction: [],
    };
  },
  actions: {
    showHideSlideOver() {
      this.isSlideOverOpen = !this.isSlideOverOpen;
    },
    currentTransactionDetails(id) {
      this.transaction = this.transactions.find((item) => item.id === id);
    },
  },
});
