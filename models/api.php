<?php
/*
 * Project: Nathan MVC
 * File: /models/home.php
 * Purpose: model for the home controller.
 * Author: Nathan Davison
 */

class ApiModel extends BaseModel {
	//data passed to the home index view
	public function index() {
		$this -> viewModel -> set("pageTitle", "API");
		return $this -> viewModel;
	}

	public function get() {
		$urlValues = $this -> urlValues;
		$ip = $_SERVER['REMOTE_ADDR'];

		//SELECT INET_NTOA for decrypt IP adresses
		$sql1 = "INSERT INTO `api`(`accessdate`, `ip`, `apipoint`, `id`) VALUES (now(),INET_ATON('".$ip."'),\"".$urlValues[action]."\",\"".$urlValues[id]."\")";
		$this -> db -> select_query($sql1);

		$sql = "SELECT `added`, `measurement` FROM `measurement` WHERE `sensorID` = :sensID ORDER BY added DESC LIMIT 1";
		$result = $this -> db -> select_query($sql,array(':sensID' => base64_decode($urlValues["id"])));

		$this -> viewModel -> set("added", $result[0]["added"]);
		$this -> viewModel -> set("measurement", $result[0]["measurement"]);
		return $this -> viewModel;
	}

	public function put() {
		$urlValues = $this -> urlValues;
		$ip = $_SERVER['REMOTE_ADDR'];

		//SELECT INET_NTOA for decrypt IP adresses
		$sql1 = "INSERT INTO `api`(`accessdate`, `ip`, `apipoint`, `id`) VALUES (now(),INET_ATON('".$ip."'),\"".$urlValues[action]."\",\"".$urlValues[id]."\")";
		$this -> db -> select_query($sql1);

		$param = array();
		if ($_POST["apikey"] == apikey) {
			$sql = "INSERT INTO `measurement`(`sensorID`, `added`, `measurement`) VALUES (:sensorID,:added,:measurement)";

			for ($i=0; $i < sizeof($_POST) - 1; $i++) {
				$param[] = array(':added' => $_POST[$i]["added"], ':measurement' => $_POST[$i]["measurement"], ':sensorID' => $_POST[$i]["sensorID"]);
			}
			$this -> db -> multi_query($sql,$param);
		}

		return $this -> viewModel;
	}
}
?>
