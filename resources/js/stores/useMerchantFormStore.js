import { defineStore } from "pinia";

export const useMerchantFormStore = defineStore("merchantForm", {
    state: () => {
        return {
            title: "",
            description: "",
            dateRange: [],
            period: null,
            holds: [],
            extras: [],
            tags: [],
            priceDay: null,
            pricePeriod: null,
        };
    },

    actions: {
        addTag(tag) {
            this.tags.push(tag);
        },
        removeTag(index) {
            this.tags.splice(index, 1);
        },
    },
});
