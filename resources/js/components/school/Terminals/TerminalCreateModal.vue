<template>
  <TransitionRoot as="template" :show="this.isTerminalCreateVisible">
    <Dialog
      as="div"
      class="relative z-10"
      @close="this.isTerminalCreateVisible = false"
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
                  @click="this.isTerminalCreateVisible = false"
                >
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <div class="absolute top-0 left-0 hidden pt-4 pl-4 sm:block">
                <p>Create a new terminal.</p>
              </div>

              <ValidationForm @submit="onSubmit" class="mt-10">
                <div
                  class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6"
                >
                  <div class="sm:col-span-3">
                    <label
                      for="name"
                      class="block text-sm font-medium text-gray-700"
                      >Name</label
                    >
                    <div class="mt-1">
                      <Field
                        rules="required"
                        v-model="this.name"
                        type="text"
                        name="name"
                        id="name"
                        autocomplete="name"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      />
                      <ErrorMessage name="name" class="text-sm text-red-500">
                        <p class="text-sm text-red-500">name is required</p>
                      </ErrorMessage>
                    </div>
                  </div>

                  <div class="sm:col-span-3">
                    <label
                      for="serial-number"
                      class="block text-sm font-medium text-gray-700"
                      >Serial number</label
                    >
                    <div class="mt-1">
                      <Field
                        rules="required|min:12|max:12"
                        v-model="this.serial_number"
                        type="text"
                        name="serial_number"
                        id="serial_number"
                        autocomplete="serial-number"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      />
                      <ErrorMessage
                        name="serial_number"
                        class="text-sm text-red-500"
                      >
                        <p class="text-sm text-red-500">
                          serial number is required
                        </p>
                      </ErrorMessage>
                    </div>
                  </div>

                  <div class="sm:col-span-6">
                    <label
                      for="note"
                      class="block text-sm font-medium text-gray-700"
                      >Note</label
                    >
                    <div class="mt-1">
                      <Field
                        v-model="this.note"
                        type="text"
                        name="note"
                        id="note"
                        autocomplete="note"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      />
                      <ErrorMessage name="note" class="text-sm text-red-500">
                        <p class="text-sm text-red-500">
                          this field is required
                        </p>
                      </ErrorMessage>
                    </div>
                  </div>
                </div>
                <button
                  class="mt-10 w-full rounded-md bg-indigo-600 px-3 py-2 text-white hover:bg-indigo-700"
                >
                  Create
                </button>
              </ValidationForm>
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
import { useModalStore } from "@/stores/useModalStore";
import { useTerminalStore } from "@/stores/useTerminalStore";
import { Field, Form as ValidationForm, ErrorMessage } from "vee-validate";
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
  },
  data() {
    return {
      name: "",
      serial_number: "",
      note: "",
    };
  },
  computed: {
    ...mapWritableState(useModalStore, [
      "isTerminalCreateVisible",
      "isQrCodeVisible",
      "isTerminalCreateVisible",
    ]),
    ...mapWritableState(useTerminalStore, ["QRKeys", "terminals"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideTerminalCreate"]),
    onSubmit(values, actions) {
      axios
        .post("/api/school/terminal", {
          public_key: "public_key",
          private_key: "private_key",
          name: this.name,
          serial_number: this.serial_number,
          note: this.note,
        })
        .then((res) => {
          this.isTerminalCreateVisible = false;
          this.isQrCodeVisible = true;
          this.terminals = res.data[1].data;
          this.QRKeys = JSON.stringify(res.data[0]);
          actions.setValues("");
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
