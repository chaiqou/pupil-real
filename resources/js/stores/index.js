import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore.js";
import { useTransactionStore } from "./useTransactionStore";
import { useStudentStore } from './useStudentStore'
const store = createPinia({
    useModalStore,
    useTransactionStore,
    useStudentStore,
});

export default store;
