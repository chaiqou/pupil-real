<template>
    <div>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div  class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Last week total spending</dt>
                <dd  class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{this.weekSumAmount || 'No spending for last week'}}</dd>
            </div>
            <div  class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Last month total spending</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{this.monthSumAmount || 'No spending for last month'}}</dd>
            </div>
        </dl>
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
                //.finally(() => this.isStudentsLoaded = true)
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
            //.finally(() => this.isStudentsLoaded = true)
        },
    },
    created() {
        this.handleGetLastWeekSpending();
        this.handleGetLastMonthSpending();
    }
}
</script>
