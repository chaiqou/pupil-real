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
                v-for="lunch in lunchDetails"
                :key="lunch"
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
                        <div
                            class="flex"
                            v-for="weekdays in lunch.weekdays"
                            :key="weekdays"
                        >
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
                            :key="claimables"
                        >
                            {{ claimables }}
                        </div>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Holds</dt>
                    <dd
                        v-for="holds in lunch.holds"
                        :key="holds"
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        <template class="flex" v-for="hold in holds">
                            <br />
                            {{ format(parseISO(hold), "yyyy MMM dd") }}
                        </template>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Extras</dt>
                    <dd
                        v-for="extras in lunch.extras"
                        :key="extras"
                        class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                    >
                        <template class="flex mt-4" v-for="extra in extras">
                            <br />
                            {{ format(parseISO(extra), "yyyy MMM dd") }}
                        </template>
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
                            :key="available_days"
                        >
                            {{
                                format(parseISO(available_days), "yyyy MMM dd")
                            }}
                        </div>
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
            <div v-if="store.first_day != null">
                <Datepicker
                    closeOnScroll
                    v-model="store.first_day"
                    :allowed-dates="store.availableDatesForStartOrdering"
                    :disabled-dates="disabledDaysForLunchOrder"
                    :disabled="isDisabled"
                    :enableTimePicker="false"
                    :clearable="false"
                />
                <button
                    :disabled="isDisabled"
                    @click="startOrderingLunch"
                    class="flex w-full justify-center mt-4 rounded-md px-4 py-2 bg-indigo-600 text-base font-medium text-white"
                >
                    <p v-if="isDisabled">
                        Period not enough for ordering lunch
                    </p>
                    <p
                        v-if="
                            store.first_day == '' && !disabledDaysForLunchOrder
                        "
                        class="text-center"
                    >
                        Please select order starting date
                    </p>
                    <p
                        v-if="store.first_day != '' && !isDisabled"
                        class="text-center"
                    >
                        {{
                            "Order starting at " +
                            format(store.first_day, "yyyy MMMM dd")
                        }}
                    </p>
                </button>
                <Toast ref="childrenToast" />
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref, watch, computed } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { format, parseISO, addDays, addHours, isAfter } from "date-fns";
import Toast from "@/components/ui/Toast.vue";

const store = useLunchFormStore();

const periodLength = ref();
const currentDate = new Date();
const bufferDays = ref("");
const firstPossibleDay = ref("");
const availableDays = ref([]);
const addOneDayToFirstPossibleDay = ref("");

const filteredDates = ref();
const lunchDetails = ref([]);
const childrenToast = ref();

const availableOrders = ref([]);
const disabledDaysForLunchOrder = ref([]);

const props = defineProps({
    studentId: {
        type: [Number, String],
    },
});

const isDisabled = computed(() => {
    return +periodLength.value < +disabledDaysForLunchOrder.value.length
        ? true
        : false;
});

const startOrderingLunch = () => {
    childrenToast.value.showToaster("Lunch ordered successfully");
    axios.post("/api/parent/lunch-order/" + props.studentId, {
        student_id: props.studentId,
        available_days: lunchDetails.value[0].available_days,
        claimables: lunchDetails.value[0].claimables,
        period_length: lunchDetails.value[0].period_length,
        start_day: store.first_day,
        lunch_id: lunchDetails.value[0].id,
    });
};

watch(availableOrders, () => {
    // Foreach each available order
    availableOrders.value.forEach((order) => {
        // claims is a JSON we need parse it to get it as a javascript object
        let parsedClaims = JSON.parse(order.claims);
        // get keys from claims
        let claimsKeys = Object.keys(parsedClaims);

        // Assign all dates in one state
        claimsKeys.forEach((claim) =>
            disabledDaysForLunchOrder.value.push(parseISO(claim))
        );
    });
});

const findCorrectStartDay = computed(() => {
    const formattedFilteretdDates = filteredDates.value.map((date) =>
        format(date, "yyyy-MM-dd")
    );

    const formattedDisabledDays = disabledDaysForLunchOrder.value.map((date) =>
        format(date, "yyyy-MM-dd")
    );

    let result = formattedFilteretdDates.filter(
        (x) => !formattedDisabledDays.includes(x)
    );

    return result;
});

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
        store.availableDatesForStartOrdering = filteredDates.value.splice(
            periodLength.value
        );
    } else {
        store.availableDatesForStartOrdering = filteredDates.value;
    }

    store.first_day = parseISO(findCorrectStartDay.value[0]);
});

onMounted(() => {
    axios
        .get(`/api/parent/available-orders/${props.studentId}`)
        .then((response) => (availableOrders.value = response.data.orders));

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
            lunchDetails.value = [response.data.data];
            store.period_length = response.data.data.period_length;
            store.available_days = response.data.data.available_days;
        });
});
</script>
