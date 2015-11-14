<?php
include "../classes/database.php";
include "../config/config.php";

$db = new Database();

$sql = "INSERT INTO `history`(`sensorID`, `day`, `maximal`, `minimum`, `average`, `valid`, `hits`)
		SELECT sensorID, DATE_FORMAT(added, '%Y-%m-%d') AS DF, format(max(measurement),3) as maximum, format(min(measurement),3) as minimum, format(avg(measurement),3) as average, valid, count(valid) as hits
		FROM `measurement`, (SELECT day FROM `history` ORDER BY day desc LIMIT 1) AS theDay
		WHERE `added` < date_format(DATE_SUB(now(), INTERVAL 0 DAY), '%Y-%m-%d') AND added >= DATE_ADD(theDay.day, INTERVAL 1 DAY)
		GROUP BY DF, sensorID, valid;
		DELETE FROM `measurement`
		WHERE `added` <= date_format(DATE_SUB(now(), INTERVAL 7 DAY), '%Y-%m-%d');";

$db -> select_query($sql);

/* För timstatistik
INSERT INTO `hour_history`(`sensorID`, `hour`, `maximal`, `minimum`, `average`, `valid`, `hits`)
SELECT sensorID, DATE_FORMAT(added, '%Y-%m-%d %H') AS DF, format(max(measurement),3) as maximum, format(min(measurement),3) as minimum, format(avg(measurement),3) as average, valid, count(valid) as hits
		FROM `measurement`, (SELECT hour FROM `hour_history` ORDER BY hour desc LIMIT 1) AS theHour
		WHERE `added` < date_format(DATE_SUB(now(), INTERVAL 0 HOUR), '%Y-%m-%d %H') AND added >= DATE_ADD(theHour.hour, INTERVAL 1 HOUR)
		GROUP BY DF, sensorID, valid