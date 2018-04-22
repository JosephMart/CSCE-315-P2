<?php
	include('CommonMethods.php');
	$debug = False;

	$COMMON = new Common($debug);

	date_default_timezone_set('America/Chicago');
	
	// ~ calculates the hour percentage ~
	function getHourTotal()
	{
		global $COMMON;
		global $totalRows;

		for ($i = 0; $i < 24; $i++)
		{
			$time = sprintf("%02d", $i);
			$minTime = "$time" . ":00:00";
			$maxTime = "$time" . ":59:59";

			$sql = "SELECT * FROM `WalkingCounterDatabase` WHERE `Time` BETWEEN '$minTime' AND '$maxTime'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["PHP_SELF"]);

			$total = $rs->rowCount();
			//$percent = $percent / $totalRows;

			echo "data.addRow([" . $i . ", " . $total . "]);";
		}	
	}

	// ~ calculate weekly totals ~
	function getPastWeekTotal()
	{
		global $COMMON;
		$lastSaturday = date('Y-m-d', strtotime("last Saturday"));
		$lastSunday = date('Y-m-d', strtotime("-6 days", strtotime($lastSaturday)));
		$date = $lastSunday;

		for ($i = 0; $i < 7; $i++)
		{
			$total = getCount($date);
			echo "data.addRow([\"" . date('j/n/y', strtotime($date)) . "\", " . $total . "]);";
			//echo ($date . " " . date('l', strtotime($date)) . "<br>");
			$date = date('Y-m-d', strtotime($date . ' +1 day'));
		}
	}

	// ~ gets all averages ~
	function getAverages()
	{	
		// ~ get total entries ~
		global $COMMON;
		$totalsql = "SELECT COUNT(Count) AS total FROM `WalkingCounterDatabase`";
		$totalrs = $COMMON->executeQuery($totalsql, $_SERVER["PHP_SELF"]);

		$totalrow = $totalrs->fetch(PDO::FETCH_ASSOC);
		$totalentries = $totalrow['total'];	

		// ~ get earliest entry ~
		$earliestsql = "SELECT MIN(`Date`) AS min FROM `WalkingCounterDatabase`";
		$earliestrs = $COMMON->executeQuery($earliestsql, $_SERVER["PHP_SELF"]);

		$earliestrow = $earliestrs->fetch(PDO::FETCH_ASSOC);
		$earliestDate = $earliestrow['min'];	

		// ~ get number of hours/days/weeks/months/years between the earliest date and the current date ~
		$firstDate = new DateTime($earliestDate);
		$lastDate = new DateTime();

		$diff = $lastDate->diff($firstDate);

		$years = intval($diff->y) + 1;
		$months = intval($diff->m) + 1 + 12 * intval($diff->y);
		$weeks = (int) (floor(intval($diff->days) / 7)) + 1;
		$days = intval($diff->days) + 1;
		$hours = intval($diff->h) + 1 + (intval($diff->days)) * 24;

		// ~ return array with all values ~
		$averages = array($totalentries / $years, $totalentries / $months, $totalentries / $weeks, $totalentries / $days, $totalentries / $hours);

		foreach($averages as &$value)
		{
			$value = number_format((float)$value, 2, '.', '');
		}
		unset($value);

		return $averages;
	}


	function getAllCounts()
	{
		$currentDate = new DateTime();

		$yearDiff = clone $currentDate;
		$yearDiff->modify("-1 year");
		$yearTotal = getTotalOverPeriod($yearDiff->format("Y-m-d"), "00:00:00", $currentDate->format("Y-m-d"), "23:59:59");

		$monthDiff = clone $currentDate;
		$monthDiff->modify("-1 month");
		$monthTotal = getTotalOverPeriod($monthDiff->format("Y-m-d"), "00:00:00", $currentDate->format("Y-m-d"), "23:59:59");

		$weekDiff = clone $currentDate;
		$weekDiff->modify("-1 week");
		$weekTotal = getTotalOverPeriod($weekDiff->format("Y-m-d"), "00:00:00", $currentDate->format("Y-m-d"), "23:59:59");		

		$dayDiff = clone $currentDate;
		$dayDiff->modify("-1 day");
		$dayTotal = getTotalOverPeriod($dayDiff->format("Y-m-d"), "00:00:00", $currentDate->format("Y-m-d"), "23:59:59");

		$hourDiff = clone $currentDate;
		$hourDiff->modify("-1 hour");
		$hourTotal = getTotalOverPeriod($hourDiff->format("Y-m-d"), $hourDiff->format("H:i:s"), $currentDate->format("Y-m-d"), $currentDate->format("H:i:s"));

		$totals = array($yearTotal, $monthTotal, $weekTotal, $dayTotal, $hourTotal);
		return $totals;
	}

	// ~ get count for a specific day ~
	function getCount($date)
	{
		global $COMMON;
		$sql = "SELECT COUNT(Count) AS total FROM `WalkingCounterDatabase` WHERE `Date` LIKE '$date'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["PHP_SELF"]);

		$row = $rs->fetch(PDO::FETCH_ASSOC);
		return $row['total'];
	}

	// ~ gets the total over any period of time ~
	function getTotalOverPeriod($startDate, $startTime, $endDate, $endTime)
	{
		global $COMMON;
		$sql = "SELECT COUNT(Count) AS total FROM `WalkingCounterDatabase` WHERE (`Date` BETWEEN '$startDate' AND '$endDate') AND (`Time` BETWEEN '$startTime' AND '$endTime')";
		$rs = $COMMON->executeQuery($sql, $_SERVER["PHP_SELF"]);

		$row = $rs->fetch(PDO::FETCH_ASSOC);
		return $row['total'];
	}

	// ~ gets the number of rows ~
	function getTotalRows()
	{
		global $COMMON;
		$sql = "SELECT COUNT(Count) AS total FROM `WalkingCounterDatabase`";
		$rs = $COMMON->executeQuery($sql, $_SERVER["PHP_SELF"]);
		
		$row = $rs->fetch(PDO::FETCH_ASSOC);
		return $row['total'];
	}
?>