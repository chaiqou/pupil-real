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
            {{ $t("message.order_summary") }}
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
                <dt class="text-sm text-gray-600">
                  {{ $t("message.lunch_dates") }}
                </dt>
                <dd class="text-sm font-medium text-gray-900">
                  {{ firstAndLastDay }}
                </dd>
              </div>
              <div
                class="flex items-center justify-between border-t border-gray-200 pt-4"
              >
                <dt class="flex items-center text-sm text-gray-600">
                  <span> {{ $t("message.period_length") }}</span>
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
                  <span> {{ $t("message.claimables") }}</span>
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
                  {{ props.claimables.length }} / {{ $t("message.day") }}
                </dd>
              </div>
              <div
                class="flex items-center justify-between border-t border-gray-200 pt-4"
              >
                <dt class="flex items-center text-sm text-gray-600">
                  {{ $t("message.claimable_days") }}
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
                <dt class="text-base font-medium text-gray-900">
                  {{ $t("message.order_total") }}
                </dt>
                <dd class="text-base font-medium text-gray-900">
                  {{ props.price }}HUF
                </dd>
              </div>
            </dl>

            <div class="mt-6">
              <button
                class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-lg transition-all hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50"
                @click="payWithOnlineHandler"
              >
                <CardIcon />
                {{ $t("message.pay_online") }}
              </button>
            </div>
            <div class="mt-2">
              <button
                :disabled="billingoStatus !== 0"
                @click="payWithTransferHandler"
                :class="
                  billingoStatus === 0
                    ? 'inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-6 py-3 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2'
                    : 'inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-6 py-3 text-base font-medium text-gray-700 opacity-60 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2'
                "
              >
                <BankIcon />
                {{ $t("message.pay_with_transfer") }}
              </button>
            </div>
          </template>
          <p class="mt-2 text-sm text-gray-500 lg:mb-12" v-if="!billingoStatus">
            {{
              $t(
                "message.bank_transfers_usually_take_a_few_hours_or_in_some_cases_a_few_days_to_process",
              )
            }}.
          </p>
          <p class="mt-2 text-sm text-gray-500 lg:mb-12">
            {{ billingoStatusMessage }}
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
        <div class="mx-auto w-1/2">
          <Loading />
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
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
    format(lunchDay, "yyyy.MM.dd"),
  );

  return `${formattedDays.shift()} - ${formattedDays.pop()}`;
});

const successFeedbackPayWithTransfer = ref(false);
const errorFeedbackPayWithTransfer = ref(false);
const loading = ref(false);
const billingoStatus = ref(0);
const billingoStatusMessage = ref(null);
const merchantSuspendStatus = async () => {
  loading.value = true;

  try {
    const response = await axios.post(
      "/api/parent/billingo-connection-status",
      {
        lunch_id: store.lunch_details[0].id,
      },
    );
    billingoStatus.value = response.data.billingo_suspended;
    billingoStatusMessage.value = response.data.message;
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
};

const payWithTransferHandler = async () => {
  try {
    loading.value = true;

    const lunchOrder = {
      student_id: props.studentId,
      claimables: store.lunch_details[0].claimables,
      lunch_id: store.lunch_details[0].id,
      claim_days: store.claim_days,
      price: props.price,
    };

    // Send a POST request to the server to create a new lunch order
    const lunchOrderResponse = await axios.post(
      `/api/parent/lunch-order/${props.studentId}`,
      lunchOrder,
    );

    // Show success or error feedback based on the response status
    if (lunchOrderResponse.status === 200) {
      successFeedbackPayWithTransfer.value = true;
    } else {
      errorFeedbackPayWithTransfer.value = true;
    }

    loading.value = false;
  } catch (postError) {
    // Show loading spinner and handle any errors that occur during the POST request
    loading.value = true;
  }
};

const payWithOnlineHandler = async () => {
  loading.value = true;

  try {
    const checkoutData = {
      student_id: props.studentId,
      claimables: store.lunch_details[0].claimables,
      lunch_id: store.lunch_details[0].id,
      claims: store.claim_days,
      price: props.price,
      title: props.title,
    };

    const response = await axios.post("/api/parent/checkout", checkoutData);

    window.location.href = response.data.url;
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  merchantSuspendStatus();
});
</script>
