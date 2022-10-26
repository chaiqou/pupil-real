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
        showHideSlideOver(id) {
            this.isSlideOverOpen = !this.isSlideOverOpen;
            this.transaction = this.transactions.find(item => item.id === id)
        }
    }
});
