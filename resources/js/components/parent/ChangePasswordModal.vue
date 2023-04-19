<template>
  <div class="m-3 rounded-md text-white">
    <button
      @click="showHideChangePassword()"
      class="rounded-md border border-transparent bg-red-600 p-2.5 shadow-sm hover:bg-red-700"
    >
      Change Password
    </button>
  </div>

  <TransitionRoot as="template" :show="this.isChangePasswordVisible">
    <DialogComponent
      as="div"
      class="relative z-10"
      @close="this.isChangePasswordVisible = false"
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
                  class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                  @click="this.isChangePasswordVisible = false"
                >
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <DialogTitle
                as="h3"
                class="text-center text-lg font-medium leading-6 text-gray-900"
                >Change password</DialogTitle
              >
              <div class="mt-2 text-center">
                <p class="text-sm text-gray-500">
                  Always use a password that you can easily remember.
                </p>
              </div>
              <ValidationForm
                @submit="onSubmit"
                class="flex flex-col items-center justify-center"
              >
                <div class="flex h-[10rem] flex-col justify-around">
                  <div>
                    <label
                      for="password"
                      class="block text-sm font-medium text-gray-700"
                      >Password</label
                    >
                    <div class="mt-1">
                      <Field
                        rules="required|min:8|upperAndLower"
                        type="password"
                        v-model="this.password"
                        name="password"
                        id="password"
                        autocomplete="change-password"
                        class="block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      />
                    </div>
                    <div class="mt-1 flex w-64">
                      <ErrorMessage
                        name="password"
                        class="text-sm text-red-500"
                      >
                      </ErrorMessage>
                    </div>
                  </div>

                  <div>
                    <label
                      for="confirmation"
                      class="block text-sm font-medium text-gray-700"
                      >Repeat password</label
                    >
                    <div class="mt-1">
                      <Field
                        :rules="{
                          confirmed: { target: this.password },
                          required: true,
                        }"
                        type="password"
                        v-model="this.password_confirmation"
                        name="confirmation"
                        id="confirmation"
                        autocomplete="password_confirmation"
                        class="block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      />
                    </div>
                    <div class="absolute">
                      <ErrorMessage
                        name="confirmation"
                        class="text-sm text-red-500"
                      >
                      </ErrorMessage>
                    </div>
                  </div>
                </div>
                <div class="flex items-center justify-center">
                  <div class="flex-1">
                    <button
                      class="mt-7 inline-flex min-w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                      <span class="flex items-center">
                        Save
                        <SpinnerAnimation
                          v-if="passwordUpdatingStatus === 'ongoing'"
                          class="absolute"
                        ></SpinnerAnimation>
                        <CheckIcon
                          v-if="passwordUpdatingStatus === 'updated'"
                          class="h-6 w-6 text-green-500"
                        ></CheckIcon>
                        <XMarkIcon
                          v-if="passwordUpdatingStatus === 'error'"
                          class="h-6 w-6 text-red-500"
                        ></XMarkIcon>
                      </span>
                    </button>
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
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon, CheckIcon } from "@heroicons/vue/24/outline";
import { mapActions, mapWritableState } from "pinia";
import { useModalStore } from "@/stores/useModalStore";
import { Field, Form as ValidationForm, ErrorMessage } from "vee-validate";
import SpinnerAnimation from "@/components/Ui/SpinnerAnimation.vue";
export default {
  components: {
    DialogComponent,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    XMarkIcon,
    Field,
    ValidationForm,
    ErrorMessage,
    SpinnerAnimation,
    CheckIcon,
  },
  data() {
    return {
      password: "",
      password_confirmation: "",
      passwordUpdatingStatus: null,
    };
  },
  props: {
    userId: {
      required: true,
      type: Number,
    },
  },
  computed: {
    ...mapWritableState(useModalStore, ["isChangePasswordVisible"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideChangePassword"]),
    onSubmit(values, actions) {
      this.passwordUpdatingStatus = "ongoing";
      axios
        .post(`/api/parent/update-password/${this.user_id}`, {
          password: this.password,
          password_confirmation: this.password_confirmation,
        })
        .then(() => {
          actions.resetForm();
          this.passwordUpdatingStatus = "updated";
          setTimeout(() => {
            this.passwordUpdatingStatus = null;
          }, 1500);
        })
        .catch(() => {
          this.passwordUpdatingStatus = "error";
          setTimeout(() => {
            this.passwordUpdatingStatus = null;
          }, 1500);
        });
    },
  },
};
</script>
