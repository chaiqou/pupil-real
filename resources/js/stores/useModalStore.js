import { defineStore } from "pinia";

export const useModalStore = defineStore("modal", {
    state: () => {
        return {
            isNavbarVisible: false,
            isMobileSwitchAccountVisible: false,
            isTwoFactorVisible: false,
            isChangePasswordVisible: false,
            isStudentEditVisible: false,
        };
    },
    actions: {
        showHideNavbar() {
            this.isNavbarVisible = !this.isNavbarVisible;
        },
        showHideMobileSwitchAccount() {
            this.isMobileSwitchAccountVisible = !this.isMobileSwitchAccountVisible;
        },
        showHideTwoFactor() {
            this.isTwoFactorVisible = !this.isTwoFactorVisible;
        },
        showHideChangePassword() {
            this.isChangePasswordVisible = !this.isChangePasswordVisible;
        },
        showHideStudentEdit() {
            this.isStudentEditVisible = !this.isStudentEditVisible;
        },
    },
});
