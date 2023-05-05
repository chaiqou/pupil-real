import "@/bootstrap";
import "../css/app.css";
import { createApp } from "vue/dist/vue.esm-bundler";
import { createPinia } from "pinia";
import i18n from "@/config/i18n/index.js";
import "@vuepic/vue-datepicker/dist/main.css";
import "@/config/axios/index.js";
import "@/config/vee-validate/rules.js";
import "@/config/vee-validate/messages";

import DashboardNavigation from "@/components/navigation/DashboardNavigation.vue";
import DashboardNavigationMobile from "@/components/navigation/DashboardNavigationMobile.vue";
import NavigationMenuButton from "@/components/navigation/NavigationMenuButton.vue";
import SwitchAccount from "@/components/navigation/SwitchAccount.vue";
import SchoolTransactions from "@/components/school/Transactions/Transactions.vue";
import ParentTransactions from "@/components/parent/Transactions/Transactions.vue";
import SchoolStudents from "@/components/school/Students/Students.vue";
import ParentDashboard from "@/components/parent/Dashboard/Dashboard.vue";
import ParentDashboardTransactions from "@/components/parent/Dashboard/DashboardTransactions.vue";
import Calendar from "@/components/Merchant/lunch-management/Calendar.vue";
import TwoFactorAuthModal from "@/components/parent/TwoFactorAuthModal.vue";
import ChangePasswordModal from "@/components/parent/ChangePasswordModal.vue";
import ParentStudents from "@/components/parent/Students/Students.vue";
import ParentStudentsMobile from "@/components/parent/Students/StudentsMobile.vue";
import SchoolDashboardTransactions from "@/components/school/Dashboard/DashboardTransactions.vue";
import LunchForm from "@/components/Merchant/lunch-management/LunchForm.vue";
import Datepicker from "@vuepic/vue-datepicker";
import SchoolDashboardStudents from "@/components/school/Dashboard/DashboardStudents.vue";
import SchoolInvites from "@/components/school/Invites/Invites.vue";
import SchoolInvitesHeader from "@/components/school/Invites/InvitesHeader.vue";
import AdminStudents from "@/components/admin/Students/Students.vue";
import AdminInvites from "@/components/admin/Invites/Invites.vue";
import AdminInvitesHeader from "@/components/admin/Invites/InvitesHeader.vue";
import ExtrasAndHolds from "@/components/Merchant/lunch-management/ExtrasAndHolds.vue";
import LunchList from "@/components/Merchant/lunch-management/LunchList.vue";
import AdminSchools from "@/components/admin/Schools/Schools.vue";
import AdminMerchants from "@/components/admin/Merchants/Merchants.vue";
import ParentLunchList from "@/components/parent/lunch-management/ParentLunchList.vue";
import AdminMerchantsHeader from "@/components/admin/Merchants/MerchantsHeader.vue";
import AdminMerchantInvitesHeader from "@/components/admin/Merchants/Invite/MerchantInvitesHeader.vue";
import AdminMerchantInvites from "@/components/admin/Merchants/Invite/MerchantInvites.vue";
import AdminSchoolsHeader from "@/components/admin/Schools/SchoolsHeader.vue";
import LunchFormEdit from "@/components/Merchant/lunch-management/LunchFormEdit.vue";
import LunchEditPage from "@/components/Merchant/lunch-management/LunchEditPage.vue";
import ConfirmationModal from "@/components/Merchant/lunch-management/ConfirmationModal.vue";
import ParentLunchDetails from "@/components/parent/lunch-management/parentLunchDetails.vue";
import SchoolTerminals from "@/components/school/Terminals/Terminals.vue";
import SchoolTerminalsHeader from "@/components/school/Terminals/TerminalsHeader.vue";
import ParentCalendar from "@/components/parent/lunch-management/ParentCalendar.vue";
import MenuCalendar from "@/components/Merchant/Menu-management/MenuCalendar.vue";
import SchoolDashboard from "@/components/school/Dashboard/Dashboard.vue";
import ParentMenuCalendar from "@/components/parent/Menus/ParentMenuCalendar.vue";
import ParentSetupAccount from "@/components/invite/parent/SetupAccount.vue";
import ParentPersonalForm from "@/components/invite/parent/PersonalForm.vue";
import ParentSetupCards from "@/components/invite/parent/SetupCards.vue";
import ParentVerifyEmail from "@/components/invite/parent/VerifyEmail.vue";
import MerchantSetupAccount from "@/components/invite/merchant/SetupAccount.vue";
import MerchantPersonalForm from "@/components/invite/merchant/PersonalForm.vue";
import MerchantCompanyDetails from "@/components/invite/merchant/CompanyDetails.vue";
import MerchantSetupStripe from "@/components/invite/merchant/SetupStripe.vue";
import MerchantBillingoVerify from "@/components/invite/merchant/BillingoVerify.vue";
import MerchantVerifyEmail from "@/components/invite/merchant/VerifyEmail.vue";
import SetLanguage from "@/components/Ui/SetLanguage.vue";
import AdminSettings from "@/components/admin/Settings/Settings.vue";
import SchoolSettings from "@/components/school/Settings/Settings.vue";
import AdminDashboard from "@/components/admin/Dashboard/Dashboard.vue";

