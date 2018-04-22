<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<?php include 'PHPQueries.php'; ?>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawHourChart);
			google.charts.setOnLoadCallback(drawWeekChart);
			
			function drawHourChart() {
				var data = new google.visualization.DataTable();

				data.addColumn('number', 'Hour');
				data.addColumn('number', 'People');

				<?php getHourTotal(); ?>

				var options = {
					height: 300,
					animation: {
						startup: true,
						duration: 1000,
						easing: 'out'
					},
					title: 'Popular Hours', 
					backgroundColor:'#444b6e', 
					colors: ['#9ab87a'], 
					fontName: 'BebasNeue', 
					titleTextStyle: {
						color: '#f8f991',
						fontSize: 30
					},
					hAxis: {
						baselineColor: '#f8f991',
						textStyle: {
							color: '#f8f991',
							fontSize: 20
						},
						gridlines: {
							color: 'transparent'
						}
					},
					vAxis: {
						baselineColor: '#f8f991',
						textStyle: {
							color: '#f8f991',
							fontSize: 20
						},
						gridlines: {
							color: 'transparent'
						}
					},
					legend: {
						position: 'none'
					}
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('hourGraph'));
				chart.draw(data, options);
			}

			function drawWeekChart() {
				var data = new google.visualization.DataTable();

				data.addColumn('string', 'Weekday');
				data.addColumn('number', 'People');

				<?php getPastWeekTotal(); ?>

				var options = {
					height: 300,
					animation: {
						startup: true,
						duration: 1000,
						easing: 'out'
					},
					title: 'Last Week', 
					backgroundColor:'#444b6e', 
					colors: ['#9ab87a'], 
					fontName: 'BebasNeue', 
					titleTextStyle: {
						color: '#f8f991',
						fontSize: 30
					},
					hAxis: {
						textStyle: {
							color: '#f8f991',
							fontSize: 20
						}
					},
					vAxis: {
						baselineColor: '#f8f991',
						textStyle: {
							color: '#f8f991',
							fontSize: 20
						},
						gridlines: {
							color: 'transparent'
						}
					},
					legend: {
						position: 'none'
					}
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('weekGraph'));
				chart.draw(data, options);
			}
		</script>

		<?php $tot = getAllCounts(); $aver = getAverages(); ?>

		<div class="container">
			<div class="navbar">
				<span class="navbarText"> Walking Counter </span>
			</div>

			<div class="dayStatHolder" style="grid-area: 3 / 2 / 4 / 3;">
				<div class="center">
					<h1><i><?php echo $tot[4]; ?></i></h1><br>
					<h3>in the last <br>hour</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 3 / 3 / 4 / 4;">
				<div class="center">
					<h1><i><?php echo $tot[3]; ?></i></h1><br>
					<h3>in the last <br>day</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 3 / 4 / 4 / 5;">
				<div class="center">
					<h1><i><?php echo $tot[2]; ?></i></h1><br>
					<h3>in the last <br>week</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 3 / 5 / 4 / 6;">
				<div class="center">
					<h1><i><?php echo $tot[1]; ?></i></h1><br>
					<h3>in the last <br>month</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 3 / 6 / 4 / 7;">
				<div class="center">
					<h1><i><?php echo $tot[0]; ?></i></h1><br>
					<h3>in the last <br>year</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 5 / 2 / 6 / 3;">
				<div class="center">
					<h1><i><?php echo $aver[4]; ?></i></h1><br>
					<h3>per<br>hour</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 5 / 3 / 6 / 4;">
				<div class="center">
					<h1><i><?php echo $aver[3]; ?></i></h1><br>
					<h3>per<br>day</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 5 / 4 / 6 / 5;">
				<div class="center">
					<h1><i><?php echo $aver[2]; ?></i></h1><br>
					<h3>per<br>week</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 5 / 5 / 6 / 6;">
				<div class="center">
					<h1><i><?php echo $aver[1]; ?></i></h1><br>
					<h3>per<br>month</h3>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 5 / 6 / 6 / 7;">
				<div class="center">
					<h1><i><?php echo $aver[0]; ?></i></h1><br>
					<h3>per<br>year</h3>
				</div>
			</div>

			<div class="graphHolder" style="grid-area: 3 / 7 / 4 / 8">
				<div class="center">
					<div id="hourGraph"></div>
				</div>
			</div>

			<div class="graphHolder" style="grid-area: 5 / 7 / 6 / 8">
				<div class="center">
					<div id="weekGraph"></div>
				</div>
			</div>

			<div style="background-color: #708b75; grid-area: 4 / 2 / 5 / 6;"></div>
			<div style="background-color: #9ab87a; grid-area: 4 / 5 / 5 / 7;"></div>
			<div style="background-color: #f8f991; grid-area: 4 / 7 / 5 / 8;"></div>


			<div style="background-color: #708b75; grid-area: 6 / 2 / 7 / 6;"></div>
			<div style="background-color: #9ab87a; grid-area: 6 / 5 / 7 / 7;"></div>
			<div style="background-color: #f8f991; grid-area: 6 / 7 / 7 / 8;"></div>

			<div class="dayStatHolder" style="grid-area: 7 / 7 / 8 / 8;">
				<div class="center">
					<h1><i><?php echo getTotalRows(); ?></i></h1><br>
					<h3>counted in total</h3>
				</div>
			</div>

			<div class="queryHolder">
				<div class="center">
					<h1>Pick a Range</h1>
					<h3>Get the sensor data gathered from a specific range.</h3>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post' name='form2'>
						<span style="padding-right: 0.5em"><b>Start D & T:</b></span><input type='date' name='queryFirstDate'><input type="time" name="queryFirstTime"><br>
						<span style="padding-right: 0.5em"><b>Final D & T:</b></span><input type="date" name="queryLastDate"><input type="time" name="queryLastTime"><br>
						<input type='submit' name='submit' value='submit'>
					</form>
				</div>
			</div>

			<div class="dayStatHolder" style="grid-area: 7 / 6 / 8 / 7;">
				<div class="center">
					<h1><i>

					<?php 
						if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit']))
						{
							$fixFirstTime = $_POST["queryFirstTime"] . ":00";
							$fixLastTime = $_POST["queryLastTime"] . ":00";

							echo getTotalOverPeriod($_POST["queryFirstDate"], $fixFirstTime, $_POST["queryLastDate"], $fixLastTime);
						}
					 ?>
					 	
					 </i></h1><br>
					<h3>counted in the range</h3>
				</div>
			</div>			


		</div>
	</body>
</html>