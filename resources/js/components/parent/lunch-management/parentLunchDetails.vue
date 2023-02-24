<template>
  <div class="min-w-[30vw] xl:px-4">
    <template v-if="hideTableInformation">
      <div>
        <h3 class="mt-20 text-lg font-medium leading-6 text-gray-900">
          Lunch Information
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
          Current lunch details.
        </p>
      </div>
      <div class="mt-5 border-t border-gray-200">
        <dl
          v-for="lunch in store.lunch_details"
          :key="lunch"
          class="sm:divide-y sm:divide-gray-200"
        >
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">Title</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              {{ lunch.title }}
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">Description</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              {{ lunch.description }}
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">Period length</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              {{ lunch.period_length }}
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">Weekdays</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
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
            <dt class="text-sm font-medium text-gray-500">Active range</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              {{
                `${format(parseISO(lunch.active_range.at(0)), "yyyy MMM dd")} -
 ${format(parseISO(lunch.active_range.at(-1)), "yyyy MMM dd")}`
              }}
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">Claimables</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
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
              <div class="flex" v-for="(hold, holdIdx) in holds" :key="holdIdx">
                <br />
                {{ format(parseISO(hold), "yyyy MMM dd") }}
              </div>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">Extras</dt>
            <dd
              v-for="extras in lunch.extras"
              :key="extras"
              class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
            >
              <div
                class="mt-4 flex"
                v-for="(extra, extraIdx) in extras"
                :key="extraIdx"
              >
                <br />
                {{ format(parseISO(extra), "yyyy MMM dd") }}
              </div>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">Available days</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <div
                class="flex"
                v-for="available_days in lunch.available_days"
                :key="available_days"
              >
                {{ format(parseISO(available_days), "yyyy MMM dd") }}
              </div>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">Price period</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
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
            :enableTimePicker="false"
            :clearable="false"
            :disabled="disableIfDatesLessThenPeriodLength"
          />
          <button
            @click="startOrderingLunch"
            :disabled="disableIfDatesLessThenPeriodLength"
            class="mt-4 flex w-full justify-center rounded-md bg-indigo-600 px-4 py-2 text-base font-medium text-white"
          >
            <p v-if="disableIfDatesLessThenPeriodLength">
              Period not enough for ordering lunch
            </p>
            <p
              v-if="
                store.first_day != '' && !disableIfDatesLessThenPeriodLength
              "
              class="text-center"
            >
              {{
                "Order starting at " + format(store.first_day, "yyyy MMMM dd")
              }}
            </p>
          </button>
          <Toast ref="childrenToast" />
        </div>
      </div>
    </template>
    <template v-else>
      <OrderDetailsCard
        :period-length="store.period_length"
        :claimables="store.claimables"
        :weekdays="store.weekdays"
        :lunch-days="store.claim_days"
        :price="store.price_period"
        :student-id="props.studentId"
        :title="lunchTitle"
      />
    </template>
  </div>
</template>
<script setup>
import { onMounted, ref, watch, computed } from "vue";
import { format, parseISO, addHours, isAfter } from "date-fns";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import Toast from "@/components/Ui/Toast.vue";
import OrderDetailsCard from "./OrderDetailsCard.vue";

const store = useLunchFormStore();

const availableDays = ref([]);
const lunchTitle = ref("");
const bufferTime = ref();
const childrenToast = ref();
const availableOrders = ref([]);
const disabledDaysForLunchOrder = ref([]);
const hideTableInformation = ref(true);

const props = defineProps({
  studentId: {
    type: [Number, String],
  },
});

const startOrderingLunch = () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
  hideTableInformation.value = false;
};

watch(availableOrders, () => {
  // Foreach each available order
  availableOrders.value.forEach((order) => {
    // claims is a JSON we need parse it to get it as a javascript object
    const parsedClaims = JSON.parse(order.claims);
    // get keys from claims
    const claimsKeys = Object.keys(parsedClaims);

    // Assign all dates in one state
    claimsKeys.forEach((claim) => {
      store.disabledDaysForLunchOrdering.push(parseISO(claim)),
        disabledDaysForLunchOrder.value.push(parseISO(claim));
    });
  });
});

const disableIfDatesLessThenPeriodLength = computed(
  () => +store.availableDatesForStartOrdering.length < +store.period_length,
);

watch(bufferTime, (newValue) => {
  const currentDate = addHours(new Date(), newValue); // add buffer time in hours

  // Removela all days which is before currentDate

  let firstAvailableLunchDate = availableDays.value.filter((day) =>
    isAfter(parseISO(day), currentDate),
  );

  // If this date does not available apply first one in array

  if (!firstAvailableLunchDate) {
    firstAvailableLunchDate = availableDays.value[0];
  }

  // Format from ISO string to 2022-13-13 format

  const formattedDisabledDays = disabledDaysForLunchOrder.value.map((date) =>
    format(date, "yyyy-MM-dd"),
  );

  // Remove all days from availableDays which includes inside formattedDisabledDays array
  // Also remove days which is before firstAvailableLunchDate
  // And format back to ISO string

  const removeDisabledDays = availableDays.value
    .filter(
      (x) =>
        !formattedDisabledDays.includes(x) &&
        isAfter(parseISO(x), parseISO(firstAvailableLunchDate[0])),
    )
    .map((day) => parseISO(day));

  // Assign first correct day
  store.first_day = removeDisabledDays[0];

  // Assign available days for start ordering
  store.availableDatesForStartOrdering = removeDisabledDays;
});

onMounted(async () => {
  try {
    // Fetch existing all orders and save to availableOrders
    const availableOrdersResponse = await axios.get(
      `/api/parent/available-orders/${props.studentId}`,
    );
    availableOrders.value = availableOrdersResponse.data.orders;

    // Fetch concrette order based lunch id
    const lunchDetailsResponse = await axios.get(
      `/api/school/lunch/${localStorage.getItem("lunchId")}`,
    );
    availableDays.value = lunchDetailsResponse.data.data.available_days.sort(
      (a, b) => parseISO(a) - parseISO(b),
    );
    bufferTime.value = lunchDetailsResponse.data.data.buffer_time;
    store.period_length = lunchDetailsResponse.data.data.period_length;
    store.available_days = lunchDetailsResponse.data.data.available_days;
    store.claimables = lunchDetailsResponse.data.data.claimables;
    store.weekdays = lunchDetailsResponse.data.data.weekdays;
    store.price_period = lunchDetailsResponse.data.data.price_period;
    store.lunch_details = [lunchDetailsResponse.data.data];
    lunchTitle.value = lunchDetailsResponse.data.data.title;
  } catch (err) {
    console.error(err);
  }
});
</script>
