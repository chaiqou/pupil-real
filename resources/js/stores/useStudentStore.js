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
        showHideSlideOver() {
            this.isSlideOverOpen = !this.isSlideOverOpen;
        },
        currentStudentDetails(id) {
            this.student = this.students.find(item => item.id === id)
        },
        currentStudentEdit(id) {
            this.student = this.students.find(item => item.id === id)
        }
    }
});
