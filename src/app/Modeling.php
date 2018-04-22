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
            console.log(this.responseText);
            var data = JSON.parse(this.responseText);
            graph(data.data, data.lot_num);
            console.log(data);
        }
    };

    xhttp.open("GET", "api/Growth.php", true);
    xhttp.send();

    function graph(list,Lot) {
        console.log(typeof list);
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

          var data = google.visualization.arrayToDataTable(list);

          var options = {
            title: 'Projected growth of hourly rate in lot ' + Lot,
            curveType: 'function',
            legend: { position: 'bottom' },
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
        }
    };
</script>
</body>
</html>

</body>
</html>