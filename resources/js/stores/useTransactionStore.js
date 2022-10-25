import { defineStore } from "pinia";

export const useTransactionStore = defineStore("transaction", {
    state: () => {
        return {
            isTransactionsLoaded: false,
        };
    },
});
