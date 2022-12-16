<template>
    <div class="px-4 sm:px-6 lg:px-8 mt-32">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto flex items-end justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        All Schools
                    </h1>
                    <p class="mt-2 text-sm text-gray-700">
                        A list of all the schools including short/full/long name, details and school code.
                    </p>
                </div>
                <span @click="showHideSchoolCreate()"
                    class="cursor-pointer hidden bg-green-500 hover:bg-green-600 rounded-md text-white px-4 py-2 md:flex items-center"
                >
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                   </svg>
                    <p class="ml-1.5">Create new School</p>
                </span>
            </div>
        </div>
    </div>
<school-create-modal></school-create-modal>
</template>

<script>
import SchoolCreateModal from "@/components/admin/Schools/SchoolCreateModal.vue";
import { useModalStore } from "@/stores/useModalStore";
import { mapWritableState, mapActions} from "pinia";
export default {
    components: {
      SchoolCreateModal
    },
    computed: {
      ...mapWritableState(useModalStore, ["isCreateSchoolVisible"]),
    },
    methods: {
        ...mapActions(useModalStore, ["showHideSchoolCreate"])
    },
};
</script>
