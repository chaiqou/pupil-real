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
        async middleRangeDates(state) {
            let dates = [];
            let startDate = "";
            let endDate = "";

            if (state.length > 0) {
                state.map((extra) => {
                    startDate = new Date(extra[0]);
                    endDate = new Date(extra[1]);
                });

                while (startDate <= endDate) {
                    dates.push(new Date(startDate));
                    startDate.setDate(startDate.getDate() + 1);
                }

                if (state === this.extras) {
                    this.extras = dates;
                }

                if (state === this.holds) {
                    this.holds = dates;
                }

                if (state === this.active_range) {
                    this.active_range = dates;
                }
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

        disabledDaysDate(startDate, endDate) {
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
            this.middleRangeDates(this.active_range);
            this.formatDateForHumans(this.active_range);
            this.middleRangeDates(this.extras);
            this.formatDateForHumans(this.extras);
            this.middleRangeDates(this.holds);
            this.formatDateForHumans(this.holds);
        },
    },
});
