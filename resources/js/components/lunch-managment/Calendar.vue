<template>
    <div class="invisible lg:visible w-full">
        <div class="bg-inherit">
            <div
                class="mx-auto 2xl:w-[100vh] grid grid-cols-1 gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-2 sm:px-6 xl:max-w-none 2xl:grid-cols-2 xl:px-8"
            >
                <section
                    v-for="month in monthsDays"
                    :key="month.name"
                    class="text-center"
                >
                    <h2 class="font-semibold text-gray-900">
                        {{ month.name }} {{ month.year }}
                    </h2>
                    <div
                        class="mt-6 grid grid-cols-7 text-xs leading-6 text-gray-500"
                    >
                        <div>M</div>
                        <div>T</div>
                        <div>W</div>
                        <div>T</div>
                        <div>F</div>
                        <div>S</div>
                        <div>S</div>
                    </div>
                    <div
                        class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200"
                    >
                        <button
                            v-for="(day, dayIdx) in month.days"
                            :key="day.date"
                            type="button"
                            :class="[
                                month.name !==
                                    getMonthByIndex(day.getMonth()) &&
                                month.name === monthFullNames[day.getMonth()]
                                    ? 'bg-white text-gray-900'
                                    : 'bg-gray-50 text-gray-400',
                                dayIdx === 0 && 'rounded-tl-lg',
                                dayIdx === 6 && 'rounded-tr-lg',
                                dayIdx === month.days.length - 7 &&
                                    'rounded-bl-lg',
                                dayIdx === month.days.length - 1 &&
                                    'rounded-br-lg',
                                'py-1.5 hover:bg-gray-100 focus:z-10',
                            ]"
                        >
                            <time
                                :datetime="format(day, 'yyyy-MM-dd')"
                                :class="[
                                    isToday(day) &&
                                        'bg-indigo-600 font-semibold text-white',
                                    'mx-auto flex h-7 w-7 items-center justify-center rounded-full',
                                ]"
                            >
                                {{ format(day, "d") }}
                            </time>
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    startOfToday,
    format,
    eachDayOfInterval,
    startOfMonth,
    endOfMonth,
    endOfWeek,
    isToday,
    eachMonthOfInterval,
    add,
    startOfWeek,
    addDays,
} from "date-fns";
import { ref, defineProps } from "vue";

const props = defineProps({
    months: {
        type: Number,
        required: true,
    },
});

const today = startOfToday();

const currentMonthWithOtherMonths = ref(
    eachMonthOfInterval({
        start: today,
        end: add(today, { months: props.months }),
    })
);

const monthsDays = [
    ...currentMonthWithOtherMonths.value.map((month) => ({
        name: format(month, "MMMM"),
        year: format(month, "yyyy"),
        days: [
            ...eachDayOfInterval({
                start: startOfWeek(startOfMonth(month), { weekStartsOn: 1 }),
                end: endOfWeek(endOfMonth(month)),
            }),
        ],
    })),
];

// Get Month full name by index , for example if we pass 1 we will get February

const getMonthByIndex = function (index) {
    const date = new Date();
    date.setDate(1);
    date.setMonth(index - 1);

    const locale = "en-us";
    const month = date.toLocaleString(locale, { month: "long" });

    return month;
};

// i added days to the end of month to make all month equals to 42 length for design purpose

monthsDays.forEach((month) => {
    month.days.filter(() => {
        if (month.days.length < 42) {
            let lastElement = month.days[month.days.length - 1];
            month.days.push(addDays(lastElement, 1));
        }
    });
});

const monthFullNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];
</script>
