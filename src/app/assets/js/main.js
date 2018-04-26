// API
function apiPost(endpoint, body, cb) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            cb(JSON.parse(this.responseText));
        }
    };

    xhttp.open("POST", "api/" + endpoint + ".php", true);
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhttp.send(JSON.stringify(body));
}

function getParam(key) {
    let url = new URL(window.location.href);
    return url.searchParams.get(key);
}
// Nav functions
function openNav() {
    document.getElementById("mySidenav").className = "sidenav";
}

function closeNav() {
    document.getElementById("mySidenav").className= "navHidden";
}

function BarGraph(dbData, formatDate) {
    let graphData = [['Date Times', 'Entering', 'Exiting']];
    let row = {};


    for (let i = 0; i < dbData.length; i++) {
        row = dbData[i];
        graphData.push([formatDate(row.date), parseInt(row.exiting, 10), parseInt(row.entering, 10)]);
    }
    // Get Current range dates
    let endDate = graphData[1][0];
    let startDate = graphData[graphData.length - 1][0];

    function drawChart() {
        let chartDiv = document.getElementById('chart_div');
        let data = google.visualization.arrayToDataTable(graphData);

        let materialOptions = {
            // width: 900,
            chart: {
                title: 'Lot Info',
                subtitle: endDate + ' - ' + startDate
            },
            trendlines: {
                0: {},
                // 1: {type: 'exponential', lineWidth: 10, opacity: .3}
            },
            bars: 'vertical',
            vAxis: {format: 'decimal'},
            height: 400,
            // colors: ['#50191F', '#eed5ae']
        };

        function drawMaterialChart() {
            let materialChart = new google.charts.Bar(chartDiv);
            materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
        }

        drawMaterialChart();
    }

    // Google Charts setup
    google.charts.load('current', {'packages':['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawChart);
}

function TrendLineGraph(dbData, formatDate) {
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawTrendlines);

    let graphData = [['Date Times', 'Entering', 'Exiting']];
    let row = {};


    for (let i = 0; i < dbData.length; i++) {
        row = dbData[i];
        graphData.push([formatDate(row.date), parseInt(row.exiting, 10), parseInt(row.entering, 10)]);
    }
    // Get Current range dates
    let endDate = graphData[1][0];
    let startDate = graphData[graphData.length - 1][0];

    function drawTrendlines() {
        let data = google.visualization.arrayToDataTable(graphData);

        let options = {
            title: 'Lot Info',
            trendlines: {
                0: {type: 'linear', lineWidth: 5, opacity: .3},
                // 1: {type: 'exponential', lineWidth: 10, opacity: .3}
            }
        };

        let chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
    }
}