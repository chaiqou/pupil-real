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
            radioDay: null,
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
    getters: {
        getMerchantData() {
            return {
                title: this.title,
                description: this.description,
                active_range: this.dateRange,
                period_length: this.period,
                claimables: this.radioDay,
                holds: this.holds,
                extras: this.extras,
                tags: this.tags,
                price_day: this.priceDay,
                price_period: this.pricePeriod,
            };
        },
    },
});
