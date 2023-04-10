<template>
  <TransitionRoot
    v-if="this.isRequestEndSuccessfully"
    as="template"
    :show="this.isSchoolEditVisible"
  >
    <DialogComponent
      as="div"
      class="relative z-10"
      @close="
        this.isSchoolEditVisible = false;
        this.schoolId = null;
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
                    this.isSchoolEditVisible = false;
                    this.schoolId = null;
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
                  this.schoolId = null;
                "
                class="mt-8 w-full space-y-6"
              >
                <div class="bg-white p-8">
                  <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                      Personal Information
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                      Use a permanent address where you can receive mail.
                    </p>
                  </div>
                  <div
                    class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6"
                  >
                    <div class="sm:col-span-2">
                      <label
                        for="short-name"
                        class="block text-sm font-medium text-gray-700"
                        >Short name</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          required
                          v-model="this.school.short_name"
                          name="short_name"
                          id="short_name"
                          autocomplete="school-short-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="short_name">
                          <p class="text-sm text-red-500">
                            short name field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="full-name"
                        class="block text-sm font-medium text-gray-700"
                        >Full name</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.school.full_name"
                          required
                          name="first_name"
                          id="first_name"
                          autocomplete="school-full-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="full_name"
                          class="text-sm text-red-500"
                        >
                          <p class="text-sm text-red-500">
                            full name field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>
                    <div class="sm:col-span-2">
                      <label
                        for="long-name"
                        class="block text-sm font-medium text-gray-700"
                        >Long name</label
                      >
                      <div class="mt-1">
                        <Field
                          type="text"
                          v-model="this.school.long_name"
                          name="long_name"
                          id="long_name"
                          autocomplete="school-long-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="long_name"
                          class="text-sm text-red-500"
                        ></ErrorMessage>
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
                          v-model="this.street_address"
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
                          <p class="text-sm text-red-500">
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
                          v-model="this.city"
                          type="text"
                          name="city"
                          id="city"
                          autocomplete="city"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="city" class="text-sm text-red-500">
                          <p class="text-sm text-red-500">
                            city field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="state"
                        class="block text-sm font-medium text-gray-700"
                        >State</label
                      >
                      <div class="mt-1">
                        <Field
                          v-model="this.state"
                          type="text"
                          name="state"
                          id="state"
                          autocomplete="state"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="state" class="text-sm text-red-500">
                          <p class="text-sm text-red-500">
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
                          v-model="this.zip"
                          type="text"
                          name="zip"
                          id="zip"
                          autocomplete="zip"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="zip" class="text-sm text-red-500">
                          <p class="text-sm text-red-500">
                            this field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-3">
                      <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required|email"
                          type="text"
                          v-model="this.email"
                          name="email"
                          id="email"
                          autocomplete="school-email"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="email" class="text-sm text-red-500">
                          <p class="text-sm text-red-500">
                            email field is required in email format
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-3">
                      <label
                        for="contact"
                        class="block text-sm font-medium text-gray-700"
                        >Contact person</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.contact_person"
                          name="contact"
                          id="contact"
                          autocomplete="contact"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="contact"
                          class="text-sm text-red-500"
                        >
                          <p class="text-sm text-red-500">
                            this field is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="phone-number"
                        class="block text-sm font-medium text-gray-700"
                        >Phone number</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required|phone"
                          type="text"
                          v-model="this.phone_number"
                          name="phone_number"
                          id="phone_number"
                          autocomplete="phone-number"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="phone_number"
                          class="text-sm text-red-500"
                        >
                          <p class="text-sm text-red-500">
                            phone number is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="extension"
                        class="block text-sm font-medium text-gray-700"
                        >Extension</label
                      >
                      <div class="mt-1">
                        <Field
                          type="text"
                          v-model="this.extension"
                          name="extension"
                          id="extension"
                          autocomplete="extension"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="extension"
                          class="text-sm text-red-500"
                        >
                          <p class="text-sm text-red-500">
                            extension is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="mobile-number"
                        class="block text-sm font-medium text-gray-700"
                        >Mobile number</label
                      >
                      <div class="mt-1">
                        <Field
                          type="text"
                          v-model="this.mobile_number"
                          name="mobile_number"
                          id="mobile_number"
                          autocomplete="mobile-number"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="mobile_number"
                          class="text-sm text-red-500"
                        >
                          <p class="text-sm text-red-500">
                            mobile number is required
                          </p>
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-6">
                      <label
                        for="school-code"
                        class="block text-sm font-medium text-gray-700"
                        >School code</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required|min-words-3"
                          v-model="this.school.school_code"
                          type="text"
                          name="school_code"
                          id="school_code"
                          autocomplete="school-code"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="school_code"
                          class="text-sm text-red-500"
                        >
                          <p class="text-sm text-red-500">
                            school code is required
                          </p>
                        </ErrorMessage>
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
import { useSchoolStore } from "@/stores/useSchoolStore";
import { useModalStore } from "@/stores/useModalStore";
import { useGlobalStore } from "@/stores/useGlobalStore";
import CountriesSelect from "@/components/Ui/CountriesSelect.vue";

export default {
  data() {
    return {
      isRequestEndSuccessfully: false,
      email: "",
      street_address: "",
      phone_number: "",
      mobile_number: "",
      extension: "",
      contact_person: "",
      zip: "",
      city: "",
      state: "",
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
  },
  computed: {
    ...mapWritableState(useSchoolStore, ["school", "schoolId", "schools"]),
    ...mapWritableState(useGlobalStore, ["countrySelect"]),
    ...mapWritableState(useModalStore, ["isSchoolEditVisible"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideSchoolEdit"]),
    onSubmit() {
      axios
        .put("/api/admin/school", {
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
          country: this.countrySelect,
          zip: this.zip,
          city: this.city,
          state: this.state,
          school_code: this.school.school_code,
        })
        .then((res) => {
          this.schools = res.data.data;
          this.countrySelect = "";
        })
        .catch((err) => console.log(err))
        .finally(() => {
          this.isSchoolEditVisible = false;
        });
    },
    handleGetSchoolRequest() {
      axios
        .get(`/api/admin/school/${this.schoolId}`)
        .then((res) => {
          this.school = res.data.data;
          this.email = this.school.details.email;
          this.contact_person = this.school.details.contact_person;
          this.phone_number = this.school.details.phone_number;
          this.mobile_number = this.school.details.mobile_number;
          this.extension = this.school.details.extension;
          this.street_address = this.school.details.street_address;
          this.countrySelect = this.school.details.country;
          this.zip = this.school.details.zip;
          this.city = this.school.details.city;
          this.state = this.school.details.state;
        })
        .finally(() => (this.isRequestEndSuccessfully = true));
    },
  },
  created() {
    this.handleGetSchoolRequest();
  },
};
</script>
