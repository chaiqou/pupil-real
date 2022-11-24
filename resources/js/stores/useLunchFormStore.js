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
    actions: {
        async loopThroughActiveRange() {
            let active_range = [];

            for (let i = 0; i < this.active_range.length; i++) {
                active_range.push(
                    format(new Date(this.active_range[i]), "yyyy-MM-dd")
                );
            }

            this.active_range = active_range;
        },
    },
    getters: {
        getLunchFormData() {
            return {
                title: this.title,
                description: this.description,
                period_length: this.period_length,
                tags: this.tags,
                active_range: this.active_range,
                claimables: this.claimables,
                holds: this.holds,
                extras: this.extras,
                price_day: this.price_day,
                price_period: this.price_period,
            };
        },
    },
});
