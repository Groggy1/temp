<?php
include "../config/config.php";
include "../classes/database.php";

$db = new Database();

$sql = "SELECT sensorID, added, measurement, valid FROM `measurement` ORDER BY added DESC LIMIT 30";

$result = array_reverse($db -> select_query($sql));

echo '<pre>';

foreach ($result as $key => $value) {
	if ($value["valid"] == 1) {
		$measurement[$value["sensorID"]] = array();
	} else {
		$measurement[$value["sensorID"]][]["added"] = $value["added"];
		$measurement[$value["sensorID"]][sizeof($measurement[$value["sensorID"]]) - 1]["measurement"] = $value["measurement"];
	}
}
$param = array();
foreach ($measurement as $key => $value) {
	$count = 0;
	$time[$key] = 0;
	foreach ($value as $key2 => $value2) {
		if ($key2 + 1 == sizeof($value)) {
			break;
		}
		$thedatetime = new DateTime($value2["added"]);
		$datetime2 = new DateTime($value[$key2 + 1]["added"]);

		$thedatetime = $thedatetime -> getTimestamp();
		$datetime2 = $datetime2 -> getTimestamp();
		
		if($thedatetime >= $time[$key]){
			$time[$key] = $thedatetime;
		}

		if (abs($value[$key2 + 1]["measurement"] - $value2["measurement"]) < 0.5 + (abs($thedatetime - ($datetime2 - 120)) / 60) * 0.031) {
			$count++;
		} else {
			$count = 0;
		}
		if ($count == 5){
			$theKey = $key2 + 1;
			break;
		}
	}
	if ($count == 5) {
		for ($i = $theKey - $count; $i <= $count; $i++) {
			$param[] = array(":added" => $value[$i]["added"],  ":sensorid" => $key);
		}
	}
}
$sql = "UPDATE `measurement` SET `valid`= 1 WHERE `sensorID`=:sensorid AND `added`=:added";
$db -> multi_query($sql,$param);

foreach ($time as $key => $value) {
	if($value == 0){
		break;
	}
	$param2[] = array(":sensorid" => $key, ":timestamp" => date('Y-m-d H:i:s',$value));
}
var_dump($time);
$sql = "UPDATE `measurement` SET valid = NULL WHERE `added`> :timestamp AND `sensorID` = :sensorid";
//$db -> multi_query($sql,$param2);
