var ctx = $("#cardGraph").get(0).getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    options: {
        responsive: true,
        maintainAspectRatio: false,
    },
    data: {
        datasets: []
    }
});

function createGraphInstance(times, temperatures, phs, humidites) {
    myChart.data.labels = times;
    myChart.data.datasets = [{
        label: 'Température par le temps',
        data: temperatures,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
    }, {
        label: 'Potentiel hydrogène par le temps',
        data: phs,
        fill: false,
        borderColor: 'rgb(180, 50, 20)',
        tension: 0.1
    },{
        label: 'Humidité par le temps',
        data: humidites,
        fill: false,
        borderColor: 'rgb(100, 50, 180)',
        tension: 0.1
    }];
    myChart.update();
}