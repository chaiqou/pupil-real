import { defineStore } from "pinia";

export const useModalStore = defineStore("modal", {
    state: () => {
        return {
            isNavbarVisible: false,
            isMobileSwitchAccountVisible: false,
        };
    },
    actions: {
        showHideNavbar() {
            this.isNavbarVisible = !this.isNavbarVisible;
        },
        showHideMobileSwitchAccount() {
            this.isMobileSwitchAccountVisible = !this.isMobileSwitchAccountVisible;
        },
    },
});
