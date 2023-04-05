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
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                <span class="text-indigo-600">04</span>
                            </span>
                    <span class="ml-4 text-sm font-medium text-indigo-600">Stripe</span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300">
                                <span class="text-gray-500">05</span>
                            </span>
                    <span class="ml-4 text-sm font-medium text-gray-500">Verify Billingo</span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300">
                                <span class="text-gray-500">06</span>
                            </span>
                    <span class="ml-4 text-sm font-medium text-gray-500">Verify Account</span>
                </div>
            </li>
        </ol>
    </nav>
    <div>
        <img class="mx-auto h-16 w-auto" src="@/components/images/pupilpay-black-color.png" alt="PupilPay" />
        <h2 class="mt-6 text-center text-2xl font-bold tracking-tight text-gray-900">Set up stripe account</h2>
        <p class="mt-2">We use <b>Stripe</b> to safely handle online card payments. For this, all you will need to do is click the button below and fill the forms out.</p>
        <p class="text-sm mt-1 text-gray-500">
            <b>Stripe</b> is one of the leading payment processing services in the world. Used by some of the largest companies, such as Amazon, Ford, Samsung or Apple.
        </p>
    </div>
    <div class="flex justify-center">
        <ButtonForAxios @click="handleGetStripeRedirectLinkRequest()" classOngoing="inline-flex opacity-30 items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            classDefault="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Continue on
            <svg class="ml-2 h-6 w-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 25" fill="currentColor" aria-hidden="true">
                <path d="M59.64 14.28h-8.06c.19 1.93 1.6 2.55 3.2 2.55 1.64 0 2.96-.37 4.05-.95v3.32a8.33 8.33 0 0 1-4.56 1.1c-4.01 0-6.83-2.5-6.83-7.48 0-4.19 2.39-7.52 6.3-7.52 3.92 0 5.96 3.28 5.96 7.5 0 .4-.04 1.26-.06 1.48zm-5.92-5.62c-1.03 0-2.17.73-2.17 2.58h4.25c0-1.85-1.07-2.58-2.08-2.58zM40.95 20.3c-1.44 0-2.32-.6-2.9-1.04l-.02 4.63-4.12.87V5.57h3.76l.08 1.02a4.7 4.7 0 0 1 3.23-1.29c2.9 0 5.62 2.6 5.62 7.4 0 5.23-2.7 7.6-5.65 7.6zM40 8.95c-.95 0-1.54.34-1.97.81l.02 6.12c.4.44.98.78 1.95.78 1.52 0 2.54-1.65 2.54-3.87 0-2.15-1.04-3.84-2.54-3.84zM28.24 5.57h4.13v14.44h-4.13V5.57zm0-4.7L32.37 0v3.36l-4.13.88V.88zm-4.32 9.35v9.79H19.8V5.57h3.7l.12 1.22c1-1.77 3.07-1.41 3.62-1.22v3.79c-.52-.17-2.29-.43-3.32.86zm-8.55 4.72c0 2.43 2.6 1.68 3.12 1.46v3.36c-.55.3-1.54.54-2.89.54a4.15 4.15 0 0 1-4.27-4.24l.01-13.17 4.02-.86v3.54h3.14V9.1h-3.13v5.85zm-4.91.7c0 2.97-2.31 4.66-5.73 4.66a11.2 11.2 0 0 1-4.46-.93v-3.93c1.38.75 3.1 1.31 4.46 1.31.92 0 1.53-.24 1.53-1C6.26 13.77 0 14.51 0 9.95 0 7.04 2.28 5.3 5.62 5.3c1.36 0 2.72.2 4.09.75v3.88a9.23 9.23 0 0 0-4.1-1.06c-.86 0-1.44.25-1.44.9 0 1.85 6.29.97 6.29 5.88z" fill-rule="evenodd"></path>
            </svg>
        </ButtonForAxios>
    </div>
</template>

<script>
import ButtonForAxios from "@/components/Ui/ButtonForAxios.vue";
import {mapActions} from "pinia";
import {useGlobalStore} from "@/stores/useGlobalStore";

export default {
    components: {
        ButtonForAxios
    },
    props: {
        uniqueId: {
            type: String,
            required: true
        },
    },
    methods: {
        ...mapActions(useGlobalStore, ["setAxiosStatus"]),
        handleGetStripeRedirectLinkRequest() {
            this.setAxiosStatus("ongoing");
            axios.get(`/api/merchant-setup-stripe/${this.uniqueId}`).then((res) => {
                this.setAxiosStatus("updated");
                window.location.href = res.data.url;
            }).catch((err) => {
                this.setAxiosStatus("error");
                console.log(err);
            })
        }
    },
}
</script>
