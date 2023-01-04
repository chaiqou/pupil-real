import { ref } from "vue";
import {
    format,
    eachMonthOfInterval,
    add,
    eachDayOfInterval,
    startOfWeek,
    startOfMonth,
    endOfWeek,
    endOfMonth,
    startOfToday,
} from "date-fns";

export default function useFindMonthDays(months = 11) {
    const today = startOfToday();

    // get current month with other months (we are passing months as a property)

    const currentMonthWithOtherMonths = ref(
        eachMonthOfInterval({
            start: today,
            end: add(today, { months: months }),
        })
    );

    // map each months to find name , year and full days

    const monthsDays = [
        ...currentMonthWithOtherMonths.value.map((month) => ({
            name: format(month, "MMMM"),
            year: format(month, "yyyy"),
            days: [
                ...eachDayOfInterval({
                    start: startOfWeek(startOfMonth(month), {
                        weekStartsOn: 1,
                    }),
                    end: endOfWeek(endOfMonth(month)),
                }),
            ],
        })),
    ];

    return {
        monthsDays,
    };
}
