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
            markedDays: [],
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

                switch (state) {
                    case this.active_range:
                        this.active_range = dates;
                        break;
                    case this.extras:
                        this.extras = dates;
                        break;
                    case this.holds:
                        this.holds = dates;
                        break;
                    case this.markedDays:
                        this.markedDays = dates;
                        break;
                }
            }
        },

        formatDateForHumans(date) {
            let formatedDate = [];

            for (let i = 0; i < date.length; i++) {
                formatedDate.push(format(new Date(date[i]), "yyyy-MM-dd"));
            }

            switch (date) {
                case this.active_range:
                    this.active_range = formatedDate;
                    break;
                case this.extras:
                    this.extras = formatedDate;
                    break;
                case this.holds:
                    this.holds = formatedDate;
                    break;
                case this.markedDays:
                    this.markedDays = formatedDate;
                    break;
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

        // addExtrasToActiveRange() {
        //     this.extras.map((extra) => {
        //         console.log(extra);
        //         if (!this.active_range.includes(extra)) {
        //             this.active_range.push(extra);
        //             console.log(this.active_range);
        //         }
        //     });
        // },

        // removeHoldsFromActiveRange() {
        //     this.active_range = this.active_range.filter(
        //         (date) => !this.holds.includes(date)
        //     );
        // },
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

        getMarkedDays() {
            this.middleRangeDates(this.markedDays);
            this.formatDateForHumans(this.markedDays);
        },
    },
});
