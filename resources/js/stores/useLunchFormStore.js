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

        // Formatting date for human readable code

        formatDateForHumans(date) {
            let formatedDate = [];

            for (let i = 0; i < date.length; i++) {
                formatedDate.push(format(new Date(date[i]), "yyyy-MM-dd"));
            }

            if (date === this.active_range) {
                this.active_range = formatedDate;
            }

            if (date === this.extras) {
                this.extras = formatedDate;
            }

            if (date === this.holds) {
                this.holds = formatedDate;
            }
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
        getCalculatedActiveRange() {
            this.getMiddleDatesForActiveRange();
            this.formatDateForHumans(this.active_range);
            this.getMiddleDatesForExtras();
            this.formatDateForHumans(this.extras);
            this.getMiddleDatesForHolds();
            this.formatDateForHumans(this.holds);
        },
    },
});
