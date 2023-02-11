<template>
    <template v-if="menuManagementStore.toggleMenuManagementCard">
        <Suspense>
            <MenuManagementCard />
            <template #fallback>
                <MenuManagementSkeleton />
            </template>
        </Suspense>
    </template>
    <template v-if="menuManagementStore.toggleChoicesCard">
        <ChoicesCard
            :name="menuManagementStore.lunchName"
            :claimables="menuManagementStore.claimables"
        />
    </template>
    <template v-if="menuManagementStore.toggleFixedCard">
        <FixedCard
            :name="menuManagementStore.lunchName"
            :claimables="menuManagementStore.claimables"
        />
    </template>
    <div
        class="bg-inherit md:w-[30vw] md:h-[70vh] xl:w-[40vw] xl:h-[50vh] 2xl:w-[50vw] 2xl:h-[100vh]"
        :class="classes"
    >
        <div
            class="mx-auto grid max-w-3xl grid-cols-1 gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-1 sm:px-6 xl:max-w-none xl:grid-cols-2 xl:px-8 2xl:grid-cols-3"
        >
            <section
                v-for="month in monthsDays"
                :key="month.id"
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
                        :key="day.id"
                        type="button"
                        :class="[
                            month.name !== getMonthByIndex(day.getMonth()) &&
                            month.name === monthFullNames[day.getMonth()]
                                ? 'bg-white text-gray-900'
                                : 'bg-gray-50 text-gray-400',
                            dayIdx === 0 && 'rounded-tl-lg',
                            dayIdx === 6 && 'rounded-tr-lg',
                            dayIdx === month.days.length - 7 && 'rounded-bl-lg',
                            dayIdx === month.days.length - 1 && 'rounded-br-lg',
                            'py-1.5 hover:bg-gray-100',
                        ]"
                    >
                        <MenuCalendarDays :day="day" />
                    </button>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { format } from "date-fns";
import { ref, onBeforeMount } from "vue";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import MenuManagementCard from "./MenuManagementCard.vue";
import useFindMonthDays from "@/composables/calendar/useFindMonthDays";
import useFindMonthByIndex from "@/composables/calendar/useFindMonthByIndex";
import MenuManagementSkeleton from "./MenuManagementSkeleton.vue";
import MenuCalendarDays from "./MenuCalendarDays.vue";
import FixedCard from "./FixedCard.vue";
import ChoicesCard from "./ChoicesCard.vue";

const store = useLunchFormStore();
const menuManagementStore = useMenuManagementStore();

const { monthsDays } = useFindMonthDays(11);
const { getMonthByIndex, monthFullNames } = useFindMonthByIndex();

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

const lunches = ref([]);

const onClickCalendar = (day) => {
    let formatedDay = format(day, "yyyy-MM-dd");

    if (store.marked_days.includes(formatedDay)) {
        menuManagementStore.toggleMenuManagementCard =
            !menuManagementStore.toggleMenuManagementCard;
        menuManagementStore.selectedDay = day;
    }
};

// Fetch all existing lunch for merchant and mark it on calendar

onBeforeMount(() => {
    axios.get("/api/school/lunch").then((response) => {
        lunches.value = response.data.data;
        response.data.data.map((data) => {
            store.marked_days.push(...data.available_days);
        });
    });
});
</script>
