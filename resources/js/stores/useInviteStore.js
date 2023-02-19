import { defineStore } from "pinia";

export const useInviteStore = defineStore("invite", {
  state: () => {
    return {
      isInvitesLoaded: false,
      invites: [],
      invite: [],
      invite_from: [],
      schools: [],
      chosenSchool: "",
    };
  },
});
