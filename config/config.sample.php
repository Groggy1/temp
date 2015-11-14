<?php
define('URL', 'http://192.168.0.50/temp/');
define('DB_FLAG', '');
define('SITE', 'startpage');
define('TITLE', '');

//DB-configuration
define('SQL_ENGINE', 'mysql');
define('SQL_HOST', 'localhost');
define('SQL_DB', 'dbDATABASE');
define('SQL_USER', 'dbUSER');
define('SQL_PASS', 'dbPASS');
define('SQL_PORT', '3306');

//Sensor ID's
$sensID[0] = "SENSID1";
$sensID[1] = "SENSID2";

//Forecestconfig
DEFINE('FORECASTSENSOR',$sensID[1]); //sensor that are matched with forecast
DEFINE('LAT',LAT);
DEFINE('LON',LON);
