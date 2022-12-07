import { createRouter, createWebHistory } from "vue-router";

import LunchFormEdit from "../components/lunch-managment/LunchFormEdit.vue";

const routes = [
    {
        path: "/school/:id/edit",
        name: "lunches.edit",
        component: LunchFormEdit,
        props: true,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
