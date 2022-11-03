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
                dateRange: this.dateRange,
                period: this.period,
                holds: this.holds,
                extras: this.extras,
                tags: this.tags,
                priceDay: this.priceDay,
                pricePeriod: this.pricePeriod,
                radioDay: this.radioDay,
            };
        },
    },
});
