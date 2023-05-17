<template>
  <ApexChart
    width="100%"
    :options="chartOptions"
    :series="lineAreaChartData"
  ></ApexChart>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";
export default {
  components: {
    ApexChart: VueApexCharts,
  },
  data() {
    return {
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
          animations: {
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
          width: [3, 3, 4],
          curve: "smooth",
          dashArray: [0, 0, 5],
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
  props: {
    lineAreaChartData: {
      type: Array,
      required: true,
    },
  },
};
</script>
