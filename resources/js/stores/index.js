import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore";
import { useTransactionStore } from "@/stores/useTransactionStore";
import { useStudentStore } from "@/stores/useStudentStore";
import { useMerchantStore } from "@/stores/useMerchantStore";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { useSchoolStore } from "@/stores/useSchoolStore";
import { useGlobalStore } from "@/stores/useGlobalStore";
import { useTerminalStore } from "@/stores/useTerminalStore";
import { useInviteStore } from "@/stores/useInviteStore";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";

const store = createPinia({
  useModalStore,
  useTransactionStore,
  useStudentStore,
  useMerchantStore,
  useLunchFormStore,
  useSchoolStore,
  useGlobalStore,
  useTerminalStore,
  useInviteStore,
  useMenuManagementStore,
});

export default store;
