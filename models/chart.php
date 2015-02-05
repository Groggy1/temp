<?php
/*
 * Project: Nathan MVC
 * File: /models/home.php
 * Purpose: model for the home controller.
 * Author: Nathan Davison
 */

class ChartModel extends BaseModel {
	//data passed to the home index view
	public function index() {
		$sql = "SET SESSION group_concat_max_len = 1000000";
		$this -> db -> select_query($sql);
		
		$sql = "SELECT  `sensorID` , GROUP_CONCAT(`added` ORDER BY added ASC SEPARATOR  '|' ) AS added, GROUP_CONCAT(`measurement` ORDER BY added ASC SEPARATOR  '|' ) AS measurement
				FROM  (SELECT measurement, sensorID, UNIX_TIMESTAMP(added)*1000 as added FROM `measurement`
WHERE `added` >= DATE_SUB(now(), INTERVAL 1 DAY)) AS temp
				GROUP BY sensorID";

		$tempDay = $this -> db -> select_query($sql);

		foreach ($tempDay as $key => $value) {
			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["name"] = $this -> SENSORS[$value["sensorID"]]["name"];
			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["values"] = explode('|', $value["measurement"]);
			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["added"] = explode('|', $value["added"]);
		}
		
		$sql = "SELECT  `sensorID` , GROUP_CONCAT(`added` ORDER BY added ASC SEPARATOR  '|' ) AS added, GROUP_CONCAT(`measurement` ORDER BY added ASC SEPARATOR  '|' ) AS measurement
				FROM  (SELECT measurement, sensorID, UNIX_TIMESTAMP(added)*1000 as added FROM `measurement`
WHERE `added` >= DATE_SUB(now(), INTERVAL 1 WEEK)) AS temp
				GROUP BY sensorID";

		$tempWeek = $this -> db -> select_query($sql);

		foreach ($tempWeek as $key => $value) {
			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["name"] = $this -> SENSORS[$value["sensorID"]]["name"];
			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["values"] = explode('|', $value["measurement"]);
			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["added"] = explode('|', $value["added"]);
		}

		$this -> viewModel -> set("weekData", $tempWeekArray);
		$this -> viewModel -> set("dayData", $tempDayArray);
		$this -> viewModel -> set("pageTitle", "Grafer");
		return $this -> viewModel;
	}

}
?>
