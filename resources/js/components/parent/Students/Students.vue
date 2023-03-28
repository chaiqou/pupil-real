<template>
  <table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
      <tr>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8"
        >
          Last name
        </th>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
        >
          First name
        </th>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
        >
          Middle name
        </th>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
        >
          Country
        </th>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
        >
          State
        </th>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
        >
          City
        </th>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
        >
          Address
        </th>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
        >
          Zip
        </th>
        <th
          scope="col"
          class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8"
        >
          <span class="sr-only">Edit</span>
        </th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
      <tr v-if="this.isStudentsLoaded" v-for="item in students" :key="item.id">
        <td
          class="... max-w-[7rem] truncate whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6"
        >
          {{ item.last_name }}
        </td>
        <td
          class="... max-w-[7rem] truncate whitespace-nowrap px-3 py-4 text-sm text-gray-500"
        >
          {{ item.first_name }}
        </td>
        <td
          class="... max-w-[7rem] truncate whitespace-nowrap px-3 py-4 text-sm text-gray-500"
        >
          {{ item.middle_name }}
        </td>
        <td
          class="... max-w-[7rem] truncate whitespace-nowrap px-3 py-4 text-sm text-gray-500"
        >
          {{ item.user_information.country }}
        </td>
        <td
          class="... max-w-[7rem] truncate whitespace-nowrap px-3 py-4 text-sm text-gray-500"
        >
          {{ item.user_information.state }}
        </td>
        <td
          class="... max-w-[7rem] truncate whitespace-nowrap px-3 py-4 text-sm text-gray-500"
        >
          {{ item.user_information.city }}
        </td>
        <td
          class="... max-w-[7rem] truncate whitespace-nowrap px-3 py-4 text-sm text-gray-500"
        >
          {{ item.user_information.street_address }}
        </td>
        <td
          class="... max-w-[7rem] truncate whitespace-nowrap px-3 py-4 text-sm text-gray-500"
        >
          {{ item.user_information.zip }}
        </td>
        <td
          class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
        >
          <button
            @click="
              showHideStudentEdit();
              currentStudentEdit(item.id);
            "
            class="text-indigo-600 hover:text-indigo-900"
          >
            Edit
          </button>
        </td>
      </tr>
      <tr v-if="!this.isStudentsLoaded" v-for="n in 7">
        <td
          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
        >
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
          <div class="h-2 w-[7rem] animate-pulse rounded bg-slate-300"></div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import { mapActions, mapWritableState } from "pinia";
import { useStudentStore } from "@/stores/useStudentStore";
import { useModalStore } from "@/stores/useModalStore";

export default {
  props: {
    userId: {
      type: Number,
      required: true,
    },
  },
  computed: {
    ...mapWritableState(useStudentStore, [
      "isStudentsLoaded",
      "students",
      "studentId",
    ]),
    ...mapWritableState(useModalStore, ["isStudentEditVisible"]),
  },
  methods: {
    ...mapActions(useStudentStore, ["currentStudentEdit"]),
    ...mapActions(useModalStore, ["showHideStudentEdit"]),
    handleGetStudentRequest() {
      axios
        .get(`/api/parent/${this.userId}/students`)
        .then((res) => {
          this.students = res.data.data;
        })
        .finally(() => {
          this.isStudentsLoaded = true;
        });
    },
  },
  created() {
    this.handleGetStudentRequest();
  },
};
</script>
