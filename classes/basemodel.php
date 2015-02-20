<?php
/*
 * Project: Nathan MVC
 * File: /classes/basemodel.php
 * Purpose: abstract class from which models extend.
 * Author: Nathan Davison
 */

class BaseModel {

	protected $viewModel;
	protected $db;
	protected $SENSORS;

	//create the base and utility objects available to all models on model creation
	public function __construct() {
		$this -> db = new Database();
		$this -> viewModel = new ViewModel();
		$this -> commonViewData();
		$this -> SENSORS["28-0000065cef7b"]["name"] = "Vardagsrum";
		$this -> SENSORS["28-0000065cef7b"]["order"] = 1;
		$this -> SENSORS["28-0014546a9dff"]["name"] = "Vardagsrum NY";
		$this -> SENSORS["28-0014546a9dff"]["order"] = 2;
	}

	//establish viewModel data that is required for all views in this method (i.e. the main template)
	protected function commonViewData() {

		//e.g. $this->viewModel->set("mainMenu",array("Home" => "/home", "Help" => "/help"));
	}

}
?>
