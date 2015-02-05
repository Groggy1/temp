<?php
/*
 * Project: Nathan MVC
 * File: /models/home.php
 * Purpose: model for the home controller.
 * Author: Nathan Davison
 */

class HomeModel extends BaseModel {
	//data passed to the home index view
	public function index() {
		$sql = "SELECT `sensorID`, added, FORMAT(`measurement`,1) as measurement FROM (SELECT `sensorID`, added, `measurement` FROM `measurement` ORDER BY added DESC ) temp GROUP BY temp.sensorID";
		$tempNow = $this -> db -> select_query($sql);

		$sql = "SELECT FORMAT(avg(measurement),1) as average, FORMAT(max(measurement),1) as maximum, FORMAT(min(measurement),1) as minimum, sensorID FROM `measurement` WHERE `added` >= DATE_SUB(now(), INTERVAL 1 DAY) GROUP BY sensorID";
		$tempDay = $this -> db -> select_query($sql);

		$sql = "SELECT FORMAT(avg(measurement),1) as average, FORMAT(max(measurement),1) as maximum, FORMAT(min(measurement),1) as minimum, sensorID FROM `measurement` WHERE `added` >= DATE_SUB(now(), INTERVAL 1 WEEK) GROUP BY sensorID";
		$tempWeek = $this -> db -> select_query($sql);

		foreach ($tempNow as $key => $value) {
			$tempNowArray[$this -> SENSORS[$value["sensorID"]]["order"]]["name"] = $this -> SENSORS[$value["sensorID"]]["name"];
			$tempNowArray[$this -> SENSORS[$value["sensorID"]]["order"]]["value"] = $value["measurement"];
			$tempNowArray[$this -> SENSORS[$value["sensorID"]]["order"]]["added"] = $value["added"];

			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["name"] = $this -> SENSORS[$value["sensorID"]]["name"];
			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["max"] = $tempDay[$key]["maximum"];
			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["min"] = $tempDay[$key]["minimum"];
			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["avg"] = $tempDay[$key]["average"];

			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["name"] = $this -> SENSORS[$value["sensorID"]]["name"];
			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["max"] = $tempWeek[$key]["maximum"];
			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["min"] = $tempWeek[$key]["minimum"];
			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["avg"] = $tempWeek[$key]["average"];
		}

		$this -> viewModel -> set("numSensors",count($this -> SENSORS));
		$this -> viewModel -> set("tempNowArray", $tempNowArray);
		$this -> viewModel -> set("tempDayArray", $tempDayArray);
		$this -> viewModel -> set("tempWeekArray", $tempWeekArray);
		$this -> viewModel -> set("pageTitle", "Temperatur");
		return $this -> viewModel;
	}

}
?>
