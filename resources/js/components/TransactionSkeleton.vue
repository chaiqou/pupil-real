<template>
    <table v-if="!this.isTransactionsLoaded"  class="min-w-full  animate-pulse divide-y divide-gray-300 mt-10">
        <thead class="bg-gray-200">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 bg-gray-200 text-left text-sm font-semibold text-gray-900 sm:pl-6"></th>
            <th scope="col" class="px-3 py-3.5 bg-gray-300 text-left text-sm font-semibold text-gray-900"></th>
            <th scope="col" class="px-3 py-3.5 bg-gray-200 text-left text-sm font-semibold text-gray-900"></th>
            <th scope="col" class="px-3 py-3.5 bg-gray-300 text-left text-sm font-semibold text-gray-900"></th>
            <th scope="col" class="px-3 py-3.5 bg-gray-200 text-left text-sm font-semibold text-gray-900"></th>

        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">  </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">  </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">  </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">  </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import {mapWritableState} from "pinia";
import {useTransactionStore} from "../stores/useTransactionStore";
export default {
    props: {
        transactions: {
            type: Array,
            required: true,
        },
    },
    computed: {
        ...mapWritableState(useTransactionStore, ["isTransactionsLoaded"])
    },
    mounted() {
        setTimeout(() => {
            this.isTransactionsLoaded = true;
        }, 2000)
    },
}
</script>
