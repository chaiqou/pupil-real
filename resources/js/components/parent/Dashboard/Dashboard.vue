<template>
    <div>
       <div>
           <h1 class="mt-5 text-xl p-5">Spendings</h1>
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

           <div class="lg:w-[45rem] w-full">
               <h1 class="text-xl my-5 p-5">Last transactions</h1>
               <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                   <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                       <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                           <parent-dashboard-transactions :student-id="this.studentId"></parent-dashboard-transactions>
                       </div>
                   </div>
               </div>
           </div>
       </div>

            <div>
                <div class="w-[20rem] mt-5">
                    <h1 class="text-xl p-5">Lunch orders</h1>
                </div>
                    <div>
                        <calendar :months="0"></calendar>
                    </div>
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
            axios.get(`/api/parent/${this.studentId}/week-spending`)
                .then(res => {
                    this.weekSpending = res.data.data
                    this.weekSumAmount = this.weekSpending.reduce((a,b) => {
                        return a + b.amount
                    }, 0)
                })
                .finally(() => this.isWeekSpendingLoaded = true)
        },

        handleGetLastMonthSpending() {
            axios.get(`/api/parent/${this.studentId}/month-spending`)
                .then(res => {
                    this.monthSpending = res.data.data
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
