<template>
  <div class="w-full">
    <ApexChart
      :width="width"
      type="pie"
      :options="chartOptions"
      :series="pieChartData"
    ></ApexChart>
  </div>
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
        colors: null,
        legend: {
          position: "bottom",
        },
        chart: {
          animations: {
            enabled: false,
          },
          id: this.id,
        },
        labels: this.labels,
      },
      series: this.pieChartData,
    };
  },
  props: {
    width: {
      type: String,
      required: false,
      default: "100%",
    },
    pieChartData: {
      type: Array, // Array of numbers (not string)
      required: true,
    },
    labels: {
      type: Array,
      required: true,
    },
    id: {
      type: String,
      required: true,
    },
  },
  mounted() {
    if (this.pieChartData.length === 2) {
      this.chartOptions.colors = ["#0061F2", "#6900C7"];
    }
    if (this.pieChartData.length === 3) {
      this.chartOptions.colors = ["#0061F2", "#3531DD", "#6900C7"];
    }
    if (this.pieChartData.length === 4) {
      this.chartOptions.colors = ["#0061F2", "#2341E4", "#4620D5", "#6900C7"];
    }
    if (this.pieChartData.length === 5) {
      this.chartOptions.colors = [
        "#0061F2",
        "#1A49E7",
        "#3531DD",
        "#4F18D2",
        "#6900C7",
      ];
    }
    if (this.pieChartData.length === 6) {
      this.chartOptions.colors = [
        "#0061F2",
        "#154EE9",
        "#2A3AE1",
        "#3F27D8",
        "#5413D0",
        "#6900C7",
      ];
    }
    if (this.pieChartData.length === 7) {
      this.chartOptions.colors = [
        "#0061F2",
        "#1151EB",
        "#2341E4",
        "#3531DD",
        "#4620D5",
        "#5810CE",
        "#6900C7",
      ];
    }
    if (this.pieChartData.length === 8) {
      this.chartOptions.colors = [
        "#0061F2",
        "#0F53EC",
        "#1E45E6",
        "#2D37E0",
        "#3C2AD9",
        "#4B1CD3",
        "#5A0ECD",
        "#6900C7",
      ];
    }
    if (this.pieChartData.length === 9) {
      this.chartOptions.colors = [
        "#0061F2",
        "#0D55ED",
        "#1A49E7",
        "#273DE2",
        "#3531DD",
        "#4224D7",
        "#4F18D2",
        "#5C0CCC",
        "#6900C7",
      ];
    }
  },
};
</script>
