import { defineStore } from "pinia";

export const useTerminalStore = defineStore("terminal", {
    state: () => {
        return {
            isTerminalsLoaded: false,
            terminals: [],
            terminal: [],
            QRKeys: null,
        };
    },
});
