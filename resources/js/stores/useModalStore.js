import { defineStore } from "pinia";

export const useModalStore = defineStore("modal", {
  state: () => {
    return {
      isNavbarVisible: false,
      isMobileSwitchAccountVisible: false,
      isTwoFactorVisible: false,
      isChangePasswordVisible: false,
      isStudentEditVisible: false,
      isInviteUserVisible: false,
      isSchoolEditVisible: false,
      isMerchantEditVisible: false,
      isInviteMerchantVisible: false,
      isCreateSchoolVisible: false,
      isTerminalCreateVisible: false,
      isQrCodeVisible: false,
    };
  },
  actions: {
    showHideNavbar() {
      this.isNavbarVisible = !this.isNavbarVisible;
    },
    showHideMobileSwitchAccount() {
      this.isMobileSwitchAccountVisible = !this.isMobileSwitchAccountVisible;
    },
    showHideSchoolCreate() {
      this.isCreateSchoolVisible = !this.isCreateSchoolVisible;
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
    showHideInviteUser() {
      this.isInviteUserVisible = !this.isInviteUserVisible;
    },
    showHideSchoolEdit() {
      this.isSchoolEditVisible = !this.isSchoolEditVisible;
    },
    showHideMerchantEdit() {
      this.isMerchantEditVisible = !this.isMerchantEditVisible;
    },
    showHideInviteMerchant() {
      this.isInviteMerchantVisible = !this.isInviteMerchantVisible;
    },
    showHideTerminalCreate() {
      this.isTerminalCreateVisible = !this.isTerminalCreateVisible;
    },
  },
});
