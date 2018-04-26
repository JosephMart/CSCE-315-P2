// API
function apiPost(endpoint, body, cb) {
    var xhttp = new XMLHttpRequest();
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
    var url = new URL(window.location.href);
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
    var graphData = [['Date Times', 'Entering', 'Exiting']];
    var row = {};


    for (var i = 0; i < dbData.length; i++) {
        row = dbData[i];
        graphData.push([formatDate(row.date), parseInt(row.exiting, 10), parseInt(row.entering, 10)]);
    }
    // Get Current range dates
    var endDate = graphData[1][0];
    var startDate = graphData[graphData.length - 1][0];

    function drawChart() {
        var chartDiv = document.getElementById('chart_div');
        var data = google.visualization.arrayToDataTable(graphData);

        var materialOptions = {
            // width: 900,
            chart: {
                title: 'Lot Info',
                subtitle: endDate + ' - ' + startDate
            },
            bars: 'vertical',
            vAxis: {format: 'decimal'},
            height: 400,
            // colors: ['#50191F', '#eed5ae']
        };

        function drawMaterialChart() {
            var materialChart = new google.charts.Bar(chartDiv);
            materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
        }

        drawMaterialChart();
    };

    // Google Charts setup
    google.charts.load('current', {'packages':['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawChart);
}