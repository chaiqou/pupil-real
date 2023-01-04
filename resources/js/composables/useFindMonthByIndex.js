export default function useFindMonthDays() {
    // Get Month full name by index , for example if we pass 1 we will get February (becose in JS monthes starting from 0)

    const getMonthByIndex = (index) => {
        const date = new Date();
        date.setDate(1);
        date.setMonth(index - 1);

        const locale = "en-us";
        const month = date.toLocaleString(locale, { month: "long" });

        return month;
    };

    return { getMonthByIndex };
}
