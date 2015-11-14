<?php
include "../config/config.php";
include "../classes/database.php";

$db = new Database();

$sql = "SELECT * FROM (SELECT * FROM `measurement`
		WHERE valid = 1
		ORDER BY `added` DESC) AS t
		GROUP BY `sensorID`";

$result = $db -> select_query($sql);

if (sizeof($result) > 0) {
	foreach ($result as $key => $value) {
		$sensorIDs[$key] = $value["sensorID"];
		$temp[$value["sensorID"]]["added"] = $value["added"];
		$temp[$value["sensorID"]]["measurement"] = $value["measurement"];
	}

	$diffs = array_diff($sensID, $sensorIDs);

	if (sizeof($diffs) > 0) {
		foreach ($diffs as $value) {
			$sql = "SELECT * FROM (SELECT * FROM `measurement`
					WHERE `valid` is NULL AND sensorID = '" . $value . "'
					ORDER BY `added` ASC) as t
					GROUP BY `sensorID`";

			$result = $db -> select_query($sql);

			foreach ($result as $value) {
				$sql1 .= "UPDATE `measurement` SET `valid`=1 WHERE `sensorID` = '" . $value['sensorID'] . "' AND `added` = '" . $value['added'] . "';";
			}
			$db -> select_query($sql1);
		}
		break;
	}

	$sql = "SELECT * FROM `measurement`
			WHERE `valid` is NULL
			ORDER BY `added` ASC
			LIMIT 20";

	$result2 = $db -> select_query($sql);

	foreach ($result2 as $key => $value) {
		$thedatetime = new DateTime($temp[$value["sensorID"]]["added"]);
		$datetime2 = new DateTime($value["added"]);

		$thedatetime = $thedatetime -> getTimestamp();
		$datetime2 = $datetime2 -> getTimestamp();

		if (abs($temp[$value["sensorID"]]["measurement"] - $value["measurement"]) <= 0.5 + (abs($thedatetime - ($datetime2 - 120)) / 60) * 0.031) {
			$temp[$value["sensorID"]]["measurement"] = $value["measurement"];
			$temp[$value["sensorID"]]["added"] = $value["added"];
			$param[] = array(':sensorID' => $value["sensorID"], ':added' => $value["added"]);
		} else {
			$param2[] = array(':sensorID' => $value["sensorID"], ':added' => $value["added"]);
		}
	}

	$sql = "UPDATE measurement SET valid = 1 WHERE sensorID = :sensorID AND added = :added AND valid IS NULL LIMIT 1;";
	$db -> multi_query($sql, $param);
	if (isset($param2) > 0) {
		$sql = "UPDATE measurement SET valid = 0 WHERE sensorID = :sensorID AND added = :added AND valid IS NULL LIMIT 1;";
		$db -> multi_query($sql, $param2);
	}
} else {
	$sql = "SELECT * FROM (SELECT * FROM `measurement`
			WHERE `valid` is NULL
			ORDER BY `added` ASC) as t
			GROUP BY `sensorID`";

	$result = $db -> select_query($sql);

	$sql1 = "";

	foreach ($result as $value) {
		$sql1 .= "UPDATE `measurement` SET `valid`=1 WHERE `sensorID` = '" . $value['sensorID'] . "' AND `added` = '" . $value['added'] . "';";
	}
	$db -> select_query($sql1);
}
