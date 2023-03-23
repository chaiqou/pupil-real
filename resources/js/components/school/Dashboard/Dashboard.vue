<template>
  <div class="gap-2 xl:flex">
    <div class="lg:mt-10 xl:w-1/2">
      <h3 class="text-lg font-medium leading-6 text-gray-900">Title</h3>
      <dl class="mt-5 grid w-full grid-cols-1 gap-5 sm:grid-cols-2">
        <div
          v-for="item in statsTop"
          :key="item.name"
          class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6"
        >
          <dt class="text-base font-normal text-gray-900">
            {{ item.name }}
          </dt>
          <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
            <div v-if="item.unavailable === false"
              class="flex flex-col items-baseline text-2xl font-semibold text-indigo-600"
            >
              {{ item.stat }}
              <span class="ml-2 text-sm font-medium text-gray-500"
                >from {{ item.previousStat }}</span
              >
            </div>
            <div v-if="item.unavailable === false"
              :class="[
                item.changeType === 'increase'
                  ? 'bg-green-100 text-green-800' : item.changeType === 'decrease' ? 'bg-red-100 text-red-800' :
                  item.changeType === 'nothing' ? 'bg-gray-100 text-black' : '',
                'inline-flex items-baseline rounded-full px-2.5 py-0.5 text-sm font-medium md:mt-2 lg:mt-0',
              ]"
            >
              <ArrowUpIcon
                v-if="item.changeType === 'increase'"
                class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-green-500"
                aria-hidden="true"
              />
                <ArrowDownIcon
                    v-else-if="item.changeType === 'decrease'"
                    class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-red-500"
                    aria-hidden="true"
                />
                <ArrowsUpDownIcon
                    v-else-if="item.changeType === 'nothing'"
                    class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-gray-500"
                    aria-hidden="true"
                />
              <span class="sr-only">
                {{ item.changeType === "increase" ? "Increased" : "Decreased" }}
                by
              </span>
              {{ item.change }}
            </div>
              <div class="text-xl items-center mt-5 justify-center flex flex-col" v-else>
                  <h1>Unavailable</h1>
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
            <div v-if="item.unavailable === false"
              class="flex flex-col items-baseline text-2xl font-semibold text-indigo-600"
            >
              {{ item.stat }}
              <span class="ml-2 text-sm font-medium text-gray-500"
                >from {{ item.previousStat }}</span
              >
            </div>

              <div v-if="item.change"
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
                      v-else-if="item.changeType === 'decrease'"
                      class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-red-500"
                      aria-hidden="true"
                  />
                  <ArrowsUpDownIcon
                      v-else-if="item.changeType === 'nothing'"
                      class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-gray-500"
                      aria-hidden="true"
                  />
                  <span class="sr-only">
                {{ item.changeType === "increase" ? "Increased" : "Decreased" }}
                by
              </span>
                  {{ item.change }}
              </div>
              <div class="text-xl items-center mt-5 justify-center flex flex-col" v-if="item.unavailable === true">
                  <h1>Unavailable</h1>
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
        v-if="isPieChartDataCalculated"
      class="mb-5 flex items-center justify-center rounded-lg bg-white xl:shadow-2xl lg:mr-3 xl:w-1/2"
    >
          <Pie
              width="100%"
              id="PieChartDashboard"
              :pieChartData="this.pieChartData"
              :labels="this.pieChartLabels"
          ></Pie>
    </div>
      <div v-if="!isPieChartDataCalculated" class="border border-4 mb-5 xl:mr-3 sm:my-5 xl:my-0 border-dashed rounded-md flex items-center justify-center xl:w-2/3">
          <div class="flex items-center justify-center flex-col my-32">
              <clipboard-document-list-icon class="xl:w-32 w-24 text-gray-500"></clipboard-document-list-icon>
              <h1 class="xl:text-xl text-sm p-4 xl:p-0">No lunch orders yet</h1>
          </div>
      </div>

    <div
      v-if="isLineChartDataCalculated"
      class="flex items-center justify-center rounded-lg bg-white shadow-2xl xl:w-2/3"
    >
      <div class="w-full">
          <LineArea
          width="100%"
          id="LineChartDashboard"
          :lineAreaChartData="this.lineAreaChartData"
          >
          </LineArea>
      </div>
    </div>

      <div v-if="!isLineChartDataCalculated" class="border border-4 border-dashed rounded-md flex items-center justify-center xl:w-2/3">
          <div class="flex items-center justify-center flex-col my-32">
              <list-bullet-icon class="xl:w-32 w-24 text-gray-500"></list-bullet-icon>
              <h1 class="xl:text-xl text-sm p-4 xl:p-0">You need to have some transactions before we can show you an overview</h1>
          </div>
      </div>

  </div>
</template>

<script>
import axios from "axios";
import { ArrowDownIcon, ArrowUpIcon, ArrowsUpDownIcon } from "@heroicons/vue/20/solid";
import { EnvelopeOpenIcon, UsersIcon } from "@heroicons/vue/24/outline";
import Pie from "@/components/Ui/Charts/Pie.vue";
import LineArea from "@/components/Ui/Charts/LineArea.vue";
import DashboardTransactions from "@/components/school/Dashboard/DashboardTransactions.vue";
import { ListBulletIcon, ClipboardDocumentListIcon }  from "@heroicons/vue/24/outline";

