import { defineStore } from "pinia";

export const useMenuManagementStore = defineStore("menu_management", {
    state: () => {
        return {
            toggle_card: false,
        };
    },
});
