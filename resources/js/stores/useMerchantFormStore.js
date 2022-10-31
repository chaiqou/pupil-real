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

    actions: {
        addTag(tag) {
            this.tags.push(tag);
        },
        removeTag(index) {
            this.tags.splice(index, 1);
        },
    },
});
