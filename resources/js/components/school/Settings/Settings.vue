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
          <div class="mt-1">
            <Field
              rules="required"
              type="text"
              v-model="billingo_api_key"
              name="billingo_api_key"
              id="billingo_api_key"
              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              :placeholder="$t('message.enter_your_billingo_api_key_here')"
            />
            <ErrorMessage
              class="text-sm text-red-500"
              name="billingo_api_key"
            ></ErrorMessage>
            <p class="text-sm text-red-500">{{ errorData }}</p>
          </div>
        </div>
        <ButtonForAxios
          classOngoing="bg-indigo-600 mt-3 flex justify-center opacity-30 text-white px-3 py-2 w-full rounded-md hover:bg-indigo-700"
          classDefault="bg-indigo-600 mt-3 text-white flex justify-center px-3 py-2 w-full rounded-md hover:bg-indigo-700"
        >
          {{ $t("message.submit") }}
        </ButtonForAxios>
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
    handleUpdateBillingoApiKeyRequest(values, actions) {
      this.setAxiosStatus("ongoing");
      axios
        .post("/api/school/update-billingo-api-key", {
          billingo_api_key: this.billingo_api_key,
        })
        .then((res) => {
          actions.setFieldValue("billingo_api_key", "");
          this.setAxiosStatus("updated");
          this.errorData = null;
          console.log(res);
        })
        .catch((err) => {
          this.setAxiosStatus("error");
          console.log(err.response.data.message);
          this.errorData = err.response.data.message;
        });
    },
  },
};
</script>
