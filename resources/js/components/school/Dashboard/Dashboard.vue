<template>
    <div class="grid grid-template-areas-2x2 mt-10">
        <div class="grid-area-1">1</div>
        <div class="grid-area-2">2</div>
        <div class="grid-area-3 mt-32">
            <div class="w-full">
                <Pie width="500" id="RandomChart" :chartData="this.chartData" :labels="this.labels"></Pie>
            </div>
        </div>
            <div class="grid-area-4 mt-32">
<!--                <div>-->
<!--                    <Doughnut v-if="this.dataForRoundChart" :chartData="this.dataForRoundChart"></Doughnut>-->
<!--                </div>-->
            </div>
        </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";
import { startOfMonth, getDaysInMonth, addDays, format } from "date-fns";
import Pie from "@/components/ui/Charts/Pie.vue";

export default {
    components: {
        ApexChart: VueApexCharts,
        Pie,
    },
    data () {
        return {
            labels: ['example1', 'example2'],
            chartData: [40,50, 12]
        }
    },
    mounted() {
    //     this.dataForRoundChart = {
    //         datasets: [{
    //             label: 'My First Dataset',
    //             data: [300, 50, 150, 99],
    //             backgroundColor: [
    //                 'rgb(98, 192, 255)',
    //                 'rgb(109, 168, 255)',
    //                 'rgb(0, 97, 242)',
    //                 'rgb(0, 30, 74)'
    //             ],
    //             hoverOffset: 4,
    //         }],
    //         labels: [
    //             '1',
    //             'Blue',
    //             '3',
    //             'Green'
    //         ],
    //     };
    //
    //
    //     // data generating
    //     const data = [
    //         {
    //             label: 'label123',
    //             data: [99,94,91,83,45,45,45,45],
    //             borderColor: 'rgb(99,99,211)'
    //         },
    //         {
    //             label: 'example3',
    //             data: [3,23,95,95,95,52,52],
    //             borderColor: 'rgb(42,212,43)'
    //         }
    //     ]
    //
    //     data.forEach((element) => {
    //          let objectData = {
    //             label: element.label,
    //             data: element.data,
    //             borderColor: element.borderColor,
    //             yAxisID: 'yAxis',
    //             xAxisID: 'xAxis',
    //         }
    //         this.object.push(objectData);
    //     })
    //     //
    //     console.log(this.object);
    //
    //    //Line area chart
    //     const labels = this.daysOfMonth;
    //     const dataLine = {
    //         labels: labels,
    //         datasets: this.object
    //     };
    //
    //     const ctxLine = document.getElementById('chartLine');
    //     const chartLine = new Chart(ctxLine, {
    //         type: 'line',
    //         data: dataLine,
    //         options: {
    //             elements: {
    //                 point: {
    //                 radius: 0
    //                 }
    //             },
    //             plugins: {
    //                 legend: {
    //                     display: true,
    //                     position: 'bottom',
    //                     labels: {
    //                         usePointStyle: true,
    //                         pointStyle: 'circle',
    //                     }
    //                 }
    //             },
    //             scales: {
    //               yAxis: {
    //                   border: {
    //                       dash: [5,5,5]
    //                   },
    //               },
    //                 xAxis: {
    //                     grid: {
    //                         display: false,
    //                     }
    //                 }
    //             },
    //             onClick: (e) => {
    //                 const canvasPosition = getRelativePosition(e, chartLine);
    //
    //                 // Substitute the appropriate scale IDs
    //                 const dataX = chartLine.scales.x.getValueForPixel(canvasPosition.x);
    //                 const dataY = chartLine.scales.y.getValueForPixel(canvasPosition.y);
    //             }
    //         }
    //     });
     }



}
</script>
<style>
.grid-template-areas-2x2 {
    grid-template-areas:
    "top-left top-right"
    "bottom-left bottom-right";
}
.grid-area-1 {
    grid-area: top-left;
}
.grid-area-2 {
    grid-area: top-right;
}
.grid-area-3 {
    grid-area: bottom-left;
}
.grid-area-4 {
    grid-area: bottom-right;
}
</style>
