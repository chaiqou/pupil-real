import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore.js";
import { useTransactionStore } from "./useTransactionStore";

const store = createPinia({
    useModalStore,
    useTransactionStore
});

export default store;
