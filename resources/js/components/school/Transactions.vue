<template>
    <div @scroll="onScroll" :class="this.isTransactionsLoaded && !this.transactions ? 'overflow-hidden max-h-[19.65rem] overflow-y-scroll shadow ring-1 ring-black ring-opacity-5 md:rounded-lg' : 'overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg'">
    <table  class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Merchant</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
        <tr v-if="this.isTransactionsLoaded && !this.transactions.length">
            <td class="bg-white" colspan="5">
                <TransactionsNotFound role="school"></TransactionsNotFound>
            </td>
        </tr>
        <tr v-if="this.isTransactionsLoaded && this.transactions.length" v-for="transaction in transactions" :key="transaction.id">
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
<transaction-slide-over></transaction-slide-over>
    </div>
</template>

<script>
import TransactionsNotFound from "../not-found/TransactionsNotFound";
import {mapActions, mapWritableState} from "pinia";
import {useTransactionStore} from "../../stores/useTransactionStore";
import TransactionSlideOver from "./TransactionSlideOver";
export default {
    components: {
        TransactionsNotFound,
        TransactionSlideOver,
    },
    data() {
        return {
            currentPage: 1,
            lastPage: 2,
        }
    },
    props: {
        student: {
            type: Object,
            required: true,
        },
        schoolId: {
            type: Number,
            required: true,
        },
    },
    computed: {
        ...mapWritableState(useTransactionStore, ["isTransactionsLoaded", "isSlideOverOpen", "transactions"])
    },
    methods: {
        ...mapActions(useTransactionStore, ["showHideSlideOver", "currentTransactionDetails"]),
        handleGetTransactionsRequest() {
                fetch(`/api/school/${this.schoolId}/transactions`, {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.currentPage++;
                        this.lastPage = res.meta.last_page;
                        this.transactions.push(...res.data)
                    })
                    .finally(() => this.isTransactionsLoaded = true)
        },

        onScroll ({ target: { scrollTop, clientHeight, scrollHeight }}) {
            if (scrollTop + clientHeight >= scrollHeight) {
                if(this.currentPage > this.lastPage) {return}
                this.handleGetStudentRequest();
            }
        },

    },
    created() {
        this.handleGetTransactionsRequest()
    },
}
</script>
