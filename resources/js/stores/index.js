import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore";
import { useTransactionStore } from "@/stores/useTransactionStore";
import { useStudentStore } from "@/stores/useStudentStore";
import { useMerchantStore } from "@/stores/useMerchantStore";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { useSchoolStore } from "@/stores/useSchoolStore";
import { useGlobalStore } from "@/stores/useGlobalStore"
const store = createPinia({
    useModalStore,
    useTransactionStore,
    useStudentStore,
    useMerchantStore,
    useLunchFormStore,
    useSchoolStore,
    useGlobalStore,
});

export default store;
