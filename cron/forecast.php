<?php
include "../classes/database.php";
include "../config/config.php";

$db = new Database();
$referenceTimeFromDB = $db -> select_query("SELECT `referenceTime` FROM `forecast` ORDER BY `referenceTime` DESC LIMIT 1");
$referenceTimeFromDB = $referenceTimeFromDB[0][0];

//http://www.smhi.se/klimatdata/oppna-data/meteorologiska-data -- Info om apiet
$forecast = file_get_contents("http://opendata-download-metfcst.smhi.se/api/category/pmp1.5g/version/1/geopoint/lat/".LAT."/lon/".LON."/data.json");
$forecast = json_decode($forecast, true);

$referenceTime = date('Y-m-d H:i:s',strtotime($forecast["referenceTime"]));

//If not updated forecast, no need to update
if ($referenceTime == $referenceTimeFromDB) {
  break;
} elseif ($referenceTimeFromDB != null) {
  $result = $db -> select_query("DELETE FROM `forecast` WHERE `validTime` > '".$referenceTime."'");
}

$param =[];
$endtime = strtotime($referenceTime) + 172800;

foreach ($forecast["timeseries"] as $key => $value) {
  $validTime = strtotime($value["validTime"]);
  $time = date('Y-m-d H:i:s',$validTime);

  if ($validTime >= $endtime) {
    //Three days of forecast is enough
    break;
  }

  array_push($param, array(':referenceTime' => $referenceTime, ':validTime' => date('Y-m-d H:i:s',strtotime($value["validTime"])), ':temperature' => $value["t"], ':precipitation' => $value['pit']));
}

$result = $db -> multi_query("INSERT INTO `forecast`(`referenceTime`, `validTime`, `temperature`, `precipitation`, `added`) VALUES (:referenceTime,:validTime,:temperature,:precipitation, now())", $param);
