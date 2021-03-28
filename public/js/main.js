/* eslint-disable object-shorthand */

/* global Chart, coreui, coreui.Utils.getStyle, coreui.Utils.hexToRgba */

/**
 * --------------------------------------------------------------------------
 * CoreUI Boostrap Admin Template (v3.4.0): main.js
 * Licensed under MIT (https://coreui.io/license)
 * --------------------------------------------------------------------------
 */

/* eslint-disable no-magic-numbers */
// Disable the on-canvas tooltip
Chart.defaults.global.pointHitDetectionRadius = 1;
Chart.defaults.global.tooltips.enabled = false;
Chart.defaults.global.tooltips.mode = "index";
Chart.defaults.global.tooltips.position = "nearest";
Chart.defaults.global.tooltips.custom = coreui.ChartJS.customTooltips;
Chart.defaults.global.defaultFontColor = "#646470"; // eslint-disable-next-line no-unused-vars
var cardChart1 = new Chart(document.getElementById("card-chart1"), {
    type: "line",
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "My First dataset",
                backgroundColor: "transparent",
                borderColor: "rgba(255,255,255,.55)",
                pointBackgroundColor: coreui.Utils.getStyle("--primary"),
                data: [65, 59, 84, 84, 51, 55, 40],
            },
        ],
    },
    options: {
        tooltips: {
            custom: function (tooltipModel) {
                tooltipModel.opacity = 0;
            },
        },
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        scales: {
            xAxes: [
                {
                    gridLines: {
                        color: "transparent",
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: "transparent",
                    },
                },
            ],
            yAxes: [
                {
                    display: false,
                    ticks: {
                        display: false,
                        min: 35,
                        max: 89,
                    },
                },
            ],
        },
        elements: {
            line: {
                borderWidth: 1,
            },
            point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4,
            },
        },
    },
}); // eslint-disable-next-line no-unused-vars

var cardChart2 = new Chart(document.getElementById("card-chart2"), {
    type: "line",
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "My First dataset",
                backgroundColor: "transparent",
                borderColor: "rgba(255,255,255,.55)",
                pointBackgroundColor: coreui.Utils.getStyle("--info"),
                data: [1, 18, 9, 17, 34, 22, 11],
            },
        ],
    },
    options: {
        tooltips: {
            custom: function (tooltipModel) {
                tooltipModel.opacity = 0;
            },
        },
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        scales: {
            xAxes: [
                {
                    gridLines: {
                        color: "transparent",
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: "transparent",
                    },
                },
            ],
            yAxes: [
                {
                    display: false,
                    ticks: {
                        display: false,
                        min: -4,
                        max: 39,
                    },
                },
            ],
        },
        elements: {
            line: {
                tension: 0.00001,
                borderWidth: 1,
            },
            point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4,
            },
        },
    },
}); // eslint-disable-next-line no-unused-vars

