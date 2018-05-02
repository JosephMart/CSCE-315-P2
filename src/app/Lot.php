<?php include_once "Partials.php"; ?>
<!DOCTYPE html>
<html>
<?= HtmlHeader("Home"); ?>

<body>
<?= Sidebar(); ?>
<div class="container">
    <div class="section">
        <h1 class="title" id="title">NO DATA FOUND</h1>
        <div class="grid-container grid-container-5">
            <div>
                <h1 class="grid-title">Total In</h1>
                <p class="grid-count" id="totalIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Total Out</h1>
                <p class="grid-count" id="totalOut"></p>
            </div>
            <div>
                <h1 class="grid-title">Average(per hour) In</h1>
                <p class="grid-count" id="averageIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Average(per hour) Out</h1>
                <p class="grid-count" id="averageOut"></p>
            </div>
            <div>
                <h1 class="grid-title">Min Entering in an Hour</h1>
                <p class="grid-count" id="minIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Min Exiting in an Hour</h1>
                <p class="grid-count" id="minOut"></p>
            </div>
            <div>
                <h1 class="grid-title">Max Entering in an Hour</h1>
                <p class="grid-count" id="maxIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Max Exiting in an Hour</h1>
                <p class="grid-count" id="maxOut"></p>
            </div>
            <div>
                <h1 class="grid-title">Median (per hour) In</h1>
                <p class="grid-count" id="medianIn"></p>
            </div>
            <div>
                <h1 class="grid-title">Median (per hour) Out</h1>
                <p class="grid-count" id="medianOut"></p>
            </div>
        </div>
    </div>

    <hr/>

    <div class="section">
        <h1 class="title">Select Prediction Dataset Date Range</h1>
        <div class="center">
            <input type="text" id="start-date" name="start-date" placeholder="Start Date" onfocus="(this.type='date')">
            <input type="text" id="end-date" name="end-date" placeholder="End Date" onfocus="(this.type='date')">
        </div>
        <div class="center">
            <div class="weekDays-selector">
                <input type="radio" id="sun" class="weekday" name="day"/>
                <label for="sun">S</label>
                <input type="radio" id="mon" class="weekday" name="day"/>
                <label for="mon">M</label>
                <input type="radio" id="tue" class="weekday" name="day"/>
                <label for="tue">T</label>
                <input type="radio" id="wed" class="weekday" name="day"/>
                <label for="wed">W</label>
                <input type="radio" id="thu" class="weekday" name="day"/>
                <label for="thu">T</label>
                <input type="radio" id="fri" class="weekday" name="day"/>
                <label for="fri">F</label>
                <input type="radio" id="sat" class="weekday" name="day"/>
                <label for="sat">S</label>
            </div>
        </div>
        <div class="center">
            <button class="button" onclick="runModel()">Run Prediction Model</button>
            <div id="prediction_chart"></div>
        </div>
    </div>

    <hr/>

    <div class="section">
        <h1 class="title">Lot Hourly Info</h1>
        <div id="chart_div"></div>
    </div>
</div>
<script>
    let lotId = getParam("id");

    function getActiveDay() {
        let ids = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        let j = 1;

        for (let i of ids) {
            let node = document.getElementById(i);

            if (node.checked) {
                return j;
            }
            j++;
        }
    }

    apiPost('LotInfo', { lotId }, function (resp) {
        let inOut = ["In", "Out"];
        let names = ["total", "average", "min", "max", "median", "average"];
        let items = [].concat(...names.map(x => [`${x}${inOut[0]}`, `${x}${inOut[1]}`]));

        for (let i of items) {
            document.getElementById(i).innerHTML = resp.analysis[i];
        }

        BarGraph(resp.dayGraph, function(date) {
            let d = moment(date);
            return `${d.format('hh:mm a')}\n${d.format('M/D')}\n${d.format('ddd')}`;
        });
        document.getElementById('title').innerText = `${resp.lotName} Data`;
    });

    function runModel() {
        let startDate = document.getElementById('start-date').value;
        let endDate = document.getElementById('end-date').value;
        let dayIndex = getActiveDay();
        let body = { startDate, endDate, lotId, dayIndex };

        apiPost('LotPrediction', body, function (resp) {
            BarGraph(resp.data, function (date) {
                return moment(date, 'hh:mm').format('hh:mm a');
            }, 'prediction_chart');
        })
    }
</script>
</body>
</html>