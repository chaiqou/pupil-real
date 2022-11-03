import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore.js";
import { useTransactionStore } from "./useTransactionStore";
import { useStudentStore } from "./useStudentStore";
import { useMerchantStore } from "./useMerchantStore";
const store = createPinia({
    useModalStore,
    useTransactionStore,
    useStudentStore,
    useMerchantStore,
});

export default store;
