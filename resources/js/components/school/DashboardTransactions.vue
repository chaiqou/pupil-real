<template>
    <table  class="w-[11rem] md:w-[50.13rem] divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Merchant</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-if="this.isTransactionsLoaded" v-for="transaction in transactions" :key="transaction.id">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{transaction.student.first_name}}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{transaction.amount}} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{transaction.transaction_type}} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{transaction.transaction_date}} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{transaction.merchant.merchant_nick}} </td>
            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
            </td>
        </tr>
        <tr v-if="!this.isTransactionsLoaded" v-for="n in 7">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><div class="h-2 bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 bg-slate-300 rounded animate-pulse"></div>  </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 bg-slate-300 rounded animate-pulse"></div>  </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 bg-slate-300 rounded animate-pulse"></div>  </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    data() {
        return {
            transactions: [],
            isTransactionsLoaded: false,
        }
    },

    props: {
        schoolId: {
            type: Number,
            required: true,
        }
    },
    methods: {
        handleGetLastFiveTransactions() {
            fetch(`/api/school/last-transactions`, {
                method: 'post',
                body: JSON.stringify({school_id: this.schoolId}),
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(res => res.json())
                .then(res => {
                    this.transactions = res.data;
                })
                .finally(() => this.isTransactionsLoaded = true)
        },
    },
    created() {
        this.handleGetLastFiveTransactions();
    }
}
</script>
