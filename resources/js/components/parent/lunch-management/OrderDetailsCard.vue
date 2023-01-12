<template>
    <div
        class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12"
    >
        <img
            src="/img/beams.jpg"
            alt=""
            class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2"
            width="1308"
        />
        <div
            class="absolute inset-0 bg-[url(/img/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"
        ></div>
        <div
            class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10"
        >
            <div class="mx-auto max-w-md">
                <!-- Order summary -->
                <section
                    aria-labelledby="summary-heading"
                    class="mt-16 rounded-lg border bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8"
                >
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
                                2023.01.01 - 2023.01.15
                            </dd>
                        </div>
                        <div
                            class="flex items-center justify-between border-t border-gray-200 pt-4"
                        >
                            <dt class="flex items-center text-sm text-gray-600">
                                <span>Claimable days</span>
                                <a
                                    href="#"
                                    class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500"
                                >
                                    <span class="sr-only"
                                        >Learn more about what claimable days
                                        are</span
                                    >
                                    <QuestionMarkIcon />
                                </a>
                            </dt>
                            <dd class="text-sm font-medium text-gray-900">
                                15
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
                                    <QuestionMarkIcon />
                                </a>
                            </dt>
                            <dd class="text-sm font-medium text-gray-900">
                                2 / Day
                            </dd>
                        </div>
                        <div
                            class="flex items-center justify-between border-t border-gray-200 pt-4"
                        >
                            <dt class="flex items-center text-sm text-gray-600">
                                Claimable days
                            </dt>
                            <dd class="text-sm font-medium text-gray-900">
                                Mon. - Fri.
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
import QuestionMarkIcon from "@/components/icons/QuestionMarkIcon.vue";
import CardIcon from "@/components/icons/CardIcon.vue";
import BankIcon from "@/components/icons/BankIcon.vue";
</script>

<style lang="scss" scoped></style>
