import { defineStore } from "pinia";

export const useMenuManagementStore = defineStore("menu_management", {
    state: () => {
        return {
            toggleMenuManagementCard: false,
            toggleChoicesCard: false,
            toggleFixedCard: false,
            suitableLunch: [],
            selectedDay: "",
        };
    },
});
