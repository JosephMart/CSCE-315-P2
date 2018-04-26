<?php include_once "Partials.php"; ?>
<!DOCTYPE html>
<html>
<?= HtmlHeader("Home"); ?>

<body>
<?= Sidebar(); ?>
<div class="container">
    <div class="section">
        <h1 class="title">Overall Data</h1>
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
    </div>

    <hr/>

    <div class="section">
        <h1 class="title">Select Lot</h1>
        <div class="lot-container" id="lots"></div>
    </div>
</div>
<script>
    function handleLotClick(e) {
        console.log(e.target.id);
        window.location.href = `Lot.php?id=${e.target.id}`;
    }
    apiPost("OverallData", {}, function (resp) {
        var inOut = ["In", "Out"];
        var names = ["total", "average", "min", "max", "median", "average"];
        var items = [].concat(...names.map(x => [`${x}${inOut[0]}`, `${x}${inOut[1]}`]));
        
        for (var i of items) {
            document.getElementById(i).innerHTML = resp.analysis[i];
        }

        BarGraph(resp.graphData, function(date) {
            return moment(date).format('MM/DD/Y');
        });
    });

    apiPost("Lots", {}, function (resp) {
        for (var i of resp) {
            // create a new div element
            var newDiv = document.createElement("div");
            // and give it some content
            var newContent = document.createTextNode(i.name);
            // add the text node to the newly created div
            newDiv.appendChild(newContent);
            newDiv.onclick = handleLotClick;
            newDiv.id = i.id;
            document.getElementById("lots").appendChild(newDiv);
        }
    });

    // google.charts.load('current', {packages: ['corechart', 'bar']});
    // google.charts.setOnLoadCallback(drawTrendlines);
    //
    // function drawTrendlines() {
    //     var data = new google.visualization.DataTable();
    //     data.addColumn('timeofday', 'Time of Day');
    //     data.addColumn('number', 'Motivation Level');
    //     data.addColumn('number', 'Energy Level');
    //
    //     data.addRows([
    //         [{v: [8, 0, 0], f: '8 am'}, 1, .25],
    //         [{v: [9, 0, 0], f: '9 am'}, 2, .5],
    //         [{v: [10, 0, 0], f:'10 am'}, 3, 1],
    //         [{v: [11, 0, 0], f: '11 am'}, 4, 2.25],
    //         [{v: [12, 0, 0], f: '12 pm'}, 5, 2.25],
    //         [{v: [13, 0, 0], f: '1 pm'}, 6, 3],
    //         [{v: [14, 0, 0], f: '2 pm'}, 7, 4],
    //         [{v: [15, 0, 0], f: '3 pm'}, 8, 5.25],
    //         [{v: [16, 0, 0], f: '4 pm'}, 9, 7.5],
    //         [{v: [17, 0, 0], f: '5 pm'}, 10, 10],
    //     ]);
    //
    //     var options = {
    //         title: 'Motivation and Energy Level Throughout the Day',
    //         trendlines: {
    //             0: {type: 'linear', lineWidth: 5, opacity: .3},
    //             1: {type: 'exponential', lineWidth: 10, opacity: .3}
    //         },
    //         hAxis: {
    //             title: 'Time of Day',
    //             format: 'h:mm a',
    //             viewWindow: {
    //                 min: [7, 30, 0],
    //                 max: [17, 30, 0]
    //             }
    //         },
    //         vAxis: {
    //             title: 'Rating (scale of 1-10)'
    //         }
    //     };
    //
    //     var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    //     chart.draw(data, options);
    // }
</script>
</body>
</html>