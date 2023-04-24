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
            $t("message.company_details")
          }}</span>
        </div>
      </li>

      <li class="relative md:flex md:flex-1">
        <div
          class="flex items-center px-6 py-4 text-sm font-medium"
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
            $t("message.stripe")
          }}</span>
        </div>
      </li>

      <li class="relative md:flex md:flex-1">
        <div
          class="flex items-center px-6 py-4 text-sm font-medium"
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
            $t("message.verify_billingo")
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
            <span class="text-indigo-600">06</span>
          </span>
          <span class="ml-4 text-sm font-medium text-indigo-600">{{
            $t("message.verify_account")
          }}</span>
        </div>
      </li>
    </ol>
  </nav>
  <div class="mt-8">
    <img
      class="mx-auto h-16 w-auto"
      src="@/components/images/pupilpay-black-color.png"
      alt="PupilPay"
    />
    <h2
      class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900"
    >
      {{ $t("message.verify_your_email") }}
    </h2>
    <p class="mt-2 text-center text-sm text-gray-600">
      {{ $t("message.enter_the") }}
      <span class="font-semibold text-indigo-600 hover:text-indigo-500"
        >6-{{ $t("message.digit") }}</span
      >
      {{ $t("message.verification_code_sent_to") }} {{ this.inviteEmail }}.
    </p>
    <p class="mt-2 text-center text-xs text-gray-600">
      {{
        $t(
          "message.if_you_cant_find_the_email_in_a_few_minutes_check_your_spam_folder",
        )
      }}.
    </p>
    <div class="mt-6 flex items-center justify-center">
      <ButtonForAxios
        @click="handleResendVerificationCodeRequest()"
        :globalStoreSolution="false"
        :status="axiosResendEmailStatus"
        classOngoing="flex opacity-30 items-center w-fit justify-center rounded-md border border-transparent text-sm font-medium text-indigo-600 hover:text-indigo-900"
        classDefault="flex items-center w-fit justify-center rounded-md border border-transparent text-sm font-medium text-indigo-600 hover:text-indigo-900"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="mr-1 h-6 w-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
          />
        </svg>
        {{ $t("message.resend_code") }}
      </ButtonForAxios>
    </div>
  </div>
  <div class="w-full">
    <ValidationForm
      v-slot="{ errors }"
      @submit="onSubmit()"
      @paste="handlePaste"
      id="form"
      name="inviteTwoFaForm"
      class="mt-8 w-full space-y-6"
    >
      <div class="-space-y-px rounded-md border border-gray-200 p-4 shadow-sm">
        <div class="row-start-2 grid grid-cols-6">
          <Field
            type="text"
            rules="required"
            @keyup="stepForward(1)"
            @keydown.delete="stepBack($event, 1)"
            @click="resetValue(1)"
            id="sc-1"
            name="verification_code[0]"
            @input="checkInputLengths()"
            class="mx-2 flex h-14 w-10 items-center rounded-lg border bg-gray-50 text-center font-mono text-xl uppercase"
            placeholder="*"
            v-model="verification_code[0]"
          />
          <Field
            type="text"
            rules="required"
            @keyup="stepForward(2)"
            @keydown.delete="stepBack($event, 2)"
            @click="resetValue(2)"
            id="sc-2"
            name="verification_code[1]"
            @input="checkInputLengths()"
            class="mx-2 flex h-14 w-10 items-center rounded-lg border bg-gray-50 text-center font-mono text-xl uppercase"
            placeholder="*"
            v-model="verification_code[1]"
          />
          <Field
            type="text"
            rules="required"
            @keyup="stepForward(3)"
            @keydown.delete="stepBack($event, 3)"
            @click="resetValue(3)"
            id="sc-3"
            name="verification_code[2]"
            @input="checkInputLengths()"
            class="mx-2 flex h-14 w-10 items-center rounded-lg border bg-gray-50 text-center font-mono text-xl uppercase"
            placeholder="*"
            v-model="verification_code[2]"
          />
          <Field
            type="text"
            rules="required"
            @keyup="stepForward(4)"
            @keydown.delete="stepBack($event, 4)"
            @click="resetValue(4)"
            id="sc-4"
            name="verification_code[3]"
            @input="checkInputLengths()"
            class="mx-2 flex h-14 w-10 items-center rounded-lg border bg-gray-50 text-center font-mono text-xl uppercase"
            placeholder="*"
            v-model="verification_code[3]"
          />
          <Field
            type="text"
            rules="required"
            @keyup="stepForward(5)"
            @keydown.delete="stepBack($event, 5)"
            @click="resetValue(5)"
            id="sc-5"
            name="verification_code[4]"
            @input="checkInputLengths()"
            class="mx-2 flex h-14 w-10 items-center rounded-lg border bg-gray-50 text-center font-mono text-xl uppercase"
            placeholder="*"
            v-model="verification_code[4]"
          />
          <Field
            type="text"
            rules="required"
            @keyup="stepForward(6)"
            @keydown.delete="stepBack($event, 6)"
            @click="resetValue(6)"
            id="sc-6"
            name="verification_code[5]"
            @input="checkInputLengths()"
            class="mx-2 flex h-14 w-10 items-center rounded-lg border bg-gray-50 text-center font-mono text-xl uppercase"
            placeholder="*"
            v-model="verification_code[5]"
          />
        </div>
      </div>
      <p class="text-sm text-red-500" v-if="Object.keys(errors).length">
        {{ $t("message.please_fill_all_fields") }}
      </p>
      <p class="text-sm text-red-500">{{ axiosResponse }}</p>
      <div>
        <ButtonForAxios
          classOngoing="group opacity-30 relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          classDefault="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg
              class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M1 6a3 3 0 013-3h12a3 3 0 013 3v8a3 3 0 01-3 3H4a3 3 0 01-3-3V6zm4 1.5a2 2 0 114 0 2 2 0 01-4 0zm2 3a4 4 0 00-3.665 2.395.75.75 0 00.416 1A8.98 8.98 0 007 14.5a8.98 8.98 0 003.249-.604.75.75 0 00.416-1.001A4.001 4.001 0 007 10.5zm5-3.75a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75zm0 6.5a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75zm.75-4a.75.75 0 000 1.5h2.5a.75.75 0 000-1.5h-2.5z"
                clip-rule="evenodd"
              />
            </svg>
          </span>
          {{ $t("message.verify") }}
        </ButtonForAxios>
      </div>
    </ValidationForm>
  </div>
