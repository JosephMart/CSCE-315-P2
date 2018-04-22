<?php
include_once "Partials.php";

// Fetch data
//var $url = $_SERVER['PHP_SELF'] ;
//$response = http_get("/api/Growth.php", array("timeout"=>1), $info);
//print_r($info);
?>
<!DOCTYPE html>
<html>
<?= HtmlHeader("Home"); ?>
<body>
<div id="curve_chart" style="width: 900px; height: 500px"></div>
<script type="text/javascript">

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            graph(data);
            console.log(data);
        }
    };

    xhttp.open("GET", "api/Growth.php", true);
    xhttp.send();

    function graph(list) {
        console.log(typeof list);
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            xhttp.open("GET", "api/Growth.php", true);
            xhttp.send();

            var data = google.visualization.arrayToDataTable(list);

            var options = {
                title: 'Company Performance',
                curveType: 'function',
                legend: {position: 'bottom'}
            };
            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    };
</script>
</body>
</html>

</body>
</html>