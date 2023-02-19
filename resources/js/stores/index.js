import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore";
import { useTransactionStore } from "@/stores/useTransactionStore";
import { useStudentStore } from "@/stores/useStudentStore";
import { useMerchantStore } from "@/stores/useMerchantStore";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { useSchoolStore } from "@/stores/useSchoolStore";
import { useGlobalStore } from "@/stores/useGlobalStore";
import { useTerminalStore } from "@/stores/useTerminalStore";
const store = createPinia({
  useModalStore,
  useTransactionStore,
  useStudentStore,
  useMerchantStore,
  useLunchFormStore,
  useSchoolStore,
  useGlobalStore,
  useTerminalStore,
});

export default store;
