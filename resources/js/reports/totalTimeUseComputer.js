import Chart from 'chart.js/auto';

const dataReportFormat = dataReport.reduce((acum, report) => {
    acum.push({
        computerId: report.computerId,
        careers: report.careersUse.map(career => career.career),
        timeUse: report.careersUse.map(time => time.timeUseInHours),
    })

    return acum
}, [])


dataReportFormat.map(report => {
    const classNameElement = `ctx-${report.computerId}`
    const ctx = document.getElementById(classNameElement).getContext("2d")

    new Chart(ctx, {
        type: "pie",
        data: {
            labels: report.careers,
            datasets: [{
                data: report.timeUse,
            }]
        }
    })
})
