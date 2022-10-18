

import { createPinia } from "pinia";
import { useModalStore } from "@/stores/useModalStore.js";
const store = createPinia({
    useModalStore,
});

export default store;
