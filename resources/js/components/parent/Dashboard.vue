<template>
    <div>
        <h1 class="mt-5 text-xl">Spendings</h1>
        <dl v-if="this.isWeekSpendingLoaded && this.isMonthSpendingLoaded" class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div  class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Last week total spending</dt>
                <dd  class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{this.weekSumAmount || '0'}}</dd>
            </div>
            <div  class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Last month total spending</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{this.monthSumAmount || '0'}}</dd>
            </div>
        </dl>

        <dl v-if="!(this.isWeekSpendingLoaded && this.isMonthSpendingLoaded)" class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div  class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500"><div class="mt-3 h-2.5 bg-slate-300 rounded animate-pulse"></div></dt>
                <dd  class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><div class="mt-3 h-2.5 bg-slate-300 rounded animate-pulse"></div></dd>
            </div>
            <div  class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500"><div class="mt-3 h-2.5 bg-slate-300 rounded animate-pulse"></div></dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><div class="mt-3 h-2.5 bg-slate-300 rounded animate-pulse"></div></dd>
            </div>
        </dl>

        <div class="border-[1px] border-gray-200 rounded-md mt-10 w-fit">
            <dashboard-transactions :student-id="this.studentId"></dashboard-transactions>
        </div>

        <div class="mt-10">
            <h1>Lunch orders</h1>
        </div>
    </div>








</template>

<script>
export default {
    data() {
        return {
         weekSpending: null,
         weekSumAmount: null,
         monthSpending: null,
         monthSumAmount: null,
         isWeekSpendingLoaded: false,
         isMonthSpendingLoaded: false,
        }
    },
    props: {
        studentId: {
            type: Number,
            required: true,
        }
    },
    methods: {
        handleGetLastWeekSpending() {
            fetch(`/api/parent/week-spending`, {
                method: 'post',
                body: JSON.stringify({student_id: this.studentId}),
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(res => res.json())
                .then(res => {
                    this.weekSpending = res.data
                    this.weekSumAmount = this.weekSpending.reduce((a,b) => {
                        return a + b.amount
                    }, 0)
                })
                .finally(() => this.isWeekSpendingLoaded = true)
        },

        handleGetLastMonthSpending() {
            fetch(`/api/parent/month-spending`, {
                method: 'post',
                body: JSON.stringify({student_id: this.studentId}),
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(res => res.json())
                .then(res => {
                    this.monthSpending = res.data
                    this.monthSumAmount = this.monthSpending.reduce((a,b) => {
                        return a + b.amount
                    }, 0)

                })
            .finally(() => this.isMonthSpendingLoaded = true)
        },

    },
    created() {
        this.handleGetLastWeekSpending();
        this.handleGetLastMonthSpending();
    }
}
</script>
