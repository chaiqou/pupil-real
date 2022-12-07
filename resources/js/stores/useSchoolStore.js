import { defineStore } from "pinia";

export const useSchoolStore = defineStore("school", {
    state: () => {
        return {
            isSchoolsLoaded: false,
            schools: [],
            school: [],
            schoolId: null,
        };
    },
    actions: {
        currentSchoolEdit(id) {
            this.schoolId = id;
        },
    }
});
