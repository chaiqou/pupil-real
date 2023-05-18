<template>
  <nav aria-label="Progress">
    <ol
      role="list"
      class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:w-fit md:divide-y-0"
    >
      <li class="hidden md:flex md:flex-1">
        <div class="group hidden md:flex w-full items-center">
          <span class="flex items-center px-6 py-4 text-sm font-medium">
            <span
              class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600"
            >
              <svg
                class="h-6 w-6 text-white"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
            <span class="ml-4 text-sm font-medium text-gray-900">{{
              $t("message.set_up_account")
            }}</span>
          </span>
        </div>
      </li>

      <li class="hidden md:flex md:flex-1">
        <div
          class="md:flex hidden items-center px-6 py-4 text-sm font-medium"
          aria-current="step"
        >
          <span
            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600"
          >
            <svg
              class="h-6 w-6 text-white"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                clip-rule="evenodd"
              />
            </svg>
          </span>
          <span class="ml-4 text-sm font-medium text-gray-900">{{
            $t("message.personal_information")
          }}</span>
        </div>
      </li>

      <li class="relative md:flex md:flex-1">
        <div
          class="flex items-center px-6 py-4 text-sm font-medium"
          aria-current="step"
        >
          <span
            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600"
          >
            <span class="text-indigo-600">03</span>
          </span>
          <span class="ml-4 text-sm font-medium text-indigo-600">{{
            $t("message.company_details")
          }}</span>
        </div>
      </li>

      <li class="hidden md:flex md:flex-1">
        <div class="group hidden md:flex items-center">
          <span class="flex items-center px-6 py-4 text-sm font-medium">
            <span
              class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300"
            >
              <span class="text-gray-500">04</span>
            </span>
            <span class="ml-4 text-sm font-medium text-gray-500">{{
              $t("message.stripe")
            }}</span>
          </span>
        </div>
      </li>

      <li class="hidden md:flex md:flex-1">
        <div class="group hidden md:flex items-center">
          <span class="flex items-center px-6 py-4 text-sm font-medium">
            <span
              class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300"
            >
              <span class="text-gray-500">05</span>
            </span>
            <span class="ml-4 text-sm font-medium text-gray-500">{{
              $t("message.verify_billingo")
            }}</span>
          </span>
        </div>
      </li>

      <li class="hidden md:flex md:flex-1">
        <div class="group hidden md:flex items-center">
          <span class="flex items-center px-6 py-4 text-sm font-medium">
            <span
              class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300"
            >
              <span class="text-gray-500">06</span>
            </span>
            <span class="ml-4 text-sm font-medium text-gray-500">{{
              $t("message.verify_account")
            }}</span>
          </span>
        </div>
      </li>
    </ol>
  </nav>
  <div>
    <img
      class="mx-auto h-16 w-auto"
      src="@/components/images/pupilpay-black-color.png"
      alt="PupilPay"
    />
    <h2
      class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900"
    >
      {{ $t("message.fill_out_your_business_details") }}
    </h2>
  </div>

  <div>
    <ValidationForm @submit="onSubmit" class="mt-8 space-y-6 lg:w-[40rem]">
      <div class="bg-white p-8">
        <div>
          <h3 class="text-lg font-medium leading-6 text-gray-900">
            {{ $t("message.company_details") }}
          </h3>
          <p class="mt-1 text-sm text-gray-500">
            {{
              $t("message.use_a_permanent_address_where_you_can_receive_mail")
            }}.
          </p>
        </div>
        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label
              for="merchant-nick"
              class="block text-sm font-medium text-gray-700"
              >{{ $t("message.merchant_nick") }}</label
            >
            <div class="mt-1">
              <Field
                v-model="merchant_nick"
                type="text"
                rules="required"
                name="merchant_nick"
                id="merchant_nick"
                autocomplete="merchant-nick"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="merchant_nick"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label
              for="company-name"
              class="block text-sm font-medium text-gray-700"
              >{{ $t("message.company_name") }}</label
            >
            <div class="mt-1">
              <Field
                v-model="company_name"
                type="text"
                rules="required"
                required
                name="company_name"
                id="company_name"
                autocomplete="company-name"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="company_name"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-6">
            <label
              for="company_legal_name"
              class="block text-sm font-medium text-gray-700"
              >{{ $t("message.company_legal_name") }}</label
            >
            <div class="mt-1">
              <Field
                v-model="company_legal_name"
                type="text"
                rules="required"
                name="company_legal_name"
                id="company_legal_name"
                autocomplete="company-legal-name"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="company_legal_name"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-6">
            <label for="business_type" class="sr-only">{{
              $t("message.business_type")
            }}</label>
            <select
              v-model="business_type"
              id="business_type"
              required
              name="business_type"
              autocomplete="business_type"
              class="relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
            >
              <option selected value="individual">
                {{ $t("message.individual") }}
              </option>
              <option value="company">{{ $t("message.company") }}</option>
              <option value="non_profit">{{ $t("message.non_profit") }}</option>
            </select>
          </div>

          <div class="sm:col-span-6">
            <CountriesSelect :isDisabled="true"></CountriesSelect>
          </div>

          <div class="sm:col-span-6">
            <label
              for="street_address"
              class="block text-sm font-medium text-gray-700"
              >{{ $t("message.street_address") }}</label
            >
            <div class="mt-1">
              <Field
                v-model="street_address"
                type="text"
                rules="required"
                name="street_address"
                id="street_address"
                autocomplete="street-address"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="street_address"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="city" class="block text-sm font-medium text-gray-700">{{
              $t("message.city")
            }}</label>
            <div class="mt-1">
              <Field
                v-model="city"
                type="text"
                rules="required"
                name="city"
                id="city"
                autocomplete="address-level2"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="city"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label
              for="state"
              class="block text-sm font-medium text-gray-700"
              >{{ $t("message.state_province") }}</label
            >
            <div class="mt-1">
              <Field
                v-model="state"
                type="text"
                rules="required"
                name="state"
                id="state"
                autocomplete="address-level1"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="state"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="zip" class="block text-sm font-medium text-gray-700">{{
              $t("message.zip_postal_code")
            }}</label>
            <div class="mt-1">
              <Field
                v-model="zip"
                type="text"
                rules="required"
                name="zip"
                id="zip"
                autocomplete="postal-code"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="zip"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-3">
            <label for="vat" class="block text-sm font-medium text-gray-700">{{
              $t("message.vat")
            }}</label>
            <div class="mt-1">
              <Field
                v-model="vat"
                type="text"
                rules="required"
                name="vat"
                id="vat"
                autocomplete="vat"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="vat"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>
        </div>
        <div class="pt-5">
          <div class="flex justify-end">
            <ButtonForAxios
              classOngoing="ml-3 opacity-30 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
              classDefault="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
              {{ $t("message.save") }}
            </ButtonForAxios>
          </div>
        </div>
      </div>
    </ValidationForm>
  </div>
