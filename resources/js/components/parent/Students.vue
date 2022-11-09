<template>
    <table :class="!this.isChangePasswordVisible ? (!this.isTwoFactorVisible ? (!this.isStudentEditVisible ? 'min-w-full divide-y divide-gray-300' : 'hidden md:block min-w-block divide-y divide-gray-300')  :  'hidden md:block min-w-full divide-y divide-gray-300') : 'hidden md:block min-w-full divide-y divide-gray-300'">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Last name</th>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">First name</th>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Middle name</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Country</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">State</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">City</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Address</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Zip</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-if="this.isStudentsLoaded && !this.isStudentEditVisible" v-for="student in students" :key="student.id">
               <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6 truncate ... max-w-[7rem]">{{student.last_name}}</td>
               <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate ... max-w-[7rem]"> {{student.first_name}} </td>
               <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate ... max-w-[7rem]"> {{student.middle_name}} </td>
               <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate ... max-w-[7rem]"> {{student.user_information.country}} </td>
               <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate ... max-w-[7rem]"> {{student.user_information.state}} </td>
               <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate ... max-w-[7rem]"> {{student.user_information.city}} </td>
               <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate ... max-w-[7rem]"> {{student.user_information.street_address}} </td>
               <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate ... max-w-[7rem]"> {{student.user_information.zip}} </td>
               <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                   <button @click="showHideStudentEdit(); currentStudentEdit(student.id)" class="text-indigo-600 hover:text-indigo-900"
                   >Edit</button
                   >
               </td>

        </tr>
        <tr v-if="this.isStudentEditVisible || !this.isStudentsLoaded" v-for="n in 7">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><div class="h-2 w-[7rem] bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 w-[7rem] bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 w-[7rem] bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 w-[7rem] bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 w-[7rem] bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 w-[7rem] bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 w-[7rem] bg-slate-300 rounded animate-pulse"></div></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><div class="h-2 w-[7rem] bg-slate-300 rounded animate-pulse"></div></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import { useStudentStore } from "../../stores/useStudentStore";
import { useModalStore } from "../../stores/useModalStore";
import { mapActions, mapWritableState } from "pinia";
export default {
    props: {
        student: {
            type: Object,
            required: true,
        },
        userId: {
            type: Number,
            required: true,
        },
    },
    computed: {
        ...mapWritableState(useStudentStore, ["isStudentsLoaded", "isSlideOverOpen", "students"]),
        ...mapWritableState(useModalStore, ["isChangePasswordVisible", "isTwoFactorVisible", "isStudentEditVisible"]),
    },
    methods: {
        ...mapActions(useStudentStore, ["showHideSlideOver", "currentStudentEdit"]),
        ...mapActions(useModalStore, ["showHideStudentEdit"]),
        handleGetStudentRequest() {
                fetch(`/api/parent/${this.userId}/students`, {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.students = res.data
                    })
                    .finally(() => {
                        setTimeout(() => {
                            this.isStudentsLoaded = true
                        }, 1500)
                    })
        },
    },
    mounted() {
        this.handleGetStudentRequest()
    },
}
</script>
