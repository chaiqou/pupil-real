<template>
  <TransitionRoot
    v-if="isRequestEndSuccessfully"
    as="template"
    :show="this.isMerchantEditVisible"
  >
    <DialogComponent
      as="div"
      class="relative z-10"
      @close="
        this.isMerchantEditVisible = false;
        this.merchantId = null;
      "
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
              class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6"
            >
              <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button
                  type="button"
                  class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                  @click="
                    this.isMerchantEditVisible = false;
                    this.merchantId = null;
                  "
                >
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <ValidationForm
                id="form"
                @submit="
                  onSubmit();
                  this.merchantId = null;
                "
                class="mt-8 w-full space-y-6"
              >
                <div class="bg-white p-8">
                  <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{$t('message.personal_information')}}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{$t('message.use_a_permanent_address_where_you_can_receive_mail')}}.
                    </p>
                  </div>
                  <div
                    class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6"
                  >
                    <div class="sm:col-span-3">
                      <label
                        for="merchant-nick"
                        class="block text-sm font-medium text-gray-700"
                        >{{$t('message.merchant_nick')}}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          required
                          v-model="this.merchant.merchant_nick"
                          name="nickname"
                          id="nickname"
                          autocomplete="nickname"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="nickname">
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-3">
                      <label
                        for="company-name"
                        class="block text-sm font-medium text-gray-700"
                        >{{$t('message.company_name')}}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          v-model="company_name"
                          type="text"
                          name="company_name"
                          id="company_name"
                          autocomplete="company-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="company_name"
                          class="text-sm text-red-500"
                        >
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-6">
                      <label
                        for="company-legal-name"
                        class="block text-sm font-medium text-gray-700"
                        >{{$t('message.company_legal_name')}}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.merchant.company_legal_name"
                          required
                          name="company_legal_name"
                          id="company_legal_name"
                          autocomplete="company-legal-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="company_legal_name"
                          class="text-sm text-red-500"
                        >
                        </ErrorMessage>
                      </div>
                    </div>

                    <CountriesSelect></CountriesSelect>

                    <div class="sm:col-span-6">
                      <label
                        for="address"
                        class="block text-sm font-medium text-gray-700"
                        >{{$t('message.address')}}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          v-model="street_address"
                          type="text"
                          name="address"
                          id="address"
                          autocomplete="address"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="address"
                          class="text-sm text-red-500"
                        >
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="city"
                        class="block text-sm font-medium text-gray-700"
                        >{{$t('message.city')}}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          v-model="city"
                          type="text"
                          name="city"
                          id="city"
                          autocomplete="city"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="city" class="text-sm text-red-500">
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="state"
                        class="block text-sm font-medium text-gray-700"
                        >{{$t('message.state_province')}}</label
                      >
                      <div class="mt-1">
                        <Field
                          v-model="state"
                          type="text"
                          name="state"
                          id="state"
                          autocomplete="state"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="state" class="text-sm text-red-500">
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="zip"
                        class="block text-sm font-medium text-gray-700"
                        >{{$t('message.zip_postal_code')}}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          v-model="zip"
                          type="text"
                          name="zip"
                          id="zip"
                          autocomplete="zip"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="zip" class="text-sm text-red-500">
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-3">
                      <label
                        for="VAT"
                        class="block text-sm font-medium text-gray-700"
                        >{{$t('message.vat')}}</label
                      >
                      <div class="mt-1">
                        <Field
                          type="text"
                          v-model="VAT"
                          name="VAT"
                          id="VAT"
                          autocomplete="VAT"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="VAT"
                          class="text-sm text-red-500"
                        ></ErrorMessage>
                      </div>
                    </div>

                    <div class="flex flex-col sm:col-span-4">
                      <div class="border-y-[1px] border-gray-300 pb-2 pt-2">
                        <div class="flex">
                          <h1 class="mr-3">{{$t('message.merchant_status')}}:</h1>
                          <div class="flex items-center">
                            <p
                              :class="
                                this.merchant.activated
                                  ? 'text-green-500'
                                  : 'text-red-500'
                              "
                            >
                              {{
                                this.merchant.activated ? $t("message.active") : $t("message.inactive")
                              }}
                            </p>
                            <svg
                              v-if="requestResponse === 'pending'"
                              class="ml-2 inline h-5 w-5 animate-spin fill-blue-600 text-gray-200 dark:text-gray-600"
                              viewBox="0 0 100 101"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor"
                              />
                              <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill"
                              />
                            </svg>
                            <XMarkIcon
                              class="ml-1.5 h-5 w-5 text-red-500"
                              v-if="requestResponse === 'fail'"
                            ></XMarkIcon>
                          </div>
                        </div>
                        <p
                          @click="showHideConfirmation"
                          :class="
                            activated
                              ? 'mt-4 max-w-fit cursor-pointer rounded-md bg-red-500 px-3 py-2 text-white hover:bg-red-600 hover:text-gray-200'
                              : 'mt-4 max-w-fit cursor-pointer rounded-md bg-green-500 px-3 py-2 text-white hover:bg-green-600 hover:text-gray-200'
                          "
                        >
                          {{ activated ? $t("message.deactivate") : $t("message.activate") }}
                        </p>
                      </div>

                      <OnClickOutside @trigger="isConfirmationVisible = false">
                        <div v-if="isConfirmationVisible">
                          <div
                            class="absolute z-30 ml-5 h-3 w-3 origin-bottom-left rotate-45 transform bg-gray-300"
                          ></div>
                          <div
                            class="absolute z-20 mt-3 w-fit rounded-md border-[1px] border-gray-400"
                          >
                            <p
                              class="w-full rounded-t-[0.3rem] bg-gray-300 px-3 py-2"
                            >
                                {{$t('message.are_you_sure')}}?
                            </p>
                            <div
                              class="rounded-md border-b-[1px] border-gray-400"
                            ></div>

                            <div class="my-1.5 flex w-48 justify-around">
                              <p
                                @click="
                                  this.activated = !this.activated;
                                  isConfirmationVisible = false;
                                  updateStatus();
                                "
                                :class="
                                  activated
                                    ? 'w-fit cursor-pointer rounded-md bg-red-500 px-3 py-2 text-white hover:bg-red-600 hover:text-gray-200'
                                    : 'w-fit cursor-pointer rounded-md bg-green-500 px-3 py-2 text-white hover:bg-green-600 hover:text-gray-200'
                                "
                              >
                                  {{ activated ? $t("message.deactivate") : $t("message.activate") }}
                              </p>
                              <p
                                @click="isConfirmationVisible = false"
                                class="text-bg-gray-400 w-fit cursor-pointer rounded-md bg-gray-200 px-3 py-2 hover:bg-gray-300"
                              >
                                  {{$t('message.cancel')}}
                              </p>
                            </div>
                          </div>
                        </div>
                      </OnClickOutside>
                    </div>
                  </div>
                  <div class="pt-5">
                    <div class="flex justify-end">
                      <button
                        type="submit"
                        class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                      >
                          {{$t('message.save')}}
                      </button>
                    </div>
                  </div>
                </div>
              </ValidationForm>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </DialogComponent>
  </TransitionRoot>
