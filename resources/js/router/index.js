import { createRouter, createWebHashHistory } from "vue-router";

import LunchEditPage from "@/components/lunch-managment/LunchEditPage.vue";

const routes = [
    {
        path: "/school/:id/edit",
        name: "lunches.edit",
        component: LunchEditPage,
        props: true,
    },
];

export default createRouter({
    history: createWebHashHistory(),
    routes,
});
