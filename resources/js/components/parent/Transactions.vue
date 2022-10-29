<template>
    <table  class="w-[14rem] md:w-[50rem] divide-y divide-gray-300">
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
                <button @click="showHideSlideOver(); currentTransactionDetails(transaction.id)" class="text-indigo-600 hover:text-indigo-900"
                >Details</button
                >
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

<parent-transaction-slide-over />
</template>

<script>
import {mapActions, mapWritableState} from "pinia";
import {useTransactionStore} from "../../stores/useTransactionStore";
export default {
    props: {
        student: {
            type: Object,
            required: true,
        },
        studentId: {
            type: Number,
            required: true,
        },
    },
    computed: {
        ...mapWritableState(useTransactionStore, ["isTransactionsLoaded", "isSlideOverOpen", "transactions"])
    },
    methods: {
        ...mapActions(useTransactionStore, ["showHideSlideOver", "currentTransactionDetails"]),
        handleGetNotificationRequest() {
                fetch(`/api/parent/transactions`, {
                    method: 'post',
                    body: JSON.stringify({student_id: this.studentId}),
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.transactions = res.data
                    })
                    .finally(() => this.isTransactionsLoaded = true)
        }

    },
    created() {
        this.handleGetNotificationRequest()
    },
}
</script>
