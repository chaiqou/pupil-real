import { defineStore } from "pinia";
export const useGlobalStore = defineStore("global", {
  state: () => {
    return {
      countrySelect: "",
      axiosStatus: "",
      language: localStorage.getItem("i18n") || "en",
      user: "",
    };
  },
  actions: {
    setAxiosStatus(status) {
      this.axiosStatus = status;
      if (status === "updated") {
        setTimeout(() => {
          this.resetAxiosStatus();
        }, 2300);
      } else if (status === "error") {
        setTimeout(() => {
          this.resetAxiosStatus();
        }, 2300);
      }
    },
    resetAxiosStatus() {
      this.axiosStatus = "";
    },
    storeLocaleInLocalStorage(locale) {
      localStorage.setItem("i18n", locale);
    },
  },
});
