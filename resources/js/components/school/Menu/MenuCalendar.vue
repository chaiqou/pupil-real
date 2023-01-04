<template>
    <template v-if="tooltipStore.toggle_tooltip">
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
                            :key="day"
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
                                class="mx-auto flex h-6 w-6 p-4 items-center justify-center rounded-md"
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
import { format, isToday, addDays, isSameDay, parseISO } from "date-fns";
import { ref, onBeforeMount, computed, onUpdated } from "vue";
import { useTooltipStore } from "@/stores/useTooltipStore";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import Tooltip from "./Tooltip.vue";
import useFindMonthDays from "@/composables/useFindMonthDays";
import useFindMonthByIndex from "@/composables/useFindMonthByIndex";

const store = useLunchFormStore();
const tooltipStore = useTooltipStore();
const { monthsDays } = useFindMonthDays(11);
const { getMonthByIndex } = useFindMonthByIndex();

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

const toggleTooltip = (day) => {
    tooltipStore.toggle_tooltip = !tooltipStore.toggle_tooltip;
    tooltipStore.selected_day = day;
};

const availableDates = ref([]);

const lunchPlans = ref([
    {
        id: 1,
        name: "Normal testing Lunch",
        startDate: "2022-12-28",
        endDate: "2023-01-01",
    },
    {
        id: 2,
        name: "Vegan testing Lunch",
        startDate: " 2022-12-31",
        endDate: "2023-01-02",
    },
]);

const calculateLunches = computed(() => {
    let availableDays = availableDates.value;

    for (let lunchPlan of lunchPlans.value) {
        let startDate = new Date(lunchPlan.startDate);
        let endDate = new Date(lunchPlan.endDate);

        // Iterate over the range of dates covered by the lunch plan
        for (let date = startDate; date <= endDate; date = addDays(date, 1)) {
            let formattedDate = format(date, "yyyy-MM-dd");

            // Check if the date is already in the big array
            if (availableDays[formattedDate]) {
                // If it is, add the lunch plan's ID and name to the array for that date
                availableDays[formattedDate].push({
                    id: lunchPlan.id,
                    name: lunchPlan.name,
                });
            } else {
                // If it isn't, add a new entry to the big array with the date as the key
                // and an array containing the lunch plan's ID and name as the value
                availableDays[formattedDate] = [
                    { id: lunchPlan.id, name: lunchPlan.name },
                ];
            }
        }
    }

    return availableDays;
});

onUpdated(() => {
    calculateLunches.value;
}),
    onBeforeMount(() => {
        axios.get("/api/school/lunch").then((response) => {
            response.data.data.map((data) => {
                availableDates.value.push(...data.available_days);
                store.marked_days.push(...data.available_days);
            });
        });
    });

const ifDaysMatch = (day) => {
    return store.marked_days.some((data) => isSameDay(parseISO(data), day));
};

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
