<?php include_once "Partials.php"; ?>
<!DOCTYPE html>
<html>
<?= HtmlHeader("Home"); ?>
<body>
<div id="curve_chart" style="width: 900px; height: 500px"></div>
<script type="text/javascript">
    apiPost("Growth", {}, function (resp) {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(function () {
            var data = google.visualization.arrayToDataTable(resp.data);
            var options = {
                title: resp.title,
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
            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        });
    });
</script>
</body>
</html>