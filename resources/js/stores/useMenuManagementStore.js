import { defineStore } from "pinia";

export const useMenuManagementStore = defineStore("menu_management", {
    state: () => {
        return {
            toggleMenuManagementCard: false,
            toggleChoicesCard: false,
            toggleFixedCard: false,
            suitableLunch: [],
            selectedDay: "",
            claimables: [],
            lunchName: "",
        };
    },

    getters: {
        parsedClaimables() {
            return (claimable) =>
                JSON.parse(claimable).map((claim) =>
                    claim.split('"').join(" ")
                );
        },
    },
});
