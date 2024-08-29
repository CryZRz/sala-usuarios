import Chart from 'chart.js/auto';

const dataReportFormat = dataReport.reduce((acum, report) => {
    acum.push({
        applicationId: report.application.id,
        careers: report.careersUse.map(career => career.career),
        countUse: report.careersUse.map(countUse => countUse.countUse),
    })

    return acum
}, [])

dataReportFormat.map(report => {
    const classNameElement = `ctx-${report.applicationId}`
    const ctx = document.getElementById(classNameElement).getContext("2d")

    new Chart(ctx, {
        type: "pie",
        data: {
            labels: report.careers,
            datasets: [{
                data: report.countUse,
            }]
        }
    })
})
