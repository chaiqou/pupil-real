<template>
    <div class="min-w-[30vw] xl:px-4">
        <div>
            <h3 class="text-lg font-medium mt-20 leading-6 text-gray-900">
                Lunch Information
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Current lunch details.
            </p>
        </div>
        <div class="mt-5 border-t border-gray-200">
            <dl
                v-for="lunch in store.lunches"
                class="sm:divide-y sm:divide-gray-200"
            >
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Title</dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        {{ lunch.title }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Description
                    </dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        {{ lunch.description }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Period length
                    </dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        {{ lunch.period_length }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Weekdays</dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        <div class="flex" v-for="weekdays in lunch.weekdays">
                            {{ weekdays }}
                        </div>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Active range
                    </dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        {{
                            `${format(
                                parseISO(lunch.active_range.at(0)),
                                "yyyy MMM dd"
                            )} -
 ${format(parseISO(lunch.active_range.at(-1)), "yyyy MMM dd")}`
                        }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Claimables
                    </dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        <div
                            class="flex"
                            v-for="claimables in lunch.claimables"
                        >
                            {{ claimables }}
                        </div>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Holds</dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        <span v-if="lunch.holds.length >= 0"></span>
                        <span v-else>{{ lunch.holds }}</span>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Extras</dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        <span v-if="lunch.extras.length >= 0"></span>
                        <span v-else>{{ lunch.extras }}</span>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Available days
                    </dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        <div
                            class="flex"
                            v-for="available_days in lunch.available_days"
                        >
                            {{
                                format(parseISO(available_days), "yyyy MMM dd")
                            }}
                        </div>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Price day</dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        {{ lunch.price_day }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Price period
                    </dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        {{ lunch.price_period }}
                    </dd>
                </div>
            </dl>
            <div v-if="firstDay != null">
                <Datepicker
                    closeOnScroll
                    v-model="firstDay"
                    :allowed-dates="allowedDates"
                    :enableTimePicker="false"
                    :clearable="false"
                />
                <button
                    class="flex w-full justify-center mt-4 rounded-md px-4 py-2 bg-indigo-600 text-base font-medium text-white"
                >
                    <p v-if="firstDay == ''" class="text-center">
                        Please select order starting date
                    </p>
                    <p v-else class="text-center">
                        {{
                            "Order starting at " +
                            format(firstDay, "yyyy MMMM dd")
                        }}
                    </p>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref, watch, computed } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { format, parseISO, addDays, addHours, isAfter } from "date-fns";

const store = useLunchFormStore();
const firstDay = ref();

const periodLength = ref();
const currentDate = new Date();
const bufferDays = ref("");
const firstPossibleDay = ref("");
const availableDays = ref([]);
const addOneDayToFirstPossibleDay = ref("");

const filteredDates = ref();
const availableDatesForStartOrdering = ref();

watch(bufferDays, (newValue) => {
    // Add buffer time hours to firstPossibleDay
    firstPossibleDay.value = addHours(currentDate, newValue);

    // Add one day to firstPossibleDay
    addOneDayToFirstPossibleDay.value = addDays(firstPossibleDay.value, 1);

    // find dates which past then firstPossibleDay and store it to firstAvailableDay and Sort dates by ASC
    filteredDates.value = availableDays.value[0]
        .filter((date) => isAfter(date, firstPossibleDay.value))
        .sort((a, b) => a - b);

    if (filteredDates.value.length < periodLength) {
        // Remove from filteredDates period length days
        availableDatesForStartOrdering.value = filteredDates.value.splice(
            periodLength.value
        );
    } else {
        availableDatesForStartOrdering.value = filteredDates.value;
    }

    // on load firstDay will be  available dates first day
    firstDay.value = availableDatesForStartOrdering.value[0];
});

const allowedDates = computed(() => {
    return availableDatesForStartOrdering.value;
});

onMounted(() => {
    axios
        .get("/api/school/lunch/" + localStorage.getItem("lunchId"))
        .then((response) => {
            availableDays.value.push(
                response.data.data.available_days.map((availableDay) => {
                    return parseISO(availableDay);
                })
            );
            periodLength.value = response.data.data.period_length;
            bufferDays.value = response.data.data.buffer_time;
            store.lunches.push(response.data.data);
            store.marked_days.push(...response.data.data.available_days);
        });
});
</script>
