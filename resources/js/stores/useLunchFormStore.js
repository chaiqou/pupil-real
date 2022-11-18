import { defineStore } from "pinia";
import { format } from "date-fns";

export const useLunchFormStore = defineStore("lunch", {
    state: () => {
        return {
            title: "",
            description: "",
            period_length: "",
            tags: [],
            active_range: [],
            claimables: [],
            holds: [],
            extras: [],
            price_day: "",
            price_period: "",
        };
    },
    getters: {
        getLunchFormData() {
            return {
                title: this.title,
                description: this.description,
                period_length: this.period_length,
                tags: this.tags,
                active_range: `${format(
                    this.active_range[0],
                    "yyyy-MM-dd"
                )} - ${format(this.active_range[1], "yyyy-MM-dd")}`,
                claimables: this.claimables,
                holds: this.holds,
                extras: this.extras,
                price_day: this.price_day,
                price_period: this.price_period,
            };
        },
    },
});
