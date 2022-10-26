import { defineStore } from "pinia";

export const useStudentStore = defineStore("student", {
    state: () => {
        return {
            isStudentsLoaded: false,
            isSlideOverOpen: false,
            students: [],
            student: [],
        };
    },
    actions: {
        showHideSlideOver(id) {
            this.isSlideOverOpen = !this.isSlideOverOpen;
            this.student = this.students.find(item => item.id === id)
        }
    }
});
