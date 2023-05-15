<template>
  <h1 class="mt-10 ml-10 text-2xl font-bold">{{ $t("message.settings") }}</h1>

  <div class="m-10">
    <h1>{{ $t("message.change_language") }}</h1>
    <div class="mt-2 w-32">
      <SetLanguage :userId="userId"></SetLanguage>
    </div>
    <div class="mt-5 w-[15rem]">
      <ValidationForm @submit="handleUpdateBillingoApiKeyRequest">
        <div>
          <label
            for="billingo-api-key"
            class="block text-sm font-medium text-gray-700"
            >{{ $t("message.billingo_key") }}</label
          >
          <div class="mt-1 flex items-center">
            <Field
              rules="required"
              type="text"
              :disabled="billingoStatus === 0"
              v-model="billingo_api_key"
              name="billingo_api_key"
              id="billingo_api_key"
              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              :placeholder="$t('message.enter_your_billingo_api_key')"
            />
            <ButtonForAxios
              classOngoing="bg-indigo-600 ml-1.5 flex justify-center opacity-30 text-white px-1.5 py-1 rounded-md hover:bg-indigo-700"
              classDefault="bg-indigo-600 ml-1.5 text-white flex justify-center px-1.5 py-1 rounded-md hover:bg-indigo-700"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-6 w-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"
                />
              </svg>
            </ButtonForAxios>
          </div>
          <ErrorMessage
            class="text-sm text-red-500"
            name="billingo_api_key"
          ></ErrorMessage>

          <p class="text-sm text-red-500">{{ errorData }}</p>
          <p class="mt-1.5 text-sm text-gray-400" v-if="billingoStatus === 0">
            {{
              $t(
                "message.this_field_will_activate_only_when_your_billingo_api_key_will_not_work_in_this_case_people_will_not_be_able_to_pay_with_pay_with_transfer_type_and_only_stripe_will_be_available_you_will_get_an_email_if_something_will_go_wrong_with_your_billingo_api_key",
              )
            }}.
          </p>
        </div>
      </ValidationForm>
    </div>
  </div>
</template>

<script>
import SetLanguage from "@/components/Ui/SetLanguage.vue";
import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import ButtonForAxios from "@/components/Ui/ButtonForAxios.vue";
import { mapActions } from "pinia";
import { useGlobalStore } from "@/stores/useGlobalStore";

export default {
  components: {
    ButtonForAxios,
    SetLanguage,
    ValidationForm,
    Field,
    ErrorMessage,
  },
  data() {
    return {
      billingo_api_key: "",
      errorData: null,
      billingoStatus: false,
      billingoKeyStatusExplanationText: null,
    };
  },
  props: {
    userId: {
      type: Number,
      required: true,
    },
  },
  methods: {
    ...mapActions(useGlobalStore, ["setAxiosStatus"]),
    handleCheckBillingoApiKeyStatusRequest() {
      axios
        .get("/api/school/billingo-api-key-status")
        .then((res) => {
          this.billingoStatus = res.data.status;
          console.log(res.data.status);
        })
        .catch((err) => console.log(err));
    },
    handleUpdateBillingoApiKeyRequest(values, actions) {
      this.setAxiosStatus("ongoing");
      axios
        .put("/api/school/billingo-api-key", {
          billingo_api_key: this.billingo_api_key,
        })
        .then(() => {
          actions.setFieldValue("billingo_api_key", "");
          this.setAxiosStatus("updated");
          this.errorData = null;
        })
        .catch((err) => {
          this.setAxiosStatus("error");
          this.errorData = err.response.data.message;
        });
    },
  },
  mounted() {
    this.handleCheckBillingoApiKeyStatusRequest();
  },
};
</script>
