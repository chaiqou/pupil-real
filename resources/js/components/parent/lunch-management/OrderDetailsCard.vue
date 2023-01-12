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
                    <h2
                        id="summary-heading"
                        class="text-lg font-medium text-gray-900"
                    >
                        Order summary
                    </h2>

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
                                <button
                                    class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500"
                                    @mouseenter="show"
                                    @mouseleave="hide"
                                    ref="referenceRef"
                                >
                                    <QuestionMarkIcon />
                                    <div
                                        ref="floatingRef"
                                        :class="[
                                            'absolute top-0 left-0 z-50 bg-gray-700 text-sm text-white px-3 py-1.5 rounded-md cursor-default',
                                            !isHidden && 'hidden',
                                        ]"
                                    >
                                        Tooltip Content
                                        <div
                                            class="absolute bg-gray-700 h-[8px] w-[8px] rotate-45"
                                            ref="arrowRef"
                                        ></div>
                                    </div>
                                </button>
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
                                <a
                                    href="#"
                                    class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500"
                                >
                                    <span class="sr-only"
                                        >Learn more about what a claimable
                                        is</span
                                    >
                                    <button>
                                        <QuestionMarkIcon />
                                    </button>
                                </a>
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
                            <dt class="text-base font-medium text-gray-900">
                                Order total
                            </dt>
                            <dd class="text-base font-medium text-gray-900">
                                $112.32
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <button
                            type="submit"
                            class="w-full items-center justify-center inline-flex rounded-md border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-lg border hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 hover:shadow-md transition-all focus:ring-offset-gray-50"
                        >
                            <CardIcon />
                            Pay Online
                        </button>
                    </div>
                    <div class="mt-2">
                        <button
                            type="button"
                            class="inline-flex w-full justify-center items-center rounded-md border border-gray-300 bg-white px-6 py-3 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            <BankIcon />
                            Pay with transfer
                        </button>
                        <p class="mt-2 text-sm text-gray-500">
                            Bank transfers usually take a few hours, or in some
                            cases a few days to process.
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { format } from "date-fns";
import { computePosition, flip, shift, offset, arrow } from "@floating-ui/dom";

import QuestionMarkIcon from "@/components/icons/QuestionMarkIcon.vue";
import CardIcon from "@/components/icons/CardIcon.vue";
import BankIcon from "@/components/icons/BankIcon.vue";

const props = defineProps({
    periodLength: {
        type: [String, Number],
    },
    claimables: {
        type: [Array],
    },
    weekdays: {
        type: [Array],
    },
    lunchDays: {
        type: [Array],
    },
});

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

// Tooltip

const referenceRef = ref();
const floatingRef = ref();
const arrowRef = ref();
const referenceRefSecond = ref();
const floatingRefSecond = ref();
const arrowRefSecond = ref();
const isHidden = ref(true);
const isHiddenSecond = ref(true);

const calculatePosition = async () => {
    const { x, y, middlewareData, placement } = await computePosition(
        referenceRef.value,
        floatingRef.value,
        {
            placement: "top",
            middleware: [
                offset(8),
                flip(),
                shift(),
                arrow({ element: arrowRef.value }),
            ],
        }
    );

    Object.assign(floatingRef.value.style, {
        left: `${x}px`,
        top: `${x + 30}px`,
    });

    const { x: arrowX, y: arrowY } = middlewareData.arrow;

    const opposedSide = {
        left: "right",
        right: "left",
        top: "bottom",
        bottom: "top",
    }[placement];

    Object.assign(arrowRef.value.style, {
        left: arrowX ? `${arrowX}px` : "",
        top: arrowY ? `${arrowY}px` : "",
        bottom: "",
        right: "",
        [opposedSide]: "-4px",
    });
};

const show = () => {
    isHidden.value = true;
    calculatePosition();
};
const hide = () => {
    isHidden.value = false;
};
</script>
