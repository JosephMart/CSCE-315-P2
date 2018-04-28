<?php include_once "Partials.php"; ?>
<!DOCTYPE html>
<html>
<?= HtmlHeader("Home"); ?>

<body>
<?= Sidebar(); ?>
<div class="container">
    <h1 class="title">Lots</h1>
    <div class="lot-container" id="lots"></div>
    <hr>
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
        <div id="chart_div2"></div>
    </div>
</div>
<script>
    /**
     * Hand the lot selection onClick to navigate to the lot page
     * @param e event
     */
    function handleLotClick(e) {
        console.log(e.target.id);
        window.location.href = `Lot.php?id=${e.target.id}`;
    }

    /**
     * Fetch request for overall lot graphs
     */
    apiPost("OverallData", {}, function (resp) {
        let inOut = ["In", "Out"];
        let names = ["total", "average", "min", "max", "median", "average"];
        let items = [].concat(...names.map(x => [`${x}${inOut[0]}`, `${x}${inOut[1]}`]));
        
        for (let i of items) {
            document.getElementById(i).innerHTML = resp.analysis[i];
        }

        BarGraph(resp.graphData, function(date) {
            return moment(date).format('MM/DD/Y');
        });
        TrendLineGraph(resp.graphData, function(date) {
            return moment(date).format('MM/DD/Y');
        });
    });

    /**
     * Display lots to select
     */
    apiPost("Lots", {}, function (resp) {
        for (let i of resp) {
            // create a new div element
            let newDiv = document.createElement("div");
            // and give it some content
            let newContent = document.createTextNode(i.name);
            // add the text node to the newly created div
            newDiv.appendChild(newContent);
            newDiv.onclick = handleLotClick;
            newDiv.id = i.id;
            document.getElementById("lots").appendChild(newDiv);
        }
    });
</script>
</body>
</html>