require("./bootstrap");

import { createApp } from "vue";
import { createPinia } from "pinia";

import DashboardNavigation from "./components/DashboardNavigation.vue";
import DashboardNavigationMobile from "./components/DashboardNavigationMobile.vue";
import NavigationMenuButton from "./components/NavigationMenuButton.vue";
import SwitchAccount from "./components/SwitchAccount.vue";
import MerchantCalendar from "./components/merchants/Calendar.vue";
import SchoolTransactions from "./components/school/Transactions.vue";
import SchoolTransactionSlideOver from "./components/school/TransactionSlideOver.vue";
import ParentTransactions from "./components/parent/Transactions.vue";
import ParentTransactionSlideOver from "./components/parent/TransactionSlideOver.vue";
import SchoolStudents from "./components/school/Students.vue";
import SchoolStudentsSlideOver from "./components/school/StudentsSlideOver.vue";
import ParentDashboard from "./components/parent/Dashboard.vue";
import ParentDashboardTransactions from "./components/parent/DashboardTransactions.vue";
import Calendar from "./components/merchants/Calendar.vue";
import TwoFactorAuthModal from "./components/parent/TwoFactorAuthModal.vue";
import ChangePasswordModal from "./components/parent/ChangePasswordModal.vue";
import ParentStudents from "./components/parent/Students.vue";
import ParentStudentEditModal from "./components/parent/StudentsEditModal.vue";
import SchoolDashboardTransactions from './components/school/DashboardTransactions.vue';
import MerchantForm from "./components/merchants/MerchantForm.vue";
import Datepicker from "@vuepic/vue-datepicker";
import SchoolDashboardStudents from './components/school/DashboardStudents.vue';
import ParentStudentsMobile from './components/parent/StudentsMobile.vue';

import "@vuepic/vue-datepicker/dist/main.css";
import "../js/config/axios/index";
import "../js/config/vee-validate/index";

const pinia = createPinia();
const app = createApp({});

app.component("dashboard-navigation", DashboardNavigation);
app.component("dashboard-navigation-mobile", DashboardNavigationMobile);
app.component("merchant-calendar", MerchantCalendar);
app.component("navigation-menu-button", NavigationMenuButton);
app.component("switch-account", SwitchAccount);
app.component("school-transactions", SchoolTransactions);
app.component("school-transaction-slide-over", SchoolTransactionSlideOver);
app.component("parent-transactions", ParentTransactions);
app.component("parent-transaction-slide-over", ParentTransactionSlideOver);
app.component("school-students", SchoolStudents);
app.component("school-students-slide-over", SchoolStudentsSlideOver);
app.component("parent-dashboard", ParentDashboard);
app.component("parent-dashboard-transactions", ParentDashboardTransactions);
app.component("calendar", Calendar);
app.component("two-factor-auth-modal", TwoFactorAuthModal);
app.component("change-password-modal", ChangePasswordModal);
app.component("parent-students", ParentStudents);
app.component("parent-student-edit-modal", ParentStudentEditModal);
app.component("merchant-form", MerchantForm);
app.component("Datepicker", Datepicker);
app.component('school-dashboard-students', SchoolDashboardStudents);
app.component("school-dashboard-transactions", SchoolDashboardTransactions);
app.component('parent-students-mobile', ParentStudentsMobile);

app.use(pinia);
app.mount("#app");