export default {
    components: {
        Pie,
        ArrowDownIcon,
        ArrowUpIcon,
        DashboardTransactions,
        ListBulletIcon,
        ClipboardDocumentListIcon,
        ArrowsUpDownIcon,
        LineArea
    },
    data() {
        return {
            isLineChartDataCalculated: false,
            isPieChartDataCalculated: false,
            statsTop: [
                {
                    id: 1,
                    name: "Active Students",
                    stat: "",
                    previousStat: "",
                    icon: UsersIcon,
                    change: "",
                    changeType: "",
                    unavailable: false,
                },
                {
                    id: 2,
                    name: "Avg. Transactions Value",
                    stat: "",
                    previousStat: "",
                    icon: EnvelopeOpenIcon,
                    change: "",
                    changeType: "",
                    unavailable: false,
                },
            ],
            statsBottom: [
                {
                    name: "Pending Transactions Value",
                    stat: "",
                    previousStat: "",
                    unavailable: false,
                },
                {
                    name: "Avg. Student weekly spending",
                    stat: "",
                    previousStat: "",
                    change: "",
                    changeType: "",
                    unavailable: false,
                },
            ],
            currentMonthDates: [],
            pieChartLabels: [],
            pieChartData: null,
            lineAreaChartData: [
                {
                    name: "Previous",
                    type: "area",
                    data: [],
                },
                {
                    name: "Current",
                    type: "line",
                    data: [],
                },
                {
                    name: "Prediction",
                    type: "line",
                    data: []
                },
            ],
        };
    },
    methods: {
        insightBoxDataPlaceholderInsertion(boxName, previousMonthData, previousToPreviousMonthData, difference) {
            boxName.stat = previousMonthData;
            boxName.previousStat = previousToPreviousMonthData;
            boxName.change = difference + '%';
            if(difference === 0) {
                boxName.changeType = 'nothing';
            } else {
                difference > 0 ? boxName.changeType = 'increase' : boxName.changeType = 'decrease'
            }
        },
        handleGetPieChartDataRequest() {
            axios
                .get("/api/school/pie-chart-data")
                .then((res) => {
                    if (Array.isArray(res.data) && res.data.length > 0) {
                        const data = res.data;
                        this.pieChartData = data.map((item) => item.share_count);
                        this.pieChartLabels = data.map((item) => item.title);
                        this.isPieChartDataCalculated = true;
                    }
                })
                .catch((err) => console.log(err));
        },
        handleGetLineChartDataRequest() {
            axios
                .get("/api/school/line-chart-data")
                .then((res) => {
                    if (res.data !== 'Nothing is found') {
                        const blue = this.lineAreaChartData.find((item) => item.name === 'Previous');
                        const purple = this.lineAreaChartData.find((item) => item.name === 'Current');
                        const dashed = this.lineAreaChartData.find((item) => item.name === 'Prediction');
                        blue.data = res.data.previous;
                        purple.data = res.data.current;
                        dashed.data = res.data.prediction;
                        this.isLineChartDataCalculated = true;
                    }
                })
                .catch((err) => console.log(err));
        },
        handleGetActiveStudentsRequest() {
            axios
                .get("/api/school/active-students")
                .then((res) => {
                    const activeStudents = this.statsTop.find((item) => item.name === 'Active Students');
                        if(res.data !== 'unavailable to calculate') {
                            const data = res.data;
                            this.insightBoxDataPlaceholderInsertion(activeStudents, data.thirty, data.sixty, data.difference);
                        } else activeStudents.unavailable = true;
                })
                .catch((err) => console.log(err));
        },
        handleGetAvgTransactionsRequest() {
            axios
                .get("/api/school/average-transactions")
                .then((res) => {
                    const avgTransactions = this.statsTop.find((item) => item.name === 'Avg. Transactions Value');
                   if(res.data !== 'unavailable to calculate')
                   {
                       const data = res.data;
                       this.insightBoxDataPlaceholderInsertion(avgTransactions, data.thirty, data.sixty, data.difference)
                   } else avgTransactions.unavailable = true;
                })
                .catch((err) => console.log(err))
        },
        handleGetPendingTransactionsValueRequest() {
            axios
                .get("/api/school/pending-transactions-value")
                .then((res) => {
                    const pendingTransactions = this.statsBottom.find((item) => item.name === 'Pending Transactions Value');
                    if(res.data !== 'unavailable to calculate')
                    {
                        pendingTransactions.stat = res.data.total;
                        pendingTransactions.previousStat = res.data.date;
                    } else pendingTransactions.unavailable = true;
                    })
                        .catch((err) => console.log(err))
        },
        handleGetAvgStudentWeeklySpendingRequest() {
            axios
                .get("/api/school/average-student-weekly-spending")
                .then((res) => {
                    const avgTransactionsPerStudent = this.statsBottom.find((item) => item.name === 'Avg. Student weekly spending');
                    if(res.data !== 'unavailable to calculate')
                    {
                       const data = res.data;
                       this.insightBoxDataPlaceholderInsertion(avgTransactionsPerStudent, data.previous, data.past, data.difference);
                    } else avgTransactionsPerStudent.unavailable = true;
                })
                .catch((err) => console.log(err))
        },
    },
        mounted() {
            this.handleGetPieChartDataRequest();
            this.handleGetLineChartDataRequest();
            this.handleGetActiveStudentsRequest();
            this.handleGetAvgTransactionsRequest();
            this.handleGetPendingTransactionsValueRequest();
            this.handleGetAvgStudentWeeklySpendingRequest();
        },
    }
</script>
