import "./bootstrap";
import "../css/app.css";
import { createApp } from "vue/dist/vue.esm-bundler";
import { createPinia } from "pinia";

import * as Sentry from "@sentry/vue";

import DashboardNavigation from "@/components/navigation/DashboardNavigation.vue";
import DashboardNavigationMobile from "@/components/navigation/DashboardNavigationMobile.vue";
import NavigationMenuButton from "@/components/navigation/NavigationMenuButton.vue";
import SwitchAccount from "@/components/navigation/SwitchAccount.vue";
import SchoolTransactions from "@/components/school/Transactions/Transactions.vue";
import ParentTransactions from "@/components/parent/Transactions/Transactions.vue";
import SchoolStudents from "@/components/school/Students/Students.vue";
import ParentDashboard from "@/components/parent/Dashboard/Dashboard.vue";
import ParentDashboardTransactions from "@/components/parent/Dashboard/DashboardTransactions.vue";
import Calendar from "@/components/lunch-managment/Calendar.vue";
import TwoFactorAuthModal from "@/components/parent/TwoFactorAuthModal.vue";
import ChangePasswordModal from "@/components/parent/ChangePasswordModal.vue";
import ParentStudents from "@/components/parent/Students/Students.vue";
import ParentStudentsMobile from "@/components/parent/Students/StudentsMobile.vue";
import SchoolDashboardTransactions from "@/components/school/Dashboard/DashboardTransactions.vue";
import LunchForm from "@/components/lunch-managment/LunchForm.vue";
import Datepicker from "@vuepic/vue-datepicker";
import SchoolDashboardStudents from "@/components/school/Dashboard/DashboardStudents.vue";
import SchoolInvites from "@/components/school/Invites/Invites.vue";
import SchoolInvitesHeader from "@/components/school/Invites/InvitesHeader.vue";
import AdminStudents from "@/components/admin/Students/Students.vue";
import AdminInvites from "@/components/admin/Invites/Invites.vue";
import AdminInvitesHeader from "@/components/admin/Invites/InvitesHeader.vue";
import ExtrasAndHolds from "@/components/lunch-managment/ExtrasAndHolds.vue";
import LunchList from "@/components/lunch-managment/LunchList.vue";
import "@vuepic/vue-datepicker/dist/main.css";
import "@/config/axios/index.js";
import "@/config/vee-validate/index.js";
import AdminSchools from "@/components/admin/Schools/Schools.vue";
import AdminMerchants from "@/components/admin/Merchants/Merchants.vue";
import ParentLunchList from "@/components/parent/lunch-management/ParentLunchList.vue";
import AdminMerchantsHeader from "@/components/admin/Merchants/MerchantsHeader.vue";
import AdminMerchantInvitesHeader from "@/components/admin/Merchants/Invite/MerchantInvitesHeader.vue";
import AdminMerchantInvites from "@/components/admin/Merchants/Invite/MerchantInvites.vue";
import AdminSchoolsHeader from "@/components/admin/Schools/SchoolsHeader.vue";
import LunchFormEdit from "@/components/lunch-managment/LunchFormEdit.vue";
import LunchEditPage from "@/components/lunch-managment/LunchEditPage.vue";
import ConfirmationModal from "@/components/lunch-managment/ConfirmationModal.vue";
import ParentLunchDetails from "@/components/parent/lunch-management/parentLunchDetails.vue";
import SchoolTerminals from "@/components/school/Terminals/Terminals.vue";
import SchoolTerminalsHeader from "@/components/school/Terminals/TerminalsHeader.vue";
import ParentCalendar from "../js/components/parent/lunch-management/ParentCalendar.vue";
import MenuCalendar from "../js/components/school/Menu/MenuCalendar.vue";

const pinia = createPinia();
const app = createApp({});
// import { BrowserTracing } from "@sentry/tracing";
// Sentry.init({
//     app,
//     dsn: "https://76042f674d6b4d699621aa64e177b6d6@o1074627.ingest.sentry.io/4504446374838272",
//     integrations: [
//         new BrowserTracing({
//             tracePropagationTargets: ["localhost", "my-site-url.com", /^\//],
//         }),
//     ],
//     // Set tracesSampleRate to 1.0 to capture 100%
//     // of transactions for performance monitoring.
//     // We recommend adjusting this value in production
//     tracesSampleRate: 1.0,
// });

app.component("dashboard-navigation", DashboardNavigation);
app.component("dashboard-navigation-mobile", DashboardNavigationMobile);
app.component("navigation-menu-button", NavigationMenuButton);
app.component("switch-account", SwitchAccount);
app.component("school-transactions", SchoolTransactions);
app.component("parent-transactions", ParentTransactions);
app.component("school-students", SchoolStudents);
app.component("parent-dashboard", ParentDashboard);
app.component("parent-dashboard-transactions", ParentDashboardTransactions);
app.component("calendar", Calendar);
app.component("two-factor-auth-modal", TwoFactorAuthModal);
app.component("change-password-modal", ChangePasswordModal);
app.component("parent-students", ParentStudents);
app.component("lunch-form", LunchForm);
app.component("Datepicker", Datepicker);
app.component("school-dashboard-students", SchoolDashboardStudents);
app.component("school-dashboard-transactions", SchoolDashboardTransactions);
app.component("school-invites", SchoolInvites);
app.component("school-invites-header", SchoolInvitesHeader);
app.component("admin-students", AdminStudents);
app.component("admin-invites", AdminInvites);
app.component("admin-invites-header", AdminInvitesHeader);
app.component("extras-and-holds", ExtrasAndHolds);
app.component("parent-students-mobile", ParentStudentsMobile);
app.component("lunch-list", LunchList);
app.component("admin-schools", AdminSchools);
app.component("admin-merchants", AdminMerchants);
app.component("parent-lunch-list", ParentLunchList);
app.component("admin-merchants-header", AdminMerchantsHeader);
app.component("admin-merchant-invites-header", AdminMerchantInvitesHeader);
app.component("admin-merchant-invites", AdminMerchantInvites);
app.component("admin-schools-header", AdminSchoolsHeader);
app.component("lunch-form-edit", LunchFormEdit);
app.component("lunch-edit-page", LunchEditPage);
app.component("confirmation-modal", ConfirmationModal);
app.component("parent-lunch-details", ParentLunchDetails);
app.component("school-terminals", SchoolTerminals);
app.component("school-terminals-header", SchoolTerminalsHeader);
app.component("parent-calendar", ParentCalendar);
app.component("menu-calendar", MenuCalendar);
app.use(pinia);
app.mount("#app");
