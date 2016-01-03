<?php
include "../classes/database.php";
include "../config/config.php";

$db = new Database();

$sql = "INSERT INTO `hour_history`(`sensorID`, `hour`, `maximal`, `minimum`, `average`, `valid`, `hits`)
		SELECT sensorID, DATE_FORMAT(added, '%Y-%m-%d %H') AS DF, format(max(measurement),3) as maximum, format(min(measurement),3) as minimum, format(avg(measurement),3) as average, valid, count(valid) as hits
		FROM `measurement`, (SELECT ifnull(hour, '1970-01-01 00:00:00') AS hour, count(hour) FROM `hour_history` ORDER BY hour desc LIMIT 1) AS theHour
		WHERE `added` < date_format(DATE_SUB(now(), INTERVAL 0 HOUR), '%Y-%m-%d %H') AND added >= DATE_ADD(theHour.hour, INTERVAL 1 HOUR)
		GROUP BY DF, sensorID, valid";

$db -> select_query($sql);
