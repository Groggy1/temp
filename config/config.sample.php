<?php
define('URL', 'http://192.168.0.50/temp/');
define('DB_FLAG', '');
define('SITE', 'startpage');
define('TITLE', '');

//DB-configuration
define('SQL_ENGINE', 'mysql');
define('SQL_HOST', 'localhost');
define('SQL_DB', 'termometer');
define('SQL_USER', 'root');
define('SQL_PASS', 'abc123');
define('SQL_PORT', '3306');

//Sensor ID's
$sensID[0] = "28-01156193b4ff";
$sensID[1] = "28-0014546a9dff";

//Forecestconfig
DEFINE('FORECASTSENSOR',$sensID[1]); //sensor that are matched with forecast
DEFINE('LAT',LAT);
DEFINE('LON',LON);
