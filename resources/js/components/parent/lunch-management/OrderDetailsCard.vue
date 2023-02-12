<template>
  <div
    class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12"
  >
    <div
      class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10"
    >
      <div class="mx-auto max-w-md">
        <!-- Order summary -->
        <section aria-labelledby="summary-heading">
          <h2 id="summary-heading" class="text-lg font-medium text-gray-900">
            Order summary
          </h2>
          <template
            v-if="
              !successFeedbackPayWithTransfer &&
              !errorFeedbackPayWithTransfer &&
              !loading
            "
          >
            <dl class="mt-6 space-y-4">
              <div class="flex items-center justify-between">
                <dt class="text-sm text-gray-600">Lunch Dates</dt>
                <dd class="text-sm font-medium text-gray-900">
                  {{ firstAndLastDay }}
                </dd>
              </div>
              <div
                class="flex items-center justify-between border-t border-gray-200 pt-4"
              >
                <dt class="flex items-center text-sm text-gray-600">
                  <span>Period length</span>
                  <BaseTooltip
                    content="Big Content here Big Content here Big Content here Big Content here for testing"
                    placement="top"
                  >
                    <QuestionMarkIcon />
                  </BaseTooltip>
                </dt>
                <dd class="text-sm font-medium text-gray-900">
                  {{ props.periodLength }}
                </dd>
              </div>
              <div
                class="flex items-center justify-between border-t border-gray-200 pt-4"
              >
                <dt class="flex text-sm text-gray-600">
                  <span>Claimables</span>
                  <BaseTooltip
                    content="Small content here for testing"
                    placement="top"
                  >
                    <button
                      class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500"
                    >
                      <QuestionMarkIcon />
                    </button>
                  </BaseTooltip>
                </dt>
                <dd class="text-sm font-medium text-gray-900">
                  {{ props.claimables.length }} / Day
                </dd>
              </div>
              <div
                class="flex items-center justify-between border-t border-gray-200 pt-4"
              >
                <dt class="flex items-center text-sm text-gray-600">
                  Claimable days
                </dt>
                <dd class="text-sm font-medium text-gray-900">
                  <p>
                    {{ weekdayNames }}
                  </p>
                </dd>
              </div>
              <div
                class="flex items-center justify-between border-t border-gray-200 pt-4"
              >
                <dt class="text-base font-medium text-gray-900">Order total</dt>
                <dd class="text-base font-medium text-gray-900">
                  ${{ props.price }}
                </dd>
              </div>
            </dl>

            <div class="mt-6">
              <button
                class="w-full items-center justify-center inline-flex rounded-md border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-lg border hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 hover:shadow-md transition-all focus:ring-offset-gray-50"
                @click="payWithOnlineHandler"
              >
                <CardIcon />
                Pay Online
              </button>
            </div>
            <div class="mt-2">
              <button
                @click="payWithTransferHandler"
                class="inline-flex w-full justify-center items-center rounded-md border border-gray-300 bg-white px-6 py-3 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
              >
                <BankIcon />
                Pay with transfer
              </button>
            </div>
          </template>
          <p class="mt-2 text-sm text-gray-500 lg:mb-12">
            Bank transfers usually take a few hours, or in some cases a few days
            to process.
          </p>
        </section>
      </div>
      <template v-if="successFeedbackPayWithTransfer">
        <OrderFeedbackCard>
          <SuccessResponseIcon />
        </OrderFeedbackCard>
      </template>
      <template v-if="errorFeedbackPayWithTransfer">
        <OrderFeedbackCard
          main-text="An error occurred on our server, please try again."
          sub-text="If this issue persists, please get in touch with us."
          main-classname="border-red-300 bg-red-100 hover:border-red-400"
          text-classname="text-red-700"
        >
          <ErrorResponseIcon />
        </OrderFeedbackCard>
      </template>
      <template v-if="loading">
        <div class="w-1/2 mx-auto">
          <Loading />
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { format } from "date-fns";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

import QuestionMarkIcon from "@/components/icons/QuestionMarkIcon.vue";
import CardIcon from "@/components/icons/CardIcon.vue";
import BankIcon from "@/components/icons/BankIcon.vue";
import BaseTooltip from "@/components/Ui/BaseTooltip.vue";
import OrderFeedbackCard from "@/components/parent/lunch-management/OrderFeedbackCard.vue";
import SuccessResponseIcon from "@/components/icons/SuccessResponseIcon.vue";
import ErrorResponseIcon from "@/components/icons/ErrorResponseIcon.vue";
import Loading from "@/components/icons/Loading.vue";

const props = defineProps({
  periodLength: {
    type: [String, Number],
  },
  claimables: {
    type: Array,
  },
  weekdays: {
    type: Array,
  },
  lunchDays: {
    type: Array,
  },
  price: {
    type: [String, Number],
  },
  studentId: {
    type: [String, Number],
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
});

const store = useLunchFormStore();

const weekdayNames = computed(() => {
  return props.weekdays.map((weekday) => weekday.substring(0, 1)).join(" ");
});

const firstAndLastDay = computed(() => {
  const formattedDays = props.lunchDays.map((lunchDay) =>
    format(lunchDay, "yyyy.MM.dd")
  );

  let firstAndLastDays = [formattedDays.shift(), formattedDays.pop()].join(
    " - "
  );

  return firstAndLastDays;
});

const successFeedbackPayWithTransfer = ref(false);
const errorFeedbackPayWithTransfer = ref(false);
const loading = ref(false);

const payWithTransferHandler = () => {
  loading.value = true;
  axios
    .post("/api/parent/lunch-order/" + props.studentId, {
      student_id: props.studentId,
      available_days: store.lunch_details[0].available_days,
      claimables: store.lunch_details[0].claimables,
      period_length: store.lunch_details[0].period_length,
      lunch_id: store.lunch_details[0].id,
      claims: store.claim_days,
    })
    .then((response) => {
      if (response.status == 200) {
        successFeedbackPayWithTransfer.value = true;
      } else {
        errorFeedbackPayWithTransfer.value = true;
      }
    })
    .finally(() => {
      loading.value = false;
    });
};

const payWithOnlineHandler = () => {
  loading.value = true;

  axios
    .post("/api/parent/checkout", {
      student_id: props.studentId,
      claimables: store.lunch_details[0].claimables,
      lunch_id: store.lunch_details[0].id,
      claims: store.claim_days,
      price: props.price,
      title: props.title,
    })
    .then((response) => {
      window.location.href = response.data.url;
    });
};
</script>