</template>

<script>
import {
  Dialog as DialogComponent,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { mapActions, mapWritableState } from "pinia";
import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import { OnClickOutside } from "@vueuse/components";
import { useMerchantStore } from "@/stores/useMerchantStore";
import { useModalStore } from "@/stores/useModalStore";
import { useGlobalStore } from "@/stores/useGlobalStore";
import CountriesSelect from "@/components/Ui/CountriesSelect.vue";

export default {
  data() {
    return {
      isRequestEndSuccessfully: false,
      isConfirmationVisible: false,
      requestResponse: null,
      VAT: "",
      street_address: "",
      company_name: "",
      country: "",
      city: "",
      state: "",
      zip: "",
      activated: "",
    };
  },
  components: {
    DialogComponent,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
    XMarkIcon,
    ValidationForm,
    Field,
    ErrorMessage,
    CountriesSelect,
    OnClickOutside,
  },
  props: {
    schoolId: {
      type: Number,
      required: true,
    },
  },
  computed: {
    ...mapWritableState(useMerchantStore, [
      "merchant",
      "merchantId",
      "merchants",
    ]),
    ...mapWritableState(useGlobalStore, ["countrySelect"]),
    ...mapWritableState(useModalStore, ["isMerchantEditVisible"]),
  },
  methods: {
    showHideConfirmation() {
      if (this.requestResponse === "success") {
        this.requestResponse = null;
      }
      this.isConfirmationVisible = !this.isConfirmationVisible;
    },
    ...mapActions(useModalStore, ["showHideMerchantEdit"]),
    onSubmit() {
      axios
        .put("/api/admin/merchant", {
          school_id: this.schoolId,
          merchant_id: this.merchant.id,
          merchant_nick: this.merchant.merchant_nick,
          company_legal_name: this.merchant.company_legal_name,
          company_name: this.company_name,
          country: this.countrySelect,
          zip: this.zip,
          city: this.city,
          state: this.state,
          street_address: this.street_address,
          VAT: this.VAT,
        })
        .then((res) => {
          this.merchants = res.data.data;
          this.countrySelect = "";
        })
        .finally(() => {
          this.isSchoolEditVisible = false;
        });
    },
    updateStatus() {
      this.requestResponse = "pending";
      axios
        .put("/api/admin/merchant-status", {
          merchant_id: this.merchant.id,
          activated: this.activated,
        })
        .then((res) => {
          this.merchant.activated = res.data.activated;
          this.requestResponse = "success";
        })
        .catch(() => {
          this.activated = !this.activated;
          this.requestResponse = "fail";
        });
    },
    handleGetSchoolRequest() {
      axios
        .get(`/api/admin/merchant/${this.merchantId}`)
        .then((res) => {
          this.merchant = res.data.data;
          this.VAT = this.merchant.company_details.VAT;
          this.company_name = this.merchant.company_details.company_name;
          this.street_address = this.merchant.company_details.street_address;
          this.countrySelect = this.merchant.company_details.country;
          this.zip = this.merchant.company_details.zip;
          this.city = this.merchant.company_details.city;
          this.state = this.merchant.company_details.state;
          this.activated = this.merchant.activated;
        })
        .finally(() => (this.isRequestEndSuccessfully = true));
    },
  },
  created() {
    this.handleGetSchoolRequest();
  },
};
</script>
