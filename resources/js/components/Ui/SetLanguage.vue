<template>
  <label for="language" class="sr-only">Language</label>
  <select
    v-model="language"
    @change="
      storeLocaleInLocalStorage(language);
      setLocale();
    "
    required
    id="language"
    name="language"
    autocomplete="language"
    class="relative block w-full appearance-none rounded-md border border-gray-300 py-2 pr-8 pl-3 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
  >
    <option value="en">{{ $t("message.english") }}</option>
    <option value="hu">{{ $t("message.hungary") }}</option>
  </select>
</template>
<script>
import { mapActions, mapWritableState } from "pinia";
import { useGlobalStore } from "@/stores/useGlobalStore";
import { setLocale as setVeeValidateLocale } from "@vee-validate/i18n";
export default {
  computed: {
    ...mapWritableState(useGlobalStore, ["language"]),
  },
  props: {
    userId: {
      type: Number,
      required: true,
    },
  },
  methods: {
    ...mapActions(useGlobalStore, ["storeLocaleInLocalStorage"]),
    setLocale() {
      this.$i18n.locale = this.language;
      setVeeValidateLocale(this.language);
      this.handleChangeLanguageRequest();
    },
    handleChangeLanguageRequest() {
      axios
        .get(`/api/${this.userId}/set-language/${this.language}`)
        .then((res) => {
          console.log(res.data);
        })
        .catch((err) => console.log(err));
    },
  },

  mounted() {
    setVeeValidateLocale(localStorage.getItem("i18n") || "en");
  },
};
</script>
