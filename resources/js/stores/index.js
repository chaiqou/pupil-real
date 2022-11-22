import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore.js";
import { useTransactionStore } from "@/stores/useTransactionStore";
import { useStudentStore } from "@/stores/useStudentStore";
import { useMerchantStore } from "@/stores/useMerchantStore";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
const store = createPinia({
    useModalStore,
    useTransactionStore,
    useStudentStore,
    useMerchantStore,
    useLunchFormStore,
});

export default store;
