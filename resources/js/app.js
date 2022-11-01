require("./bootstrap");

import { createApp } from "vue";
import { createPinia } from "pinia";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import "../js/config/vee-validate/rules";

import DashboardNavigation from "./components/DashboardNavigation.vue";
import DashboardNavigationMobile from "./components/DashboardNavigationMobile.vue";
import NavigationMenuButton from "./components/NavigationMenuButton.vue";
import SwitchAccount from "./components/SwitchAccount.vue";
import MerchantCalendar from "./components/merchants/Calendar.vue";
import MerchantForm from "./components/merchants/MerchantForm.vue";
import SchoolTransactions from "./components/school/Transactions.vue";
import SchoolTransactionSlideOver from "./components/school/TransactionSlideOver.vue";
import ParentTransactions from "./components/parent/Transactions.vue";
import ParentTransactionSlideOver from "./components/parent/TransactionSlideOver.vue";
import Students from "./components/Students.vue";
import StudentsSlideOver from "./components/StudentsSlideOver.vue";

const pinia = createPinia();
const app = createApp({});

app.component("dashboard-navigation", DashboardNavigation);
app.component("dashboard-navigation-mobile", DashboardNavigationMobile);
app.component("navigation-menu-button", NavigationMenuButton);
app.component("switch-account", SwitchAccount);
app.component("merchant-calendar", MerchantCalendar);
app.component("dashboard-navigation", DashboardNavigation);
app.component("dashboard-navigation-mobile", DashboardNavigationMobile);
app.component("navigation-menu-button", NavigationMenuButton);
app.component("switch-account", SwitchAccount);
app.component("school-transactions", SchoolTransactions);
app.component("school-transaction-slide-over", SchoolTransactionSlideOver);
app.component("parent-transactions", ParentTransactions);
app.component("parent-transaction-slide-over", ParentTransactionSlideOver);
app.component("students", Students);
app.component("students-slide-over", StudentsSlideOver);
app.component("merchant-form", MerchantForm);
app.component("Datepicker", Datepicker);

app.use(pinia);
app.mount("#app");
