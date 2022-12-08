import { defineStore } from "pinia";

export const useMerchantStore = defineStore("merchant", {
    state: () => {
        return {
            isMerchantsLoaded: false,
            merchants: [],
            merchant: [],
            merchantId: null,
            inviteEmail: "",
        };
    },
    actions: {
        currentMerchantEdit(id) {
            this.merchantId = id;
        },
    }
});
