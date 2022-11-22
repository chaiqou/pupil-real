import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore.js";
import { useTransactionStore } from "./useTransactionStore";
import { useStudentStore } from "./useStudentStore";
import { useMerchantStore } from "./useMerchantStore";
import { useLunchFormStore } from "./useLunchFormStore";
const store = createPinia({
    useModalStore,
    useTransactionStore,
    useStudentStore,
    useMerchantStore,
    useLunchFormStore,
});

export default store;
