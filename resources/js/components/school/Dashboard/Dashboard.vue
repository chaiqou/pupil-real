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
                  <ApexChart width="850" type="line" :options="chartOptions" :series="series"></ApexChart>
            </div>
        </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";
import { startOfMonth, endOfMonth,eachDayOfInterval } from "date-fns";
import Pie from "@/components/ui/Charts/Pie.vue";

export default {
    components: {
        ApexChart: VueApexCharts,
        Pie,
    },
    data() {
        return {
            currentMonthDates: [],
            labels: ['example1', 'example2'],
            chartData: [40, 50, 12],
            series: [{
                name: "Session Duration",
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
            },
                {
                    name: "Page Views",
                    data: [null,null,7 , 4, 5, 6, 29, 37, 36, 51, 32, 35, 20,21,22,31],
                },
                {
                    name: 'Total Visits',
                    data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47],
                },
            ],
            chartOptions: {
                colors: ['#0061F2', '#6900C7', '#cac8cb' ],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: true,
                        tools: {
                            download: false
                        }
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [5, 7, 5],
                    curve: 'smooth',
                    dashArray: [0, 0, 2]
                },
                title: {
                    show: false
                },
                legend: {
                    tooltipHoverFormatter: function(val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    }
                },
                markers: {
                    size: 0,
                    hover: {
                        sizeOffset: 6
                    }
                },
                xaxis: {
                    categories: this.currentMonthDates,
                },
                tooltip: {
                    y: [
                        {
                            title: {
                                formatter: function (val) {
                                    return val + " (mins)"
                                }
                            }
                        },
                        {
                            title: {
                                formatter: function (val) {
                                    return val + " per session"
                                }
                            }
                        },
                        {
                            title: {
                                formatter: function (val) {
                                    return val;
                                }
                            }
                        }
                    ]
                },
                grid: {
                    borderColor: '#f1f1f1',
                }
            },
        }
            },
            mounted() {
                const start = startOfMonth(new Date());
                const end = endOfMonth(new Date());
                this.currentMonthDates = eachDayOfInterval({ start, end }).map(date =>
                    date.toLocaleDateString('en-US', { day: '2-digit', month: 'short' })
                );
                console.log(this.currentMonthDates)

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
