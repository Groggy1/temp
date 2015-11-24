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

		$sql = "SELECT  `sensorID` , GROUP_CONCAT(concat(`added`,',',`measurement`) ORDER BY added ASC SEPARATOR  '|' ) AS data
				FROM  (SELECT measurement, sensorID, UNIX_TIMESTAMP(added)*1000 as added FROM `measurement`
				WHERE valid = 1 AND  `added` >= DATE_SUB(now(), INTERVAL 1 DAY)) AS temp
				GROUP BY sensorID";

		$tempDay = $this -> db -> select_query($sql);

		foreach ($tempDay as $key => $value) {
			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["name"] = $this -> SENSORS[$value["sensorID"]]["name"];
			$tempDayArray[$this -> SENSORS[$value["sensorID"]]["order"]]["data"] = explode('|', $value["data"]);
		}

		ksort($tempDayArray);

		$sql = "SELECT  `sensorID` , GROUP_CONCAT(concat(`added`,',',`measurement`) ORDER BY added ASC SEPARATOR  '|' ) AS data
				FROM  (SELECT measurement, sensorID, UNIX_TIMESTAMP(added)*1000 as added FROM `measurement`
				WHERE valid = 1 AND `added` >= DATE_SUB(now(), INTERVAL 1 WEEK)) AS temp
				GROUP BY sensorID";

		$tempWeek = $this -> db -> select_query($sql);

		foreach ($tempWeek as $key => $value) {
			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["name"] = $this -> SENSORS[$value["sensorID"]]["name"];
			$tempWeekArray[$this -> SENSORS[$value["sensorID"]]["order"]]["data"] = explode('|', $value["data"]);
		}

		ksort($tempWeekArray);

		$this -> viewModel -> set("weekData", $tempWeekArray);
		$this -> viewModel -> set("dayData", $tempDayArray);
		$this -> viewModel -> set("pageTitle", "Grafer");
		return $this -> viewModel;
	}

	public function history() {
		$sql = "SELECT  `sensorID`,day,`maximal`,`minimum`,`average` FROM `history`
				WHERE `valid`= 1 AND `day` >= DATE_SUB(now(), INTERVAL 1 MONTH)
				ORDER BY `day` DESC";

		$result = $this -> db -> select_query($sql);

		foreach ($result as $key => $value) {
			$date = new DateTime($value["day"], new DateTimeZone("UTC"));
			$date = $date -> getTimestamp();
			$history[$this -> SENSORS[$value["sensorID"]]["order"]]["range"] .= "[" . $date*1000 . "," . $value["minimum"] . "," . $value["maximal"] . "]";
			$history[$this -> SENSORS[$value["sensorID"]]["order"]]["average"] .= "[" . $date*1000 . "," . $value["average"] . "]";
			if ($key + 1 != sizeof($result)) {
				$history[$this -> SENSORS[$value["sensorID"]]["order"]]["range"] .= ', ';
				$history[$this -> SENSORS[$value["sensorID"]]["order"]]["average"] .= ', ';
			}
		}

		$this -> viewModel -> set("history", $history);
		$this -> viewModel -> set("pageTitle", "Historik");
		return $this -> viewModel;
	}

	public function forecast()
	{
		$this -> db -> select_query("SET SESSION group_concat_max_len = 1000000");
		$this->db->select_query("SET time_zone = +02:00");

		$historyResult = $this->db->select_query("SELECT `sensorID`, `hour`, `maximal`, `minimum` FROM `hour_history` WHERE valid = 1 AND hour >= DATE_SUB(NOW(), INTERVAL 3 DAY) AND sensorID = :sensID",array(':sensID' => FORECASTSENSOR));

		foreach ($historyResult as $key => $value) {
			$date = new DateTime($value["hour"], new DateTimeZone("UTC"));
			$date = $date -> getTimestamp();
			$history["name"] = $this -> SENSORS[$value["sensorID"]]["name"];
			$history["range"] .= "[" . $date*1000 . "," . $value["minimum"] . "," . $value["maximal"] . "]";
			if ($key + 1 != sizeof($historyResult)) {
				$history["range"] .= ', ';
			}
		}

		$forecastResultat = $this->db->select_query("SELECT GROUP_CONCAT(concat(UNIX_TIMESTAMP(`validTime`)*1000,',',`temperature`) ORDER BY `validTime` ASC SEPARATOR '|') AS temperature, GROUP_CONCAT(concat(UNIX_TIMESTAMP(`validTime`)*1000,',',`precipitation`) ORDER BY `validTime` ASC SEPARATOR '|') AS precipitation  FROM `forecast`
																									WHERE `validTime` >= DATE_SUB(NOW(), INTERVAL 3 DAY)");
		foreach ($forecastResultat as $key => $value) {
			$forecastTemp["name"] = "Temperatur";
			$forecastTemp["data"] = explode('|', $value["temperature"]);
			$forecastPrec["name"] = "Nederbörd";
			$forecastPrec["data"] = explode('|', $value["precipitation"]);
		}

		$tempseries = "";
		$precseries = "";
		foreach ($forecastTemp["data"] as $key => $value) {
			$tempseries .= "[".$value."]";
			$precseries .= "[".$forecastPrec["data"][$key]."]";
			if ($key + 1 != sizeof($forecastTemp["data"])) {
				$tempseries .= ', ';
				$precseries .= ', ';
			}
		}
		$forecastTemp["data"] = $tempseries;
		$forecastPrec["data"] = $precseries;

		$this -> viewModel -> set("forecastTemp", $forecastTemp);
		$this -> viewModel -> set("forecastPrec", $forecastPrec);
		$this -> viewModel -> set("history", $history);
		$this -> viewModel -> set("pageTitle", "Prognos");
		return $this -> viewModel;
	}

}
?>
