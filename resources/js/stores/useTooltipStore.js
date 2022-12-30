import { defineStore } from "pinia";

export const useTooltipStore = defineStore("tooltip", {
    state: () => {
        return {
            toggle_tooltip: false,
            tooltip_textarea: "",
        };
    },
});