</template>

<script>
import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import CountriesSelect from "@/components/Ui/CountriesSelect.vue";
import { useGlobalStore } from "@/stores/useGlobalStore";
import { mapActions, mapWritableState } from "pinia";
import ButtonForAxios from "@/components/Ui/ButtonForAxios.vue";
export default {
  components: {
    ButtonForAxios,
    CountriesSelect,
    ValidationForm,
    Field,
    ErrorMessage,
  },
  data() {
    return {
      merchant_nick: "",
      company_name: "",
      company_legal_name: "",
      business_type: "individual",
      street_address: "",
      city: "",
      state: "",
      zip: "",
      vat: "",
    };
  },
  props: {
    uniqueId: {
      type: String,
      required: true,
    },
  },
  computed: {
    ...mapWritableState(useGlobalStore, ["countrySelect"]),
  },
  methods: {
    ...mapActions(useGlobalStore, ["setAxiosStatus"]),
    onSubmit() {
      this.setAxiosStatus("ongoing");
      axios
        .post(`/api/merchant-company-details/${this.uniqueId}`, {
          merchant_nick: this.merchant_nick,
          company_name: this.company_name,
          company_legal_name: this.company_legal_name,
          business_type: this.business_type,
          street_address: this.street_address,
          city: this.city,
          country: this.countrySelect,
          state: this.state,
          zip: this.zip,
          VAT: this.vat,
        })
        .then((res) => {
          this.setAxiosStatus("updated");
          window.location.href = res.data.url;
        })
        .catch((err) => {
          this.setAxiosStatus("error");
          console.log(err);
        });
    },
  },
};
</script>
