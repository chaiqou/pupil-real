<template>
  <div
    @scroll="onScroll"
    :class="
      this.isSchoolsLoaded && this.schools
        ? 'max-h-[17.5rem] overflow-hidden overflow-y-scroll shadow ring-1 ring-black ring-opacity-5 md:max-h-[19.3rem] md:rounded-lg'
        : 'overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg'
    "
  >
    <table
      class="min-w-full border-separate divide-y divide-gray-300"
      style="border-spacing: 0"
    >
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            Short name
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            Full name
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            Long name
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            Details
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            School code
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 backdrop-blur backdrop-filter"
          >
            <span class="sr-only">Edit</span>
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 backdrop-blur backdrop-filter"
          >
            <span class="sr-only">Merchants</span>
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-if="this.isSchoolsLoaded && !this.schools.length">
          <td class="bg-white" colspan="8">
            <SchoolsNotFound></SchoolsNotFound>
          </td>
        </tr>
        <tr
          v-if="this.isSchoolsLoaded && this.schools.length"
          v-for="school in schools"
          :key="school.id"
        >
          <td
            class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900"
          >
            {{ school.short_name }}
          </td>
          <td
            class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
          >
            {{ school.full_name }}
          </td>
          <td
            class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
          >
            {{ school.long_name }}
          </td>
          <td
            class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
          >
            <p>
              Street Address: {{ school.details.street_address }}; Country:
              {{ school.details.country }}; ZIP: {{ school.details.zip }};
            </p>
          </td>
          <td
            class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
          >
            {{ school.school_code }}
          </td>
          <td
            class="relative whitespace-nowrap border-b border-gray-200 text-right text-sm font-medium"
          >
            <button
              @click="
                showHideSchoolEdit();
                currentSchoolEdit(school.id);
              "
              class="text-indigo-600 hover:text-indigo-900"
            >
              Edit
            </button>
          </td>
          <td
            class="relative whitespace-nowrap border-b border-gray-200 pl-2 pr-6 text-right text-sm font-medium"
          >
            <a
              :href="'/admin/school/' + school.id + '/merchants'"
              class="rounded-md bg-blue-600 px-2 py-1.5 text-white hover:bg-blue-700 hover:text-gray-100"
            >
              Merchants
            </a>
          </td>
        </tr>
        <tr v-if="!this.isSchoolsLoaded" v-for="n in 7">
          <td
            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
          >
            <div class="h-2 animate-pulse rounded bg-slate-300"></div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div class="h-2 animate-pulse rounded bg-slate-300"></div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div class="h-2 animate-pulse rounded bg-slate-300"></div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div class="h-2 animate-pulse rounded bg-slate-300"></div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div class="h-2 animate-pulse rounded bg-slate-300"></div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div class="h-2 animate-pulse rounded bg-slate-300"></div>
          </td>
          <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div class="h-2 animate-pulse rounded bg-slate-300"></div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <school-edit-modal v-if="this.schoolId"></school-edit-modal>
</template>

<script>
import { mapActions, mapWritableState } from 'pinia';
import { useSchoolStore } from '@/stores/useSchoolStore';
import SchoolsNotFound from '@/components/not-found/SchoolsNotFound.vue';
import SchoolEditModal from '@/components/admin/Schools/SchoolEditModal.vue';
import { useModalStore } from '@/stores/useModalStore';

export default {
  components: {
    SchoolsNotFound,
    SchoolEditModal,
  },
  data() {
    return {
      currentPage: 1,
      lastPage: 2,
    };
  },
  computed: {
    ...mapWritableState(useSchoolStore, [
      'isSchoolsLoaded',
      'schools',
      'schoolId',
    ]),

    ...mapWritableState(useModalStore, ['isSchoolEditVisible']),
  },
  methods: {
    ...mapActions(useModalStore, ['showHideSchoolEdit']),
    ...mapActions(useSchoolStore, ['currentSchoolEdit']),
    handleGetSchoolsRequest() {
      axios
        .get(`/api/admin/schools?page=${this.currentPage}`)
        .then((res) => {
          this.currentPage++;
          this.lastPage = res.data.meta.last_page;
          this.schools.push(...res.data.data);
        })
        .finally(() => (this.isSchoolsLoaded = true));
    },
    onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
      if (scrollTop + clientHeight >= scrollHeight) {
        if (this.currentPage > this.lastPage) {
          return;
        }
        this.handleGetSchoolsRequest();
      }
    },
  },
  created() {
    this.handleGetSchoolsRequest();
  },
};
</script>
