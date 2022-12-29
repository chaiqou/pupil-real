<template>
    <template v-if="globalStore.toggleTooltip">
        <Tooltip />
    </template>
    <div>
        <div
            class="bg-inherit md:w-[30vw] md:h-[70vh] xl:w-[40vw] xl:h-[50vh] 2xl:w-[50vw] 2xl:h-[100vh]"
            :class="classes"
        >
            <div
                class="mx-auto grid max-w-3xl grid-cols-1 gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-1 sm:px-6 xl:max-w-none xl:grid-cols-2 xl:px-8 2xl:grid-cols-3"
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
                            @click="toggleTooltip(day)"
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
                                    isToday(day) && [
                                        getMonthByIndex(day.getMonth()) &&
                                        month.name ===
                                            monthFullNames[day.getMonth()]
                                            ? 'bg-indigo-600 font-semibold text-white h-full w-full border-b-1 border-indigo-600 aspect-auto'
                                            : 'bg-indigo-400 text-gray-50  h-full w-full border-b-1 border-indigo-600 aspect-auto',
                                    ],
                                    'mx-auto flex h-6 w-6 p-4 items-center justify-center rounded-md',
                                ]"
                            >
                                <div class="flex-col">
                                    <h1>
                                        {{ format(day, "d") }}
                                    </h1>
                                    <div
                                        v-if="ifDaysMatch(day) && isToday(day)"
                                        class="w-4 h-0.5 mx-auto bg-white rounded-full"
                                    ></div>
                                    <div
                                        v-if="ifDaysMatch(day) && !isToday(day)"
                                        class="w-4 h-0.5 mx-auto bg-indigo-600 rounded-full"
                                    ></div>
                                </div>
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
    isSameDay,
    parseISO,
} from "date-fns";
import { ref, defineProps, onBeforeMount } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { useGlobalStore } from "@/components/stores/useGlobalStore";
import Tooltip from "./Tooltip.vue";

const store = useLunchFormStore();
const globalStore = useGlobalStore();

const props = defineProps({
    months: {
        type: Number,
        required: true,
    },
    classes: {
        type: Array,
        required: false,
        default: "",
    },
});

const selectedDay = ref(null);

const toggleTooltip = (day) => {
    globalStore.toggleTooltip = !globalStore.toggleTooltip;
    selectedDay.value = day;
};

onBeforeMount(() => {
    const targetPath = `/school/lunch-management/${localStorage.getItem(
        "lunchId"
    )}/edit`;
    const currentPath = window.location.pathname;

    if (currentPath == targetPath) {
        axios.get("/api/school/lunch").then((response) => {
            response.data.data.map((data) => {
                if (localStorage.getItem("lunchId") == data.id) {
                    store.marked_days.push(...data.available_days);
                }
            });
        });
    }
});

const today = startOfToday();

const ifDaysMatch = (day) => {
    return store.marked_days.some((data) => isSameDay(parseISO(data), day));
};

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
