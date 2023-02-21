<template>
  <div class="gap-2 xl:flex">
    <div class="lg:mt-10 xl:w-1/2">
      <h3 class="text-lg font-medium leading-6 text-gray-900">Title</h3>
      <dl class="mt-5 grid w-full grid-cols-1 gap-5 sm:grid-cols-2">
        <div
          v-for="item in statsBottom"
          :key="item.name"
          class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6"
        >
          <dt class="text-base font-normal text-gray-900">
            {{ item.name }}
          </dt>
          <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
            <div
              class="flex flex-col items-baseline text-2xl font-semibold text-indigo-600"
            >
              {{ item.stat }}
              <span class="ml-2 text-sm font-medium text-gray-500"
                >from {{ item.previousStat }}</span
              >
            </div>

            <div
              :class="[
                item.changeType === 'increase'
                  ? 'bg-green-100 text-green-800'
                  : 'bg-red-100 text-red-800',
                'inline-flex items-baseline rounded-full px-2.5 py-0.5 text-sm font-medium md:mt-2 lg:mt-0',
              ]"
            >
              <ArrowUpIcon
                v-if="item.changeType === 'increase'"
                class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-green-500"
                aria-hidden="true"
              />
              <ArrowDownIcon
                v-else
                class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-red-500"
                aria-hidden="true"
              />
              <span class="sr-only">
                {{ item.changeType === "increase" ? "Increased" : "Decreased" }}
                by
              </span>
              {{ item.change }}
            </div>
          </dd>
        </div>
      </dl>

      <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div
          v-for="item in statsBottom"
          :key="item.name"
          class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6"
        >
          <dt class="text-base font-normal text-gray-900">
            {{ item.name }}
          </dt>
          <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
            <div
              class="flex flex-col items-baseline text-2xl font-semibold text-indigo-600"
            >
              {{ item.stat }}
              <span class="ml-2 text-sm font-medium text-gray-500"
                >from {{ item.previousStat }}</span
              >
            </div>

            <div
              :class="[
                item.changeType === 'increase'
                  ? 'bg-green-100 text-green-800'
                  : 'bg-red-100 text-red-800',
                'inline-flex items-baseline rounded-full px-2.5 py-0.5 text-sm font-medium md:mt-2 lg:mt-0',
              ]"
            >
              <ArrowUpIcon
                v-if="item.changeType === 'increase'"
                class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-green-500"
                aria-hidden="true"
              />
              <ArrowDownIcon
                v-else
                class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-red-500"
                aria-hidden="true"
              />
              <span class="sr-only">
                {{ item.changeType === "increase" ? "Increased" : "Decreased" }}
                by
              </span>
              {{ item.change }}
            </div>
          </dd>
        </div>
      </dl>
    </div>

    <div class="mt-10 xl:w-2/3">
      <h3 class="text-lg font-medium leading-6 text-gray-900">Title</h3>
      <dashboard-transactions
        class="mt-5"
        :schoolId="1"
      ></dashboard-transactions>
    </div>
  </div>
  <div class="my-12 px-1 md:mt-32 md:mb-32 xl:flex">
    <div
      v-if="this.chartData"
      class="mb-5 flex items-center justify-center rounded-lg bg-white shadow-2xl lg:mr-3 xl:w-1/2"
    >
      <Pie
        width="100%"
        id="RandomChart"
        :chartData="this.chartData"
        :labels="this.pieChartLabels"
      ></Pie>
    </div>
    <div
      class="flex items-center justify-center rounded-lg bg-white shadow-2xl xl:w-2/3"
    >
      <div class="w-full">
        <ApexChart
          width="100%"
          :options="chartOptions"
          :series="series"
        ></ApexChart>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import VueApexCharts from "vue3-apexcharts";
import { startOfMonth, endOfMonth, eachDayOfInterval } from "date-fns";
import { ArrowDownIcon, ArrowUpIcon } from "@heroicons/vue/20/solid";
import { EnvelopeOpenIcon, UsersIcon } from "@heroicons/vue/24/outline";
import Pie from "@/components/Ui/Charts/Pie.vue";
import DashboardTransactions from "@/components/school/Dashboard/DashboardTransactions.vue";

export default {
  components: {
    ApexChart: VueApexCharts,
    Pie,
    ArrowDownIcon,
    ArrowUpIcon,
    DashboardTransactions,
  },
  data() {
    return {
      statsTop: [
        {
          id: 1,
          name: "Total Subscribers",
          stat: "71,897",
          icon: UsersIcon,
          change: "122",
          changeType: "increase",
        },
        {
          id: 2,
          name: "Avg. Open Rate",
          stat: "58.16%",
          icon: EnvelopeOpenIcon,
          change: "5.4%",
          changeType: "increase",
        },
      ],
      statsBottom: [
        {
          name: "Total Subscribers",
          stat: "71,897",
          previousStat: "70,946",
          change: "12%",
          changeType: "increase",
        },
        {
          name: "Avg. Open Rate",
          stat: "58.16%",
          previousStat: "56.14%",
          change: "2.02%",
          changeType: "increase",
        },
      ],
      currentMonthDates: [],
      pieChartLabels: [],
      chartData: null,
      series: [
        {
          name: "Session Duration",
          type: "area",
          data: [
            45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10, 13, 14, 15, 16, 17,
            18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31,
          ],
        },
        {
          name: "Page Views",
          type: "line",
          data: [
            null,
            null,
            null,
            7,
            4,
            5,
            6,
            29,
            37,
            36,
            51,
            32,
            35,
            20,
            21,
            22,
            31,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
          ],
        },
        {
          type: "line",
          name: "Total Visits",
          data: [
            87,
            57,
            74,
            99,
            75,
            38,
            62,
            47,
            82,
            56,
            45,
            47,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
          ],
        },
      ],
      chartOptions: {
        colors: ["#0061F2", "#6900C7", "#cac8cb"],
        fill: {
          type: "solid",
          opacity: [0.25, 1],
        },
        chart: {
          height: 350,
          type: "line",
          width: "100%",
          zoom: {
            enabled: false,
          },
          toolbar: {
            tools: {
              download: false,
            },
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          width: [5, 7, 5],
          curve: "smooth",
          dashArray: [0, 0, 2],
        },
        title: {
          show: false,
        },
        legend: {
          tooltipHoverFormatter(val, opts) {
            return `${val} - ${
              opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex]
            }`;
          },
        },
        markers: {
          size: 0,
        },
        xaxis: {
          categories: this.currentMonthDates,
        },
        tooltip: {
          y: [
            {
              title: {
                formatter(val) {
                  return `${val} (mins)`;
                },
              },
            },
            {
              title: {
                formatter(val) {
                  return `${val} per session`;
                },
              },
            },
            {
              title: {
                formatter(val) {
                  return val;
                },
              },
            },
          ],
        },
        grid: {
          borderColor: "#f1f1f1",
        },
      },
    };
  },
  methods: {
    handleGetPieChartDataRequest() {
      console.log("yes");
      axios
        .get("/api/school/pie-chart-data")
        .then((res) => {
          const data = res.data;

          this.chartData = data.map((item) => item.share_count);
          this.pieChartLabels = data.map((item) => item.title);
        })
        .catch((err) => console.log(err));
    },
  },
  mounted() {
    const start = startOfMonth(new Date());
    const end = endOfMonth(new Date());
    this.currentMonthDates = eachDayOfInterval({
      start,
      end,
    }).map((date) =>
      date.toLocaleDateString("en-US", { day: "2-digit", month: "short" }),
    );
    console.log(this.currentMonthDates);
    this.handleGetPieChartDataRequest();
  },
};
</script>
