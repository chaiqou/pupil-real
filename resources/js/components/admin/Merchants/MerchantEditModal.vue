<template>
    <TransitionRoot v-if="this.isRequestEndSuccessfully" as="template" :show="this.isMerchantEditVisible">
        <Dialog
            as="div"
            class="relative z-10"
            @close="this.isMerchantEditVisible = false; this.merchantId = null;"
        >
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <div
                                class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block"
                            >
                                <button
                                    type="button"
                                    class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    @click="this.isMerchantEditVisible = false; this.merchantId = null"
                                >
                                    <span class="sr-only">Close</span>
                                    <XMarkIcon
                                        class="h-6 w-6"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                            <Form
                                id="form"
                                @submit="onSubmit(); this.merchantId = null"
                                class="mt-8 space-y-6 w-full"
                            >
                                <div class="bg-white p-8">
                                    <div>
                                        <h3
                                            class="text-lg font-medium leading-6 text-gray-900"
                                        >
                                            Personal Information
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Use a permanent address where you
                                            can receive mail.
                                        </p>
                                    </div>
                                    <div
                                        class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6"
                                    >
                                        <div class="sm:col-span-3">
                                            <label
                                                for="merchant-nick"
                                                class="block text-sm font-medium text-gray-700"
                                                >Company Nick</label
                                            >
                                            <div class="mt-1">
                                                <Field
                                                    rules="required"
                                                    type="text"
                                                    required
                                                    v-model="
                                                        this.merchant.merchant_nick
                                                    "
                                                    name="nickname"
                                                    id="nickname"
                                                    autocomplete="nickname"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                />
                                                <ErrorMessage name="nickname">
                                                    <p
                                                        class="text-red-500 text-sm"
                                                    >
                                                        nickname field is
                                                        required
                                                    </p>
                                                </ErrorMessage>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label
                                                for="company-name"
                                                class="block text-sm font-medium text-gray-700"
                                            >Company name</label
                                            >
                                            <div class="mt-1">
                                                <Field
                                                    rules="required"
                                                    v-model="
                                                        this.company_name
                                                    "
                                                    type="text"
                                                    name="company_name"
                                                    id="company_name"
                                                    autocomplete="company-name"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                />
                                                <ErrorMessage
                                                    name="company_name"
                                                    class="text-red-500 text-sm"
                                                >
                                                    <p
                                                        class="text-red-500 text-sm"
                                                    >
                                                        this field is required
                                                    </p>
                                                </ErrorMessage>
                                            </div>
                                        </div>


                                        <div class="sm:col-span-6">
                                            <label
                                                for="company-legal-name"
                                                class="block text-sm font-medium text-gray-700"
                                                >Company legal name</label
                                            >
                                            <div class="mt-1">
                                                <Field
                                                    rules="required"
                                                    type="text"
                                                    v-model="
                                                        this.merchant.company_legal_name
                                                    "
                                                    required
                                                    name="company_legal_name"
                                                    id="company_legal_name"
                                                    autocomplete="company-legal-name"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                />
                                                <ErrorMessage
                                                    name="company_legal_name"
                                                    class="text-red-500 text-sm"
                                                >
                                                    <p
                                                        class="text-red-500 text-sm"
                                                    >
                                                        this field is
                                                        required
                                                    </p>
                                                </ErrorMessage>
                                            </div>
                                        </div>

                                        <CountriesSelect></CountriesSelect>

                                        <div class="sm:col-span-6">
                                            <label
                                                for="address"
                                                class="block text-sm font-medium text-gray-700"
                                            >Address</label
                                            >
                                            <div class="mt-1">
                                                <Field
                                                    rules="required"
                                                    v-model="
                                                        this.street_address
                                                    "
                                                    type="text"
                                                    name="address"
                                                    id="address"
                                                    autocomplete="address"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                />
                                                <ErrorMessage
                                                    name="address"
                                                    class="text-red-500 text-sm"
                                                >
                                                    <p
                                                        class="text-red-500 text-sm"
                                                    >
                                                        this field is required
                                                    </p>
                                                </ErrorMessage>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label
                                                for="city"
                                                class="block text-sm font-medium text-gray-700"
                                            >City</label
                                            >
                                            <div class="mt-1">
                                                <Field
                                                    rules="required"
                                                    v-model="
                                                        this.city
                                                    "
                                                    type="text"
                                                    name="city"
                                                    id="city"
                                                    autocomplete="city"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                />
                                                <ErrorMessage
                                                    name="city"
                                                    class="text-red-500 text-sm"
                                                >
                                                    <p
                                                        class="text-red-500 text-sm"
                                                    >
                                                        city field is required
                                                    </p>
                                                </ErrorMessage>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label
                                                for="state"
                                                class="block text-sm font-medium text-gray-700"
                                            >state</label
                                            >
                                            <div class="mt-1">
                                                <Field
                                                    v-model="
                                                        this.state
                                                    "
                                                    type="text"
                                                    name="state"
                                                    id="state"
                                                    autocomplete="state"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                />
                                                <ErrorMessage
                                                    name="state"
                                                    class="text-red-500 text-sm"
                                                >
                                                    <p
                                                        class="text-red-500 text-sm"
                                                    >
                                                        state field is required
                                                    </p>
                                                </ErrorMessage>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label
                                                for="zip"
                                                class="block text-sm font-medium text-gray-700"
                                            >ZIP</label
                                            >
                                            <div class="mt-1">
                                                <Field
                                                    rules="required"
                                                    v-model="
                                                        this.zip
                                                    "
                                                    type="text"
                                                    name="zip"
                                                    id="zip"
                                                    autocomplete="zip"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                />
                                                <ErrorMessage
                                                    name="zip"
                                                    class="text-red-500 text-sm"
                                                >
                                                    <p
                                                        class="text-red-500 text-sm"
                                                    >
                                                        this field is required
                                                    </p>
                                                </ErrorMessage>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label
                                                for="VAT"
                                                class="block text-sm font-medium text-gray-700"
                                            >VAT</label
                                            >
                                            <div class="mt-1">
                                                <Field
                                                    type="text"
                                                    v-model="
                                                        this.VAT
                                                    "
                                                    name="VAT"
                                                    id="VAT"
                                                    autocomplete="VAT"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                />
                                                <ErrorMessage
                                                    name="VAT"
                                                    class="text-red-500 text-sm"
                                                ></ErrorMessage>
                                            </div>
                                        </div>

                                        <div class="flex  flex-col  sm:col-span-4">
                                         <div class="border-y-[1px] border-gray-300 pb-2 pt-2">
                                             <div class="flex">
                                                 <h1 class="mr-3">Merchant Status:</h1>
                                                 <p :class="this.merchant.activated ? 'text-green-500' : 'text-red-500'">{{this.merchant.activated ? 'Activate' : 'Inactive'}}</p>
                                             </div>
                                             <p @click="showHideConfirmation" :class="this.merchant.activated ? 'text-white max-w-fit cursor-pointer mt-4 px-3 py-2 rounded-md bg-red-500 hover:bg-red-600 hover:text-gray-200' : 'text-white max-w-fit cursor-pointer mt-4 px-3 py-2 rounded-md bg-green-500 hover:bg-green-600 hover:text-gray-200'">{{this.merchant.activated ? 'Deactivate' : 'Activate'}}</p>
                                         </div>
                                            <div v-if="isConfirmationVisible">
                                                <div class="h-3 w-3 origin-bottom-left rotate-45 bg-gray-300 transform ml-5 absolute z-30"></div>
                                                <div class="mt-3 w-fit z-20 absolute z-20 rounded-md border-[1px] border-gray-400">
                                                    <p class="px-3 py-2 bg-gray-300 rounded-t-md">
                                                        Are you sure?
                                                    </p>
                                                    <div class="border-b-[1px] border-gray-400 rounded-md">
                                                    </div>

                                                    <div class="flex justify-around my-1.5 w-48">
                                                        <p :class="this.merchant.activated ? 'cursor-pointer bg-red-500 text-white px-3 py-2 w-fit rounded-md hover:bg-red-600 hover:text-gray-200' : 'cursor-pointer bg-green-500 text-white px-3 py-2 w-fit rounded-md hover:bg-green-600 hover:text-gray-200'">{{this.merchant.activated ? 'Deactivate' : 'Activate'}}</p>
                                                        <p class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-bg-gray-400 px-3 py-2 w-fit rounded-md">Cancel</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="pt-5">
                                        <div class="flex justify-end">
                                            <button
                                                type="submit"
                                                class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            >
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </Form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationTriangleIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { mapActions, mapWritableState } from "pinia";
import { useMerchantStore } from "@/stores/useMerchantStore";
import { useModalStore } from "@/stores/useModalStore";
import { useGlobalStore } from "@/stores/useGlobalStore";
import { Form, Field, ErrorMessage } from "vee-validate";
import CountriesSelect from "@/components/ui/CountriesSelect.vue";

