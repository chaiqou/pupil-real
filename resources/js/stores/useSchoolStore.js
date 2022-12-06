import { defineStore } from "pinia";

export const useSchoolStore = defineStore("school", {
    state: () => {
        return {
            isSchoolsLoaded: false,
            schools: [],
            school: [],
            schoolId: null,
            countrySelect: "",
        };
    },
    actions: {
        currentSchoolEdit(id) {
            this.schoolId = id;
        },
    }
});
