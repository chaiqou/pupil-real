import { defineStore } from "pinia";

export const useMerchantFormStore = defineStore("merchantForm", {
    state: () => {
        return {
            radioDays: "",
            dateRange: "",
        };
    },
});
