<template>
    <table v-if="this.isTransactionsLoaded" class="min-w-full divide-y divide-gray-300">
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
        <tr v-for="transaction in transactions" :key="transaction.id">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{transaction.student.first_name}}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{transaction.amount}} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{transaction.transaction_type}} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{transaction.transaction_date}} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{transaction.merchant.merchant_nick}} </td>
        </tr>
        </tbody>
    </table>


</template>

<script>
import {mapWritableState} from "pinia";
import {useTransactionStore} from "../stores/useTransactionStore";
export default {
    data() {
        return {
         transactions: [],
        }
    },
    props: {
        student: {
            type: Object,
            required: true,
        },
        userId: {
            type: Number,
            required: true,
        },
        role: {
            type: String,
            required: true,
        }
    },
    computed: {
        ...mapWritableState(useTransactionStore, ["isTransactionsLoaded"])
    },
    methods: {
        handleNotificationRequest() {
            if(this.role === 'school') {
                fetch(`/api/school/transactions/${this.userId}`, {
                    method: 'get',
                    headers: {
                        'content-type': 'application-json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.transactions = res.data
                    })
                    .finally(() => this.isTransactionsLoaded = true)
                console.log(this.transactions, 1);
            } else {
                fetch(`/api/parent/transactions/${this.userId}`, {
                    method: 'get',
                    headers: {
                        'content-type': 'application-json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.transactions = res.data
                    })
                    .finally(() => this.isTransactionsLoaded = true)
                console.log(this.transactions, 1);
            }
        }

    },
    created() {
        this.handleNotificationRequest()
    },
}
</script>
