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
        async middleRangeDates(name, state) {
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

                switch (name) {
                    case "active_range":
                        this.active_range = dates;
                        break;
                    case "extras":
                        this.extras = dates;
                        break;
                    case "holds":
                        this.holds = dates;
                        break;
                    case "marked_days":
                        this.markedDays = dates;
                        break;
                }
            }
        },

        formatDateForHumans(name, date) {
            let formatedDate = [];

            for (let i = 0; i < date.length; i++) {
                formatedDate.push(format(new Date(date[i]), "yyyy-MM-dd"));
            }

            switch (name) {
                case "active_range":
                    this.active_range = formatedDate;
                    break;
                case "extras":
                    this.extras = formatedDate;
                    break;
                case "holds":
                    this.holds = formatedDate;
                    break;
                case "marked_days":
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

        addExtrasToMarkedDays() {
            this.getMarkedDays;
            console.log("1", this.markedDays);
            let days = [];
            this.extras.map((extra) => {
                if (!this.markedDays.includes(extra)) {
                    this.markedDays.push(...extra);
                    console.log("2", this.markedDays);
                }
            });
        },

        removeHoldsFromMarkedDays() {
            this.markedDays = this.markedDays.filter(
                (date) => !this.holds.includes(date)
            );
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
            this.middleRangeDates("active_range", this.active_range);
            this.formatDateForHumans("active_range", this.active_range);
            this.middleRangeDates("extras", this.extras);
            this.formatDateForHumans("extras", this.extras);
            this.middleRangeDates("holds", this.holds);
            this.formatDateForHumans("holds", this.holds);
        },

        getMarkedDays() {
            this.middleRangeDates("marked_days", this.markedDays);
            this.formatDateForHumans("marked_days", this.markedDays);
        },
    },
});
