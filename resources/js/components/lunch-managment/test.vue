<template>
    <div class="invisible sm:visible bg-inherit">
        <div
            class="mx-auto grid max-w-3xl lg:min-w-[50vh] xl:min-w-[70vh] 2xl:min-w-[100vh] grid-cols-1 gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-2 sm:px-6 xl:max-w-none md:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 xl:px-8 2xl:grid-cols-3"
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
                        :key="day.date"
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
                            'py-1.5 hover:bg-gray-100 focus:z-10',
                        ]"
                    >
                        <time
                            :datetime="format(day, 'yyyy-MM-dd')"
                            :class="[
                                isToday(day) &&
                                    'bg-indigo-600 font-semibold text-white',
                                'mx-auto flex h-7 w-7 items-center justify-center rounded-full',
                            ]"
                        >
                            {{ format(day, "d") }}
                        </time>
                    </button>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
