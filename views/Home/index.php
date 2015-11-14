<table class="tempNow">
	<tr><td colspan="4"><h1>Temperatur nu</h1></td></tr>
	<tr>
		<th>Namn</th><th>Temp</th><th>Max / nu / min</th><th>Tid</th>
	</tr>
	<?php
	$span = $viewModel -> get(span);
	$i = 1;
	foreach ($viewModel -> get(tempNowArray) as $key => $value) {
		echo '<tr><td>'.$value["name"].'</td><td>'.$value["value"].'</td><td>('.$span[$i]["max"].', '.$span[$i]["measurement"].', '.$span[$i]["min"].')</td><td>'.$value["added"].'</td></tr>';
		$i++;
	}
	?>
</table>
<table class="tempNow">
	<tr><td colspan="5"><h1>Medeltemperatur</h1></td></tr>
	<tr><th></th><th>Namn</th><th>Max</th><th>Min</th><th>Medel</th></tr>
	<?php
	foreach ($viewModel -> get(tempDayArray) as $key => $value) {
		if($key == 1){
			echo '<tr><th rowspan="' . $viewModel -> get(numSensors) . '">Senste dygnet</th><td>'.$value["name"].'</td><td>'.$value["max"].'</td><td>'.$value["min"].'</td><td>'.$value["avg"].'</td></tr>';
		} else {
			echo '<tr><td>'.$value["name"].'</td><td>'.$value["max"].'</td><td>'.$value["min"].'</td><td>'.$value["avg"].'</td></tr>';
		}
	}
	foreach ($viewModel -> get(tempWeekArray) as $key => $value) {
		if($key == 1){
			echo '<tr><th rowspan="' . $viewModel -> get(numSensors) . '">Senste veckan</th><td>'.$value["name"].'</td><td>'.$value["max"].'</td><td>'.$value["min"].'</td><td>'.$value["avg"].'</td></tr>';
		} else {
			echo '<tr><td>'.$value["name"].'</td><td>'.$value["max"].'</td><td>'.$value["min"].'</td><td>'.$value["avg"].'</td></tr>';
		}
	}
	?>
</table>
