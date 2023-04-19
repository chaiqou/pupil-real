<template>
  <nav aria-label="Progress">
    <ol
      role="list"
      class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:w-fit md:divide-y-0"
    >
      <li class="relative md:flex md:flex-1">
        <div class="group flex w-full items-center">
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

      <li class="relative md:flex md:flex-1">
        <div
          class="flex items-center px-6 py-4 text-sm font-medium"
          aria-current="step"
        >
          <span
            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600"
          >
            <span class="text-indigo-600">02</span>
          </span>
          <span class="ml-4 text-sm font-medium text-indigo-600">{{
            $t("message.personal_information")
          }}</span>
        </div>
      </li>

      <li class="relative md:flex md:flex-1">
        <div class="group flex items-center">
          <span class="flex items-center px-6 py-4 text-sm font-medium">
            <span
              class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300"
            >
              <span class="text-gray-500">03</span>
            </span>
            <span class="ml-4 text-sm font-medium text-gray-500">{{
              $t("message.setup_card")
            }}</span>
          </span>
        </div>
      </li>

      <li class="relative md:flex md:flex-1">
        <div class="group flex items-center">
          <span class="flex items-center px-6 py-4 text-sm font-medium">
            <span
              class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300"
            >
              <span class="text-gray-500">04</span>
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
      {{ $t("message.fill_out_your_personal_information") }}
    </h2>
  </div>
  <div>
    <ValidationForm @submit="onSubmit" class="mt-8 space-y-6 lg:w-[35rem]">
      <div class="bg-white p-8">
        <div>
          <h3 class="text-lg font-medium leading-6 text-gray-900">
            {{ $t("message.personal_information") }}
          </h3>
          <p class="mt-1 text-sm text-gray-500">
            {{
              $t("message.use_a_permanent_address_where_you_can_receive_mail")
            }}.
          </p>
        </div>
        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
          <div class="sm:col-span-2">
            <label
              for="last-name"
              class="block text-sm font-medium text-gray-700"
              >{{ $t("message.last_name") }}</label
            >
            <div class="mt-1">
              <Field
                v-model="last_name"
                type="text"
                rules="required"
                name="last_name"
                id="last_name"
                autocomplete="given-name"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="last_name"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-2">
            <label
              for="first-name"
              class="block text-sm font-medium text-gray-700"
              >{{ $t("message.first_name") }}</label
            >
            <div class="mt-1">
              <Field
                v-model="first_name"
                type="text"
                rules="required"
                required
                name="first_name"
                id="first_name"
                autocomplete="family-name"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="first_name"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>
          <div class="sm:col-span-2">
            <label
              for="middle-name"
              class="block text-sm font-medium text-gray-700"
              >{{ $t("message.middle_name") }}</label
            >
            <div class="mt-1">
              <Field
                v-model="middle_name"
                type="text"
                name="middle_name"
                id="middle_name"
                autocomplete="additional-name"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
              <ErrorMessage
                name="middle_name"
                class="text-xs text-red-500"
              ></ErrorMessage>
            </div>
          </div>

          <div class="sm:col-span-3">
            <CountriesSelect></CountriesSelect>
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
import { mapWritableState, mapActions } from "pinia";
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
      last_name: "",
      first_name: "",
      middle_name: "",
      street_address: "",
      city: "",
      state: "",
      zip: "",
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
        .post(`/api/parent-personal-form/${this.uniqueId}`, {
          last_name: this.last_name,
          first_name: this.first_name,
          middle_name: this.middle_name,
          street_address: this.street_address,
          city: this.city,
          country: this.countrySelect,
          state: this.state,
          zip: this.zip,
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
