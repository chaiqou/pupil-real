<template>
  <TransitionRoot
    v-if="this.isRequestEndSuccessfully"
    as="template"
    :show="this.isStudentEditVisible"
  >
    <DialogComponent
      as="div"
      class="relative z-10"
      @close="
        this.isStudentEditVisible = false;
        this.studentId = null;
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
              class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
            >
              <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button
                  type="button"
                  class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                  @click="
                    this.isStudentEditVisible = false;
                    this.studentId = null;
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
                  this.studentId = null;
                "
                class="mt-8 w-full space-y-6"
              >
                <div class="bg-white p-8">
                  <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                      {{ $t("message.personal_information") }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                      {{
                        $t(
                          "message.use_a_permanent_address_where_you_can_receive_mail",
                        )
                      }}.
                    </p>
                  </div>
                  <div
                    class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6"
                  >
                    <div class="sm:col-span-2">
                      <label
                        for="last_name"
                        class="block text-sm font-medium text-gray-700"
                      >
                        {{ $t("message.last_name") }}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          required
                          v-model="this.studentForEdit.last_name"
                          name="last_name"
                          id="last_name"
                          autocomplete="given-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage></ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="first-name"
                        class="block text-sm font-medium text-gray-700"
                      >
                        {{ $t("message.first_name") }}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.studentForEdit.first_name"
                          required
                          name="first_name"
                          id="first_name"
                          autocomplete="family-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="first_name"
                          class="text-sm text-red-500"
                        >
                        </ErrorMessage>
                      </div>
                    </div>
                    <div class="sm:col-span-2">
                      <label
                        for="middle-name"
                        class="block text-sm font-medium text-gray-700"
                      >
                        {{ $t("message.middle_name") }}</label
                      >
                      <div class="mt-1">
                        <Field
                          type="text"
                          v-model="this.studentForEdit.middle_name"
                          name="middle_name"
                          id="middle_name"
                          autocomplete="additional-name"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="middle_name"
                          class="text-sm text-red-500"
                        ></ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-3">
                      <label
                        for="country"
                        class="block text-sm font-medium text-gray-700"
                      >
                        {{ $t("message.country") }}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          name="country"
                          v-model="this.studentForEdit.user_information.country"
                        >
                          <select
                            v-model="
                              this.studentForEdit.user_information.country
                            "
                            id="country"
                            name="country"
                            autocomplete="country-name"
                            class="block w-full rounded-md border-gray-300 px-4 py-1.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                          >
                            <CountryOptions></CountryOptions>
                          </select>
                        </Field>

                        <ErrorMessage
                          name="country"
                          class="text-sm text-red-500"
                        >
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-6">
                      <label
                        for="street_address"
                        class="block text-sm font-medium text-gray-700"
                      >
                        {{ $t("message.street_address") }}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          v-model="
                            this.studentForEdit.user_information.street_address
                          "
                          type="text"
                          name="street_address"
                          id="street_address"
                          autocomplete="street-address"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage
                          name="street_address"
                          class="text-sm text-red-500"
                        >
                        </ErrorMessage>
                      </div>
                    </div>

                    <div class="sm:col-span-2">
                      <label
                        for="city"
                        class="block text-sm font-medium text-gray-700"
                      >
                        {{ $t("message.city") }}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.studentForEdit.user_information.city"
                          name="city"
                          id="city"
                          autocomplete="address-level2"
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
                      >
                        {{ $t("message.state_province") }}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.studentForEdit.user_information.state"
                          name="state"
                          id="state"
                          autocomplete="address-level1"
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
                      >
                        {{ $t("message.zip_postal_code") }}</label
                      >
                      <div class="mt-1">
                        <Field
                          rules="required"
                          type="text"
                          v-model="this.studentForEdit.user_information.zip"
                          name="zip"
                          id="zip"
                          autocomplete="postal-code"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <ErrorMessage name="zip" class="text-sm text-red-500">
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
                        {{ $t("message.save") }}
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
import { useStudentStore } from "@/stores/useStudentStore";
import { useModalStore } from "@/stores/useModalStore";
import CountryOptions from "@/components/Ui/CountryOptions.vue";

export default {
  data() {
    return {
      isRequestEndSuccessfully: false,
    };
  },
  components: {
    CountryOptions,
    DialogComponent,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
    XMarkIcon,
    ValidationForm,
    Field,
    ErrorMessage,
  },
  computed: {
    ...mapWritableState(useStudentStore, [
      "studentForEdit",
      "studentId",
      "students",
    ]),
    ...mapWritableState(useModalStore, ["isStudentEditVisible"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideStudentEdit"]),
    onSubmit() {
      axios
        .post("/api/parent/update-student", {
          student_id: this.studentForEdit.id,
          first_name: this.studentForEdit.first_name,
          last_name: this.studentForEdit.last_name,
          middle_name: this.studentForEdit.middle_name,
          country: this.studentForEdit.user_information.country,
          city: this.studentForEdit.user_information.city,
          state: this.studentForEdit.user_information.state,
          street_address: this.studentForEdit.user_information.street_address,
          zip: this.studentForEdit.user_information.zip,
        })
        .then((res) => {
          this.students = res.data.data;
        })
        .finally(() => {
          this.isStudentEditVisible = false;
        });
    },
    handleGetStudentRequest() {
      axios.get(`/api/parent/student/${this.studentId}`).then((res) => {
        this.studentForEdit = res.data.data;
        this.isRequestEndSuccessfully = true;
      });
    },
  },
  created() {
    this.handleGetStudentRequest();
  },
};
</script>
