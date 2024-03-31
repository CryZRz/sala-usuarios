import Chart from "chart.js/auto"

const ctx = document.getElementById("ctx").getContext("2d")

const pastelG = new Chart(ctx, {
    type: "pie",
    data: {
    labels: dataReport.labels,
    datasets: [{
      data: dataReport.data,
    }]
  }
})
