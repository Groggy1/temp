<?php
/*
 * Project: Nathan MVC
 * File: /controllers/home.php
 * Purpose: controller for the home of the app.
 * Author: Nathan Davison
 */

class ApiController extends BaseController
{
    //add to the parent constructor
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);

        //create the model object
        require("models/api.php");
        $this -> model = new ApiModel();
    		$this -> model -> set('urlValues', $urlValues);
    }

    //default method
    protected function index()
    {
        $this->view->output($this->model->index());
    }
    protected function get()
    {
        $this->view->output($this->model->get(), false);
    }
    protected function put()
    {
        $this->view->output($this->model->put(), false);
    }
}

?>
