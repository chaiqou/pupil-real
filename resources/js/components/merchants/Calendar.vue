<template>
    <div class="invisible lg:visible w-full">
        <div class="bg-inhrtit">
            <div
                class="mx-auto max-w-7xl grid grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 sm:px-6 xl:max-w-3xl xl:grid-cols-2 xl:px-8 2xl:grid-cols-3"
            >
                <section
                    v-for="month in months"
                    :key="month.name"
                    class="text-center"
                >
                    <h2 class="font-semibold text-gray-900">
                        {{ month.name }}
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
                        class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg w-60 bg-gray-200 text-sm shadow ring-1 ring-gray-200"
                    >
                        <button
                            v-for="day in month.days"
                            :key="day"
                            type="button"
                            :class="[
                                selectedDay === day
                                    ? 'bg-indigo-600 text-white'
                                    : 'bg-white text-gray-900',
                                'bg-white text-gray-900 py-1.5 hover:bg-indigo-100 focus:z-10',
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
                                {{ format(day, "d") }}</time
                            >
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import {
    startOfToday,
    format,
    eachDayOfInterval,
    startOfMonth,
    endOfMonth,
    isToday,
    add,
    eachMonthOfInterval,
    parse,
} from "date-fns";

const today = startOfToday();
const selectedDay = ref(today);
const currentMonthPlusFiveMonth = ref(
    eachMonthOfInterval({
        start: today,
        end: add(today, { months: 11 }),
    })
);

const months = [
    ...currentMonthPlusFiveMonth.value.map((month) => ({
        name: format(month, "MMM yyyy"),
        days: [
            ...eachDayOfInterval({
                start: startOfMonth(month),
                end: endOfMonth(month),
            }),
        ],
    })),
];
</script>
