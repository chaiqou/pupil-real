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
            disabled_extra_days: [],
            disabled_hold_days: [],
            add_marked_extras: [],
            remove_marked_holds: [],
            marked_days: [],
            toggle_based_weekdays: [],
        };
    },

    actions: {
        // whith this method we can find start and end date of the period

        async findMiddleRangeDates(name, state) {
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
                        this.marked_days = [...dates];
                        break;
                    case "remove_holds":
                        this.formatDateForHumans("remove_holds", dates);
                        break;
                    case "add_extras":
                        this.formatDateForHumans("add_extras", dates);
                        break;
                    case "toggle_based_weekdays":
                        this.toggle_based_weekdays = dates;
                        break;
                }
            }
        },

        // Format date for humans e.g  2021-05-01

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
                    this.marked_days = formatedDate;
                    break;
                case "add_extras":
                    this.add_marked_extras = [
                        ...this.add_marked_extras,
                        ...formatedDate,
                    ];
                    break;
                case "remove_holds":
                    this.remove_marked_holds = formatedDate;
                    break;
                case "disabled_extra_days":
                    this.disabled_extra_days = formatedDate;
                    break;
                case "disabled_hold_days":
                    this.disabled_hold_days = formatedDate;
            }
        },

        // disabled days for holds and extras

        disabledDaysDate(startDate, endDate) {
            const date = new Date(startDate.getTime());
            const dates = [];

            while (date <= endDate) {
                dates.push(new Date(date));
                date.setDate(date.getDate() + 1);
            }

            return dates;
        },

        removeDaysFromMarkedDays(state) {
            let dates = [];
            let startDate = new Date(state[0]);
            let endDate = new Date(state[1]);

            while (startDate <= endDate) {
                dates.push(format(new Date(startDate), "yyyy-MM-dd"));
                startDate.setDate(startDate.getDate() + 1);
            }

            let formatedDate = [];

            for (let i = 0; i < this.toggle_based_weekdays.length; i++) {
                formatedDate.push(
                    format(
                        new Date(this.toggle_based_weekdays[i]),
                        "yyyy-MM-dd"
                    )
                );
            }

            let filteredMarkedDays = this.marked_days.filter(
                (x) => !dates.includes(x)
            );

            const sameValues = formatedDate.filter(
                (value) => !filteredMarkedDays.includes(value)
            );

            let concatArrays = [...filteredMarkedDays, ...sameValues];

            this.marked_days = concatArrays;
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
        getFullLengthOfDays() {
            this.findMiddleRangeDates("active_range", this.active_range);
            this.formatDateForHumans("active_range", this.active_range);
            this.findMiddleRangeDates("extras", this.extras);
            this.formatDateForHumans("extras", this.extras);
            this.findMiddleRangeDates("holds", this.holds);
            this.formatDateForHumans("holds", this.holds);
        },

        getMarkedDays() {
            this.findMiddleRangeDates("marked_days", this.marked_days);
            this.formatDateForHumans("marked_days", this.marked_days);
        },

        // add Extras to marked days

        addExtrasToMarkedDays() {
            this.findMiddleRangeDates("add_extras", this.extras);
            let deUnique = this.add_marked_extras;
            let uniqueValues = new Set(deUnique);
            deUnique = Array.from(uniqueValues);

            this.remove_marked_holds.map((hold) => {
                if (deUnique.includes(hold)) {
                    deUnique.splice(deUnique.indexOf(hold), 1);
                }
            });

            deUnique.map((extra) => {
                if (!this.marked_days.includes(extra)) {
                    this.marked_days.push(extra);
                }
            });
        },

        // remove holds from marked days

        removeHoldsFromMarkedDays() {
            this.findMiddleRangeDates("remove_holds", this.holds);
            let daysToDelete = new Set(this.remove_marked_holds);

            this.add_marked_extras.map((extra) => {
                if (daysToDelete.has(extra)) {
                    daysToDelete.delete(extra);
                }
            });

            const removedDaysArray = this.marked_days.filter((day) => {
                return !daysToDelete.has(day);
            });

            this.marked_days = removedDaysArray;
        },
    },
});
