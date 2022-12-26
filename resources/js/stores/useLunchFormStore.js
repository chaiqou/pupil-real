import { defineStore } from "pinia";
import { format, eachDayOfInterval, parseISO } from "date-fns";

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
            price_period: "",
            disabled_extra_days: [],
            disabled_hold_days: [],
            add_marked_extras: [],
            remove_marked_holds: [],
            marked_days: [],
            each_active_range_day: [],
            lunches: [],
            currentLunchEditId: "",
            buffer_time: null,
            vat: "",
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
                    case "remove_holds":
                        this.formatDateForHumans("remove_holds", dates);
                        break;
                    case "add_extras":
                        this.formatDateForHumans("add_extras", dates);
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
                case "each_active_range_day":
                    this.each_active_range_day = formatedDate;
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
            let removed_range_days = [];
            let startDate = new Date(state[0]);
            let endDate = new Date(state[1]);

            while (startDate <= endDate) {
                removed_range_days.push(
                    format(new Date(startDate), "yyyy-MM-dd")
                );
                startDate.setDate(startDate.getDate() + 1);
            }

            let eachDay = eachDayOfInterval({
                start: this.active_range[0],
                end: this.active_range[1],
            });

            this.formatDateForHumans("each_active_range_day", eachDay);

            let parsedMarkedDays = this.marked_days.map((day) => {
                return parseISO(day);
            });

            let marked_days = parsedMarkedDays.filter((day) => {
                return !eachDay.includes(day);
            });

            this.marked_days = [];

            marked_days.map((day) => {
                if (
                    this.weekdays.includes(format(day, "EEEE")) &&
                    this.each_active_range_day.includes(
                        format(day, "yyyy-MM-dd")
                    )
                ) {
                    this.marked_days.push(format(day, "yyyy-MM-dd"));
                }
            });
        },
    },
});
