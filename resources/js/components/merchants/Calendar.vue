<template>
    <div>
        <div class="bg-white">
            <div
                class="mx-auto grid max-w-3xl grid-cols-1 gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-2 sm:px-6 xl:max-w-none xl:grid-cols-3 xl:px-8 2xl:grid-cols-4"
            >
                <section
                    v-for="month in monthsDays"
                    :key="month.name"
                    class="text-center"
                >
                    <h2 class="font-semibold text-gray-900">
                        {{ month.name }}
                    </h2>
                    <div
                        class="mt-6 grid grid-cols-7 text-xs leading-6 text-gray-500"
                    >
                        <div>S</div>
                        <div>M</div>
                        <div>T</div>
                        <div>W</div>
                        <div>T</div>
                        <div>F</div>
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
                                isSameMonth(day, today)
                                    ? 'bg-white text-gray-900'
                                    : 'bg-gray-50 text-gray-400',
                                dayIdx === 0 && 'rounded-tl-lg',
                                dayIdx === 6 && 'rounded-tr-lg',
                                dayIdx === 0 &&
                                    calculateStartOfDay[getDay(day)],
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
                                >{{ format(day, "d") }}</time
                            >
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
    isSameMonth,
    eachMonthOfInterval,
    add,
    getDay,
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
        name: format(month, "MMM yyyy"),
        days: [
            ...eachDayOfInterval({
                start: startOfMonth(month),
                end: endOfWeek(endOfMonth(month)),
            }),
        ],
    })),
];

const calculateStartOfDay = [
    "",
    "col-start-2",
    "col-start-3",
    "col-start-4",
    "col-start-5",
    "col-start-6",
    "col-start-7",
];
</script>
