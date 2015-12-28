<?php
include "../config/config.php";
include "../classes/database.php";

$db = new Database();

foreach ($sensID as $value) {
  $site = file_get_contents(extsite . "api/get/" . base64_encode($value));
  $site = explode("\n",$site);
  $lastadd[$value] = $site[0];
  $sql[] = 'SELECT added, measurement, sensorID  FROM `measurement` WHERE `added` > "'.$site[0].'" AND sensorID = "'.$value.'" LIMIT 10';
}

foreach ($sql as $value) {
  $result[] = $db -> select_query($value);
}
$i = 0;
$result2["apikey"] = apikey;
foreach ($result as $value) {
  foreach ($value as $value2) {
    $result2[$i]["added"] = $value2["added"];
    $result2[$i]["measurement"] = $value2["measurement"];
    $result2[$i]["sensorID"] = $value2["sensorID"];
    $i++;
  }
}

$postdata = http_build_query($result2);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$result = file_get_contents(extsite.'api/put', false, $context);