const pinia = createPinia();
const app = createApp({});

// Set language global component
app.component("set-language", SetLanguage);

// Parent Onboarding global components
app.component("parent-setup-account", ParentSetupAccount);
app.component("parent-personal-form", ParentPersonalForm);
app.component("parent-setup-cards", ParentSetupCards);
app.component("parent-verify-email", ParentVerifyEmail);

// Merchant Onboarding global components
app.component("merchant-setup-account", MerchantSetupAccount);
app.component("merchant-personal-form", MerchantPersonalForm);
app.component("merchant-company-details", MerchantCompanyDetails);
app.component("merchant-setup-stripe", MerchantSetupStripe);
app.component("merchant-billingo-verify", MerchantBillingoVerify);
app.component("merchant-verify-email", MerchantVerifyEmail);

// Navigation global components
app.component("dashboard-navigation", DashboardNavigation);
app.component("dashboard-navigation-mobile", DashboardNavigationMobile);
app.component("navigation-menu-button", NavigationMenuButton);

// Parent global components
app.component("parent-transactions", ParentTransactions);
app.component("parent-dashboard", ParentDashboard);
app.component("parent-dashboard-transactions", ParentDashboardTransactions);
app.component("parent-students", ParentStudents);
app.component("parent-students-mobile", ParentStudentsMobile);
app.component("parent-lunch-list", ParentLunchList);
app.component("parent-lunch-details", ParentLunchDetails);
app.component("parent-calendar", ParentCalendar);
app.component("parent-menu-calendar", ParentMenuCalendar);

// School global components
app.component("school-terminals", SchoolTerminals);
app.component("school-terminals-header", SchoolTerminalsHeader);
app.component("school-transactions", SchoolTransactions);
app.component("school-students", SchoolStudents);
app.component("school-dashboard-students", SchoolDashboardStudents);
app.component("school-dashboard-transactions", SchoolDashboardTransactions);
app.component("school-invites", SchoolInvites);
app.component("school-invites-header", SchoolInvitesHeader);
app.component("school-dashboard", SchoolDashboard);
app.component("school-settings", SchoolSettings);

// Admin global components
app.component("admin-schools", AdminSchools);
app.component("admin-merchants", AdminMerchants);
app.component("admin-merchants-header", AdminMerchantsHeader);
app.component("admin-merchant-invites-header", AdminMerchantInvitesHeader);
app.component("admin-merchant-invites", AdminMerchantInvites);
app.component("admin-schools-header", AdminSchoolsHeader);
app.component("admin-students", AdminStudents);
app.component("admin-invites", AdminInvites);
app.component("admin-invites-header", AdminInvitesHeader);
app.component("admin-settings", AdminSettings);
app.component("admin-dashboard", AdminDashboard);

// Calendar parts components
app.component("calendar", Calendar);
app.component("Datepicker", Datepicker);
app.component("menu-calendar", MenuCalendar);
app.component("extras-and-holds", ExtrasAndHolds);

// Authentication components
app.component("two-factor-auth-modal", TwoFactorAuthModal);
app.component("change-password-modal", ChangePasswordModal);
app.component("switch-account", SwitchAccount);

// Lunch components
app.component("lunch-form", LunchForm);
app.component("lunch-list", LunchList);
app.component("lunch-form-edit", LunchFormEdit);
app.component("lunch-edit-page", LunchEditPage);
app.component("confirmation-modal", ConfirmationModal);

app.use(pinia);
app.use(i18n);
app.mount("#app");
