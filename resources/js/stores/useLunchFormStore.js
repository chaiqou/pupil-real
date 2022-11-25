import { defineStore } from "pinia";
import { format } from "date-fns";

export const useLunchFormStore = defineStore("lunch", {
    state: () => {
        return {
            title: "",
            description: "",
            period_length: "",
            weekdays: [],
            active_range: [],
            claimables: [],
            holds: [],
            extras: [],
            price_day: "",
            price_period: "",
            disabledDaysForHolds: [],
            disabledDaysForExtras: [],
        };
    },
    actions: {
        getMiddleDatesForActiveRange() {
            let full_dates = [];
            let startDate = new Date(this.active_range[0]);
            let endDate = new Date(this.active_range[1]);

            while (startDate <= endDate) {
                full_dates.push(new Date(startDate));
                startDate.setDate(startDate.getDate() + 1);
            }
            this.active_range = full_dates;
        },

        async formatActiveRangeDate() {
            let active_range = [];

            for (let i = 0; i < this.active_range.length; i++) {
                active_range.push(
                    format(new Date(this.active_range[i]), "yyyy-MM-dd")
                );
            }

            this.active_range = active_range;
        },

        getMiddleDatesForExtras() {
            let full_dates = [];
            let startDate = "";
            let endDate = "";

            if (this.extras.length > 0) {
                this.extras.map((extra) => {
                    startDate = new Date(extra[0]);
                    endDate = new Date(extra[1]);
                });

                while (startDate <= endDate) {
                    full_dates.push(new Date(startDate));
                    startDate.setDate(startDate.getDate() + 1);
                }
                this.extras = full_dates;
            }
        },

        async formatExtrasDate() {
            let formatted_extras = [];

            for (let i = 0; i < this.extras.length; i++) {
                formatted_extras.push(
                    format(new Date(this.extras[i]), "yyyy-MM-dd")
                );
            }

            this.extras = formatted_extras;
        },

        getMiddleDatesForHolds() {
            let full_dates = [];
            let startDate = "";
            let endDate = "";

            if (this.holds.length > 0) {
                this.holds.map((hold) => {
                    startDate = new Date(hold[0]);
                    endDate = new Date(hold[1]);
                });

                while (startDate <= endDate) {
                    full_dates.push(new Date(startDate));
                    startDate.setDate(startDate.getDate() + 1);
                }
                this.holds = full_dates;
            }
        },

        async formatHoldsDate() {
            let formatted_holds = [];

            for (let i = 0; i < this.holds.length; i++) {
                formatted_holds.push(
                    format(new Date(this.holds[i]), "yyyy-MM-dd")
                );
            }

            this.holds = formatted_holds;
        },

        getDatesInRange(startDate, endDate) {
            const date = new Date(startDate.getTime());

            const dates = [];

            while (date <= endDate) {
                dates.push(new Date(date));
                date.setDate(date.getDate() + 1);
            }

            return dates;
        },
    },
    getters: {
        getLunchFormData() {
            return {
                title: this.title,
                description: this.description,
                period_length: this.period_length,
                weekdays: this.weekdays,
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
