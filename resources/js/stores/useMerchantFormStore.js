import { defineStore } from "pinia";

export const useMerchantFormStore = defineStore("merchantForm", {
    state: () => {
        return {
            radioDay: "",
            date: "",
            holds: "",
            extras: "",
            title: "",
            description: "",
            period: "",
            tags: ["Breakfest", "test"],
        };
    },
});
