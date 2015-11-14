<?php
/*
 * Project: Nathan MVC
 * File: /controllers/home.php
 * Purpose: controller for the home of the app.
 * Author: Nathan Davison
 */

class ChartController extends BaseController
{
    //add to the parent constructor
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);

        //create the model object
        require("models/chart.php");
        $this->model = new ChartModel();
    }

    //default method
    protected function index()
    {
        $this->view->output($this->model->index());
    }

	protected function history()
    {
        $this->view->output($this->model->history());
    }

    protected function forecast()
    {
        $this->view->output($this->model->forecast());
    }
}

?>
