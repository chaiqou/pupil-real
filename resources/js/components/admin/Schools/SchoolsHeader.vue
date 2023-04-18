<template>
  <div class="mt-32 px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="flex items-end justify-between sm:flex-auto">
        <div>
          <h1 class="text-xl font-semibold text-gray-900">{{ $t('message.all_schools') }}</h1>
          <p class="mt-2 text-sm text-gray-700">
              {{ $t('message.a_list_of_all_the_schools_including_short_full_long_name_details_and_school_code') }}.
          </p>
        </div>
        <span
          @click="showHideSchoolCreate()"
          class="hidden cursor-pointer items-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 md:flex"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 4.5v15m7.5-7.5h-15"
            />
          </svg>
          <p class="ml-1.5">{{ $t('message.create_new_school') }}</p>
        </span>
      </div>
    </div>
  </div>
  <school-create-modal></school-create-modal>
</template>

<script>
import { mapWritableState, mapActions } from "pinia";
import SchoolCreateModal from "@/components/admin/Schools/SchoolCreateModal.vue";
import { useModalStore } from "@/stores/useModalStore";

export default {
  components: {
    SchoolCreateModal,
  },
  computed: {
    ...mapWritableState(useModalStore, ["isCreateSchoolVisible"]),
  },
  methods: {
    ...mapActions(useModalStore, ["showHideSchoolCreate"]),
  },
};
</script>