</template>

<script>
import { Form as ValidationForm, Field } from "vee-validate";
import ButtonForAxios from "@/components/Ui/ButtonForAxios.vue";
import { mapActions } from "pinia";
import { useGlobalStore } from "@/stores/useGlobalStore";

export default {
  components: {
    ButtonForAxios,
    ValidationForm,
    Field,
  },
  data() {
    return {
      axiosResponse: "",
      verification_code: [""],
      axiosResendEmailStatus: "",
    };
  },
  props: {
    uniqueId: {
      type: String,
      required: true,
    },
    inviteEmail: {
      type: String,
      required: true,
    },
  },
  methods: {
    ...mapActions(useGlobalStore, ["setAxiosStatus"]),
    setAxiosStatusResendEmail(status) {
      this.axiosResendEmailStatus = status;
      if (status === "updated") {
        setTimeout(() => {
          this.resetAxiosStatusResendEmail();
        }, 2300);
      } else if (status === "error") {
        setTimeout(() => {
          this.resetAxiosStatusResendEmail();
        }, 2300);
      }
    },
    resetAxiosStatusResendEmail() {
      this.axiosResendEmailStatus = "";
    },
    handleResendVerificationCodeRequest() {
      this.setAxiosStatusResendEmail("ongoing");
      axios
        .post(`/api/resend-onboarding-verification/${this.uniqueId}`, {
          route: "merchant-verify.email",
        })
        .then((res) => {
          this.setAxiosStatusResendEmail("updated");
          console.log(res.data);
        })
        .catch((err) => {
          this.setAxiosStatusResendEmail("error");
          console.log(err);
        });
    },
    onSubmit() {
      this.setAxiosStatus("ongoing");
      axios
        .post(`/api/merchant-verify-email/${this.uniqueId}`, {
          verification_code: [
            document.forms["inviteTwoFaForm"]["verification_code[0]"].value,
            document.forms["inviteTwoFaForm"]["verification_code[1]"].value,
            document.forms["inviteTwoFaForm"]["verification_code[2]"].value,
            document.forms["inviteTwoFaForm"]["verification_code[3]"].value,
            document.forms["inviteTwoFaForm"]["verification_code[4]"].value,
            document.forms["inviteTwoFaForm"]["verification_code[5]"].value,
          ],
        })
        .then((res) => {
          this.setAxiosStatus("updated");
          window.location.href = res.data.url;
        })
        .catch((error) => {
          this.setAxiosStatus("error");
          console.log(error);
          this.axiosResponse = error.response.data.message;
        });
    },
    handlePaste(event) {
      const inputs = document.querySelectorAll('input[id^="sc-"]');
      const inputsFilled = Array.from(inputs).every((input) => input.value);

      if (!inputsFilled) {
        // Only allow paste if all inputs are empty
        const pastedValue = event.clipboardData.getData("text");
        if (pastedValue.length === 6 && /^\d+$/.test(pastedValue)) {
          const codeArray = pastedValue.split("");
          for (let i = 0; i < codeArray.length; i++) {
            this.verification_code[i] = codeArray[i];
            inputs[i].value = codeArray[i];
          }
        }
        document.getElementById("sc-6").focus();
        // Check if all inputs are filled
        if (this.verification_code.every((code) => code)) {
          window.onPasteTimeout = setTimeout(() => {
            this.onSubmit();
          }, 2300);
        } else {
          document.getElementById("sc-1").focus();
        }
      }
      event.preventDefault();
    },
    checkInputLengths() {
      const inputOne = document.getElementById("sc-1").value.length;
      const inputTwo = document.getElementById("sc-2").value.length;
      const inputThree = document.getElementById("sc-3").value.length;
      const inputFour = document.getElementById("sc-4").value.length;
      const inputFive = document.getElementById("sc-5").value.length;
      const inputSix = document.getElementById("sc-6").value.length;

      if (
        inputOne &&
        inputTwo &&
        inputThree &&
        inputFour &&
        inputFive &&
        inputSix
      ) {
        window.onInputTimeout = setTimeout(function () {
          this.onSubmit();
        }, 2000);
      }
    },

    resetValue(i) {
      //Reset sc-n if it equals or is higher than i
      clearTimeout(window.onInputTimeout);
      clearTimeout(window.onPasteTimeout);
      for (let j = i; j <= 6; j++) {
        document.getElementById("sc-" + j).value = "";
      }
    },

    stepForward(i) {
      if (document.getElementById("sc-" + i).value.length !== 1) {
        document.getElementById("sc-" + i).value = "";
      } else {
        if (i !== 6) {
          document.getElementById("sc-" + i).value = document
            .getElementById("sc-" + i)
            .value.toUpperCase();
          document.getElementById("sc-" + (i + 1)).focus();
        }
      }
    },

    stepBack(evtobj, i) {
      // If sender pressed backspace, reset sc-i and focus on sc-i-1
      clearTimeout(window.onPasteTimeout);
      clearTimeout(window.onInputTimeout);
      if (evtobj.keyCode === 8) {
        const currentInput = document.getElementById("sc-" + i);
        currentInput.value = "";
        if (i > 1) {
          const prevInput = document.getElementById("sc-" + (i - 1));
          if (prevInput) {
            prevInput.focus();
          }
        }
      }
    },
  },
  mounted() {
    window.onload = function () {
      document.getElementById("sc-1").focus();
    };
  },
};
</script>