export default {
    data() {
        return {
            isRequestEndSuccessfully: false,
            VAT: "",
            street_address: "",
            company_name: "",
            country: "",
            city: "",
            state: "",
            zip: "",
            isConfirmationVisible: false,
        }
    },
    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationTriangleIcon,
        XMarkIcon,
        Form,
        Field,
        ErrorMessage,
        CountriesSelect,
    },
    computed: {
        ...mapWritableState(useMerchantStore, ["merchant", "merchantId", "merchants"]),
        ...mapWritableState(useGlobalStore, ["countrySelect"]),
        ...mapWritableState(useModalStore, ["isMerchantEditVisible"]),
    },
    methods: {
        showHideConfirmation() {
          this.isConfirmationVisible = !this.isConfirmationVisible;
        },
        ...mapActions(useModalStore, ["showHideMerchantEdit"]),
        onSubmit() {
            axios
                .post(`/api/admin/update`, {
                    school_id: this.school.id,
                    short_name: this.school.short_name,
                    full_name: this.school.full_name,
                    long_name: this.school.long_name,
                    email: this.email,
                    contact_person: this.contact_person,
                    phone_number: this.phone_number,
                    mobile_number: this.mobile_number,
                    extension: this.extension,
                    street_address: this.street_address,
                    school_code: this.school.school_code,
                })
                .then((res) => {
                    this.merchants = res.data.data;
                    this.countrySelect = "";
                })
                .finally(() => {
                    this.isSchoolEditVisible = false;
                });
        },
        handleGetSchoolRequest() {
            axios.get(`/api/admin/merchant/${this.merchantId}`)
                .then((res) => {
                    this.merchant = res.data.data;
                    this.VAT = this.merchant.company_details.VAT;
                    this.company_name = this.merchant.company_details.company_name;
                    this.street_address = this.merchant.company_details.street_address;
                    this.countrySelect = this.merchant.company_details.country;
                    this.zip = this.merchant.company_details.zip;
                    this.city = this.merchant.company_details.city;
                    this.state = this.merchant.company_details.state;
                })
                .finally(() => this.isRequestEndSuccessfully = true);
        }
    },
    created() {
         this.handleGetSchoolRequest();
    }
};
</script>
