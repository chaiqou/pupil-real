<template>
  <TransitionRoot as="template" :show="this.isInviteMerchantVisible">
    <Dialog
      as="div"
      class="relative z-10"
      @close="
        this.isInviteMerchantVisible = false;
        this.chosenSchool = null;
        this.email = null;
        this.backResponse = null;
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
                    this.isInviteMerchantVisible = false;
                    this.chosenSchool = null;
                    this.email = null;
                    this.backResponse = null;
                  "
                >
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <div class="absolute top-0 left-0 hidden pt-4 pl-4 sm:block">
                <p>Invite merchant by email address.</p>
              </div>
              <div class="mt-10">
                <ValidationForm @submit="onSubmit">
                  <div class="flex flex-col">
                    <label
                      class="text-md flex whitespace-normal font-bold text-gray-600"
                      for="email"
                      >Email</label
                    >
                    <Field
                      v-slot="{ resetField }"
                      name="email"
                      v-model="email"
                      placeholder="email"
                      type="text"
                      rules="email"
                      autocomplete="email"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                    </Field>
                    <ErrorMessage name="email" class="mt-2 text-red-500">
                    </ErrorMessage>

                    <p class="mt-1 text-sm text-red-500">
                      {{ this.backResponse }}
                    </p>

                    <button
                      :disabled="disabledCalculator"
                      type="submit"
                      :class="
                        disabledCalculator
                          ? 'mt-10 w-full rounded-md bg-indigo-600 px-5 py-2 text-white opacity-60 hover:bg-indigo-700'
                          : 'mt-10 w-full rounded-md bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700'
                      "
                    >
                      <svg
                        v-if="this.isSuccessfullySent === 'pending'"
                        class="mr-2 inline h-6 w-6 animate-spin fill-blue-600 text-gray-200 dark:text-gray-600"
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
                      <CheckIcon
                        v-if="this.isSuccessfullySent === 'yes'"
                        class="mr-2 inline h-6 w-6"
                      ></CheckIcon>
                      {{ buttonTextGenerator }}
                    </button>
                  </div>
                </ValidationForm>
              </div>
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
import {
  ExclamationTriangleIcon,
  XMarkIcon,
  CheckIcon,
} from "@heroicons/vue/24/outline";
import { mapActions, mapWritableState } from "pinia";
import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import { useModalStore } from "@/stores/useModalStore";
import { useMerchantStore } from "@/stores/useMerchantStore";
import { useInviteStore } from "@/stores/useInviteStore";

export default {
  components: {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    ExclamationTriangleIcon,
    XMarkIcon,
    ValidationForm,
    Field,
    ErrorMessage,
    CheckIcon,
  },
  data() {
    return {
      email: "",
      isSent: false,
      isSuccessfullySent: null,
      backResponse: "",
    };
  },
  props: {
    schoolId: {
      required: true,
      type: Number,
    },
  },
  computed: {
    ...mapWritableState(useModalStore, ["isInviteMerchantVisible"]),
    ...mapWritableState(useMerchantStore, ["inviteEmail"]),
    ...mapWritableState(useInviteStore, ["invites"]),
    buttonTextGenerator() {
      return this.isSuccessfullySent === "pending"
        ? "Sending..."
        : this.isSuccessfullySent === "yes"
        ? "Sent"
        : this.isSuccessfullySent === "no"
        ? "Failed"
        : "Send";
    },
    disabledCalculator() {
      if (this.isSent === true) {
        return true;
      }
      return false;
    },
    axiosResponseGenerator() {
      const text = this.isSuccessfullySent;
      if (text === "pending") {
        return "Please wait, we are sending invites.";
      }
      if (text === "yes") {
        return "Invites send successfully!";
      }
      if (text === "no") {
        return "Could not send invites at the moment, please try again later, or text to support.";
      }
    },
  },
  methods: {
    ...mapActions(useModalStore, ["showHideInviteMerchant"]),
    onSubmit(values, actions) {
      actions.setFieldValue("email", "");
      this.isSent = true;
      this.isSuccessfullySent = "pending";
      this.backResponse = "";
      axios
        .post(`/api/admin/school/${this.schoolId}/merchant/send-invite`, {
          email: this.email,
        })
        .then((res) => {
          this.isSuccessfullySent = "yes";
          this.invites = res.data.data;
          this.invites.map((item) => {
            item.created_at = item.created_at
              .substring(0, 16)
              .replaceAll("T", " ");
            item.updated_at = item.updated_at
              .substring(0, 16)
              .replaceAll("T", " ");
          });
        })
        .catch((err) => {
          this.isSuccessfullySent = "no";
          this.backResponse = err.response.data.message;
        })
        .finally(() =>
          setTimeout(() => {
            this.isSent = false;
            this.isSuccessfullySent = null;
          }, 5000),
        );
    },
  },
};
</script>
