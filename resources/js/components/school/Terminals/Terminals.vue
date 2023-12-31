<template>
  <div
    @scroll="onScroll"
    :class="
      this.isTerminalsLoaded && this.terminals
        ? 'max-h-[19rem] overflow-hidden overflow-y-scroll shadow ring-1 ring-black ring-opacity-5 md:rounded-lg'
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
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.name") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.serial_number") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.note") }}
          </th>
          <th
            scope="col"
            class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter"
          >
            {{ $t("message.public_key") }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-if="this.isTerminalsLoaded && !this.terminals.length">
          <td class="bg-white" colspan="4">
            <TerminalsNotFound></TerminalsNotFound>
          </td>
        </tr>
        <template v-if="this.isTerminalsLoaded && this.terminals.length">
          <tr v-for="terminal in terminals" :key="terminal.id">
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ terminal.name }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ terminal.serial_number }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ terminal.note || "NONE" }}
            </td>
            <td
              class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500"
            >
              {{ terminal.public_key }}
            </td>
          </tr>
        </template>
        <template v-if="!this.isTerminalsLoaded">
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
  </div>
</template>

<script>
import { mapWritableState } from "pinia";
import { useTerminalStore } from "@/stores/useTerminalStore";
import TerminalsNotFound from "@/components/not-found/TerminalsNotFound.vue";

export default {
  components: {
    TerminalsNotFound,
  },
  data() {
    return {
      currentPage: 1,
      lastPage: 2,
    };
  },
  props: {
    schoolId: {
      type: Number,
      required: true,
    },
  },
  computed: {
    ...mapWritableState(useTerminalStore, ["isTerminalsLoaded", "terminals"]),
  },
  methods: {
    handleGetTerminalsRequest() {
      axios
        .get(`/api/school/terminals?page=${this.currentPage}`)
        .then((res) => {
          this.currentPage++;
          this.lastPage = res.data.meta.last_page;
          this.terminals.push(...res.data.data);
        })
        .finally(() => {
          this.isTerminalsLoaded = true;
        });
    },
    onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
      if (scrollTop + clientHeight >= scrollHeight) {
        if (this.currentPage > this.lastPage) {
          return;
        }
        this.handleGetTerminalsRequest();
      }
    },
  },
  created() {
    this.handleGetTerminalsRequest();
  },
};
</script>
