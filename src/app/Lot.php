<?php include_once "Partials.php"; ?>
<!DOCTYPE html>
<html>
<?= HtmlHeader("Home"); ?>

<body>
<?= Sidebar(); ?>
<div class="container">
    <div class="section">
        <h1 class="title" id="title">NO DATA FOUND</h1>
        <div class="grid-container-5">
            <div>
                <h1 class="grid-title">Total In</h1>
                <p class="grid-count" id="totalIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Total Out</h1>
                <p class="grid-count" id="totalOut"></p>
            </div>
            <div>
                <h1 class="grid-title">Average(per day) In</h1>
                <p class="grid-count" id="averageIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Average(per day) Out</h1>
                <p class="grid-count" id="averageOut"></p>
            </div>
            <div>
                <h1 class="grid-title">Min Entering in a Day</h1>
                <p class="grid-count" id="minIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Min Exiting in a Day</h1>
                <p class="grid-count" id="minOut"></p>
            </div>
            <div>
                <h1 class="grid-title">Max Entering in a Day</h1>
                <p class="grid-count" id="maxIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Max Exiting in a Day</h1>
                <p class="grid-count" id="maxOut"></p>
            </div>
            <div>
                <h1 class="grid-title">Median (per day) In</h1>
                <p class="grid-count" id="medianIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Median (per day) Out</h1>
                <p class="grid-count" id="medianOut"></p>
            </div>
        </div>
    </div>

    <hr/>

    <div class="section">
        <div id="chart_div"></div>
        <div id="projection_chart"></div>
    </div>
</div>
<script>
    var lotId = getParam("id");

    apiPost('LotInfo', {lotId: lotId}, function (resp) {
        var inOut = ["In", "Out"];
        var names = ["total", "average", "min", "max", "median", "average"];
        var items = [].concat(...names.map(x => [`${x}${inOut[0]}`, `${x}${inOut[1]}`]));

        for (var i of items) {
            document.getElementById(i).innerHTML = resp.analysis[i];
        }

        BarGraph(resp.dayGraph, function(date) {
            return moment(date).format('hh:mm a');
            // return moment(date).format('MM/DD/Y');
        });
        document.getElementById('title').innerText = `${resp.lotName} Data`;
    });

    apiPost("Growth", {}, function (resp) {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(function () {
            var data = google.visualization.arrayToDataTable(resp.data);
            console.table(resp.data)
            var options = {
                title: resp.title,
                height: 1000,
                curveType: 'function',
                legend: {position: 'bottom'},
                series : {
                    0: { lineDashStyle: [0, 0] },
                    1: { lineDashStyle: [4, 1] },
                    2: { lineDashStyle: [4, 1] },
                    3: { lineDashStyle: [4, 1] },
                },
                colors: ['#000000', '#05b749', '#1468e5', '#7034af'],
            };
            var chart = new google.visualization.LineChart(document.getElementById('projection_chart'));
            chart.draw(data, options);
        });
    });
</script>
</body>
</html>