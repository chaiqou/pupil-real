<template>
    <div class="grid grid-template-areas-1x2 mt-10">
        <div class="grid-area-1">1</div>
        <div class="grid-area-2">2</div>
    </div>
    <div class="grid grid-template-areas-1x3 mt-10">
        <div class="grid-area-3">
            <div class="w-[25rem]">
                <canvas id="chartRound"></canvas>
            </div>

        </div>
        <div class="grid-area-4">
            <div>
                <canvas id="chartLine"></canvas>
            </div>
        </div>
        <div class="grid-area-5">3</div>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';
import { getRelativePosition } from 'chart.js/helpers';
import { startOfMonth, getDaysInMonth, addDays, format } from "date-fns";

export default {
    data () {
        return {
        daysOfMonth: [],
            object: [],
        }
    },
    mounted() {
        let currentDate = new Date()
        let firstDay = startOfMonth(currentDate)
        let daysInMonth = getDaysInMonth(currentDate)
        for (let i = 1; i <= daysInMonth; i++) {
            let day = addDays(firstDay, i-1)
            let formattedDay = format(day, 'dd')
            this.daysOfMonth.push(formattedDay)
        }

        //Round Chart
        const dataForRoundChart = {
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 150, 99],
                backgroundColor: [
                    'rgb(98, 192, 255)',
                    'rgb(109, 168, 255)',
                    'rgb(0, 97, 242)',
                    'rgb(0, 30, 74)'
                ],
                hoverOffset: 4
            }],
            labels: [
                '1',
                'Blue',
                '3',
                'Green'
            ],
        };

        const ctxRound = document.getElementById('chartRound');
        const chartRound = new Chart(ctxRound, {
            type: 'doughnut',
            data: dataForRoundChart,
            options: {
                plugins: {
                  legend: {
                      display: true,
                      position: 'bottom',
                      labels: {
                          padding: 24,
                      }
                  }
                },
                onClick: (e) => {
                    const canvasPosition = getRelativePosition(e, chartRound);

                    // Substitute the appropriate scale IDs
                    const dataX = chartRound.scales.x.getValueForPixel(canvasPosition.x);
                    const dataY = chartRound.scales.y.getValueForPixel(canvasPosition.y);
                }
            }
        });

        // data generating
        const data = [
            {
                label: 'label123',
                data: [99,94,91,83,45,45,45,45],
                borderColor: 'rgb(99,99,211)'
            },
            {
                label: 'example3',
                data: [3,23,95,95,95,52,52],
                borderColor: 'rgb(42,212,43)'
            }
        ]

        data.forEach((element) => {
             let objectData = {
                label: element.label,
                data: element.data,
                borderColor: element.borderColor,
                yAxisID: 'yAxis',
                xAxisID: 'xAxis',
            }
            this.object.push(objectData);
        })
        //
        console.log(this.object);

       //Line area chart
        const labels = this.daysOfMonth;
        const dataLine = {
            labels: labels,
            datasets:
                this.object
            //     {
            //     label: 'Monro',
            //     data: [10,10,10,10,10,10,10],
            //     borderColor: 'rgb(75,192,192)',
            //     yAxisID: 'yAxis',
            //     xAxisID: 'xAxis',
            // },
            //     {
            //         label: 'Example',
            //         data: [4,6,9,4,66,3],
            //         borderColor: 'rgb(33,12,174)',
            //         yAxisID: 'yAxis',
            //         xAxisID: 'xAxis',
            //     },
            ,
        };

        const ctxLine = document.getElementById('chartLine');
        const chartLine = new Chart(ctxLine, {
            type: 'line',
            data: dataLine,
            options: {
                elements: {
                    point: {
                    radius: 0
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    }
                },
                scales: {
                  yAxis: {
                      border: {
                          dash: [5,5,5]
                      },
                  },
                    xAxis: {
                        grid: {
                            display: false,
                        }
                    }
                },
                onClick: (e) => {
                    const canvasPosition = getRelativePosition(e, chartLine);

                    // Substitute the appropriate scale IDs
                    const dataX = chartLine.scales.x.getValueForPixel(canvasPosition.x);
                    const dataY = chartLine.scales.y.getValueForPixel(canvasPosition.y);
                }
            }
        });
    }



}
</script>

<style>
.grid-template-areas-1x2 {
    grid-template-areas:
    "top-left top-right";
}
.grid-template-areas-1x3 {
    grid-template-areas:
    "left mid right";
}
.grid-area-1 {
    grid-area: top-left;
}
.grid-area-2 {
    grid-area: top-right;
}
.grid-area-3 {
    grid-area: left;
}
.grid-area-4 {
    grid-area: mid;
}
.grid-area-5{
    grid-area: right;
}
</style>
