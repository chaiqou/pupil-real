<template>
    <nav aria-label="Progress">
        <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0 md:w-fit">
            <li class="relative md:flex md:flex-1">
                <div class="group flex w-full items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-900">Set up Account</span>
                            </span>
                </div>
            </li>


            <li class="relative md:flex md:flex-1">
                <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                </svg>
                            </span>
                    <span class="ml-4 text-sm font-medium text-gray-900">Personal Form</span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                </svg>
                            </span>
                    <span class="ml-4 text-sm font-medium text-gray-900">Company details</span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                </svg>
                            </span>
                    <span class="ml-4 text-sm font-medium text-gray-900">Stripe</span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                <span class="text-indigo-600">05</span>
                            </span>
                    <span class="ml-4 text-sm font-medium text-indigo-600">Verify Billingo</span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="group flex items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300">
                                    <span class="text-gray-500">06</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-500">Verify Account</span>
                            </span>
                </div>
            </li>
        </ol>
    </nav>
    <div>
        <img class="mx-auto h-16 w-auto" src="@/components/images/pupilpay-black-color.png" alt="PupilPay" />
        <h2 class="mt-8 text-center text-3xl font-bold tracking-tight text-gray-900">Fill out your personal information</h2>
        <p class="text-sm mt-4">
            We use Billingo to automatically handle invoicing, proformas and transfer payments.
        </p>
    </div>
    <div class="w-full">
        <ValidationForm @submit="onSubmit" id="form" class=" space-y-6">
            <div>
                <label for="billingo-api-key" class="block text-sm font-medium text-gray-700">Billingo key</label>
                <div class="mt-1">
                    <Field rules="required" type="text" v-model="billingo_api_key" name="billingo_api_key" id="billingo_api_key" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                    <ErrorMessage name="billing_api_key"></ErrorMessage>
                </div>
            </div>
            <ButtonForAxios classOngoing="bg-indigo-600 flex justify-center opacity-30 text-white px-3 py-2 w-full rounded-md hover:bg-indigo-700"
                classDefault="bg-indigo-600 text-white flex justify-center px-3 py-2 w-full rounded-md hover:bg-indigo-700">
                Submit
            </ButtonForAxios>
        </ValidationForm>
    </div>
</template>


<script>
import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import ButtonForAxios from "@/components/Ui/ButtonForAxios.vue";
import {mapActions} from "pinia";
import {useGlobalStore} from "@/stores/useGlobalStore";
export default {
    components: {
        ButtonForAxios,
        ValidationForm,
        Field,
        ErrorMessage
    },
    data() {
        return {
            billingo_api_key: ""
        }
    },
    props: {
        uniqueId: {
            type: String,
            required: true
        },
    },
    methods: {
        ...mapActions(useGlobalStore, ["setAxiosStatus"]),
        onSubmit() {
            this.setAxiosStatus("ongoing");
            axios.post(`/api/merchant-billingo-verify/${this.uniqueId}`, {
                api_key: this.billingo_api_key
            }).then((res) => {
                this.setAxiosStatus("updated");
                window.location.href = res.data.url;
            }).catch((err) => {
                this.setAxiosStatus("error");
                console.log(err);
            })
        },
    },
}
</script>
