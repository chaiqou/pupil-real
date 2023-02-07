import { defineStore } from "pinia";

export const useMenuManagementStore = defineStore("menu_management", {
    state: () => {
        return {
            toggleCard: false,
            suitableLunch: [],
        };
    },
});
