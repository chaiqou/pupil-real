<template>
    <div class="px-4 sm:px-6 lg:px-8 mt-32">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto flex items-end justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        All Terminals
                    </h1>
                    <p class="mt-2 text-sm text-gray-700">
                        A list of all terminals depend to your school including
                        terminal name, serial number, private and public keys.
                    </p>
                </div>
                <span
                    @click="showHideTerminalCreate()"
                    class="cursor-pointer hidden bg-green-500 hover:bg-green-600 rounded-md text-white px-4 py-2 md:flex items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                    <p class="ml-1.5">Create a new terminal</p>
                </span>
            </div>
        </div>
    </div>
    <terminal-create-modal></terminal-create-modal>
</template>

<script>
import { useModalStore } from "@/stores/useModalStore";
import { mapWritableState, mapActions } from "pinia";
import TerminalCreateModal from "@/components/school/Terminals/TerminalCreateModal.vue";

export default {
    components: {
        TerminalCreateModal,
    },
    computed: {
        ...mapWritableState(useModalStore, ["isTerminalCreateVisible"]),
    },
    methods: {
        ...mapActions(useModalStore, ["showHideTerminalCreate"]),
    },
};
</script>
