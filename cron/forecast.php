<?php
include "../classes/database.php";
include "../config/config.php";

$db = new Database();
$referenceTimeFromDB = $db -> select_query("SELECT `referenceTime` FROM `forecast` ORDER BY `referenceTime` DESC LIMIT 1");
$referenceTimeFromDB = $referenceTimeFromDB[0][0];

//http://www.smhi.se/klimatdata/oppna-data/meteorologiska-data -- Info om api:et
//http://www.smhi.se/klimatdata/ladda-ner-data/api-for-pmp-dokumentation-1.76980 -- mer info om api:et
$forecast = file_get_contents("http://opendata-download-metfcst.smhi.se/api/category/pmp2g/version/1/geopoint/lat/".LAT."/lon/".LON."/data.json");
$forecast = json_decode($forecast, true);

if (sizeof($forecast) == 0) {
  break;
}

$referenceTime = date('Y-m-d H:i:s',strtotime($forecast["referenceTime"]));
$approvedTime = date('Y-m-d H:i:s',strtotime($forecast["approvedTime"]));

//If not updated forecast, no need to update
if ($referenceTime == $referenceTimeFromDB) {
  break;
} elseif ($referenceTimeFromDB != null) {
  $result = $db -> select_query("DELETE FROM `forecast` WHERE `validTime` > '".$referenceTime."'");
}

$param =[];
$endtime = strtotime($referenceTime) + 432000;

foreach ($forecast["timeseries"] as $key => $value) {
  $validTime = strtotime($value["validTime"]);
  $time = date('Y-m-d H:i:s',$validTime);

  if ($validTime >= $endtime) {
    //Three days of forecast is enough
    break;
  }

  array_push($param, array(':approvedTime' => $approvedTime, ':referenceTime' => $referenceTime, ':validTime' => date('Y-m-d H:i:s',strtotime($value["validTime"])), ':temperature' => $value["t"], ':precipitation' => $value['pmean']));
}

$result = $db -> multi_query("INSERT INTO `forecast`(`approvedTime`,`referenceTime`, `validTime`, `temperature`, `precipitation`, `added`) VALUES (:approvedTime, :referenceTime,:validTime,:temperature,:precipitation, now())", $param);
