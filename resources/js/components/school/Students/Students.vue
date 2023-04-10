<template>
  <div
    @scroll="onScroll"
    :class="
      this.isStudentsLoaded && this.students
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
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8"
          >
            Full name
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            Card number
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            Parent email
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8"
          >
            <span class="sr-only">Details</span>
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-if="this.isStudentsLoaded && !this.students.length">
          <td class="bg-white" colspan="4">
            <StudentsNotFound></StudentsNotFound>
          </td>
        </tr>
        <template v-if="this.isStudentsLoaded && this.students.length">
            <tr
                v-for="student in students"
                :key="student.id"
            >
                <td
                    class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                >
                    {{ student.first_name + " " + student.last_name }}
                </td>
                <td
                    class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
                >
                    {{ student.card_number }}
                </td>
                <td
                    class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
                >
                    {{ student.user.email }}
                </td>
                <td
                    class="relative whitespace-nowrap border-b border-gray-200 py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                >
                    <button
                        @click="
                showHideSlideOver();
                currentStudentDetails(student.id);
              "
                        class="text-indigo-600 hover:text-indigo-900"
                    >
                        Details
                    </button>
                </td>
            </tr>
        </template>
        <template v-if="!this.isStudentsLoaded">
            <tr v-for="n in 7" :key="n">
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
            </tr>
        </template>
      </tbody>
    </table>
    <students-slide-over></students-slide-over>
  </div>
</template>

<script>
import { mapActions, mapWritableState } from "pinia";
import { useStudentStore } from "@/stores/useStudentStore";
import StudentsNotFound from "@/components/not-found/StudentsNotFound.vue";
import StudentsSlideOver from "@/components/school/Students/StudentsSlideOver.vue";

export default {
  components: {
    StudentsNotFound,
    StudentsSlideOver,
  },
  data() {
    return {
      currentPage: 1,
      lastPage: 2,
    };
  },
  props: {
    student: {
      type: Object,
      required: true,
    },
    schoolId: {
      type: Number,
      required: true,
    },
  },
  computed: {
    ...mapWritableState(useStudentStore, [
      "isStudentsLoaded",
      "isSlideOverOpen",
      "students",
    ]),
  },
  methods: {
    ...mapActions(useStudentStore, [
      "showHideSlideOver",
      "currentStudentDetails",
    ]),
    handleGetStudentRequest() {
      axios
        .get(`/api/school/${this.schoolId}/students?page=${this.currentPage}`)
        .then((res) => {
          this.currentPage++;
          this.lastPage = res.data.meta.last_page;
          this.students.push(...res.data.data);
        })
        .finally(() => (this.isStudentsLoaded = true));
    },
    onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
      if (scrollTop + clientHeight >= scrollHeight) {
        if (this.currentPage > this.lastPage) {
          return;
        }
        this.handleGetStudentRequest();
      }
    },
  },
  created() {
    this.handleGetStudentRequest();
  },
};
</script>
