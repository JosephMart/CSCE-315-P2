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
                legend: {position: 'bottom'}
            };
            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        });
    });
</script>
</body>
</html>