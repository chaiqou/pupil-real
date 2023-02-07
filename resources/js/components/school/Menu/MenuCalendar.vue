<template>
    <template v-if="menuManagementStore.toggle_card">
        <MenuManagementCard :selected-day="selectedDay" />
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
                            @click="onClickCalendar(day)"
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
import { format, isToday } from "date-fns";
import { ref, onBeforeMount } from "vue";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import MenuManagementCard from "./MenuManagementCard.vue";
import useFindMonthDays from "@/composables/useFindMonthDays";
import useFindMonthByIndex from "@/composables/useFindMonthByIndex";
import useCheckIfDaysMatches from "@/composables/useCheckIfDaysMatches";

const store = useLunchFormStore();
const menuManagementStore = useMenuManagementStore();
const { monthsDays } = useFindMonthDays(11);
const { getMonthByIndex, monthFullNames } = useFindMonthByIndex();
const { ifDaysMatch } = useCheckIfDaysMatches();

const selectedDay = ref();

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

const onClickCalendar = async (day) => {
    menuManagementStore.toggle_card = !menuManagementStore.toggle_card;
    selectedDay.value = day;

    const response = await axios.get("/api/lunch/suitable-lunch/date", {
        params: { date: day },
    });
    console.log(response);
};

const lunchDays = ref([]);
const lunches = ref([]);

// Fetch all existing lunch for merchant and mark it on calendar also fill lunchDays array
onBeforeMount(() => {
    axios.get("/api/school/lunch").then((response) => {
        lunches.value = response.data.data;
        response.data.data.map((data) => {
            lunchDays.value.push(...data.available_days);
            store.marked_days.push(...data.available_days);
        });
    });
});
</script>
