<template>
    <div>
        <div class="bg-white">
            <div
                class="mx-auto grid max-w-3xl grid-cols-1 gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-2 sm:px-6 xl:max-w-none xl:grid-cols-3 xl:px-8 2xl:grid-cols-4"
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
                        class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200"
                    >
                        <button
                            @click="console.log('tse')"
                            v-for="day in newDays"
                            :key="day.toString()"
                            type="button"
                            class="bg-white text-gray-900 py-1.5 hover:bg-gray-100 focus:z-10"
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
import {
    startOfToday,
    format,
    eachDayOfInterval,
    startOfMonth,
    endOfMonth,
    isToday,
    setSelectedDay,
} from "date-fns";

let today = startOfToday();

let newDays = eachDayOfInterval({
    start: startOfMonth(today),
    end: endOfMonth(today),
});

const months = [
    {
        name: format(today, "MMM yyyy"),
        days: newDays,
    },
];
</script>
