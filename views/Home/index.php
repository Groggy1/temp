<table class="tempNow">
	<tr><td colspan="3"><h1>Temperatur nu</h1></td></tr>
	<tr>
		<th>Namn</th><th>Temperatur</th><th>Uppmätt</th>
	</tr>
	<?php
	foreach ($viewModel -> get(tempNowArray) as $key => $value) {
		echo '<tr><td>'.$value["name"].'</td><td>'.$value["value"].'</td><td>'.$value["added"].'</td></tr>';
	}
	?>
</table>
<table class="tempNow">
	<tr><td colspan="5"><h1>Medeltemperatur</h1></td></tr>
	<tr><th></th><th>Namn</th><th>Max</th><th>Min</th><th>Medel</th></tr>
	<?php
	foreach ($viewModel -> get(tempDayArray) as $key => $value) {
		if($key%2){
			echo '<tr><th rowspan="' . $viewModel -> get(numSensors) . '">Senste dygnet</th><td>'.$value["name"].'</td><td>'.$value["max"].'</td><td>'.$value["min"].'</td><td>'.$value["avg"].'</td></tr>';
		} else {
			echo '<tr><td>'.$value["name"].'</td><td>'.$value["max"].'</td><td>'.$value["min"].'</td><td>'.$value["avg"].'</td></tr>';
		}
	}
	foreach ($viewModel -> get(tempWeekArray) as $key => $value) {
		if($key%2){
			echo '<tr><th rowspan="' . $viewModel -> get(numSensors) . '">Senste veckan</th><td>'.$value["name"].'</td><td>'.$value["max"].'</td><td>'.$value["min"].'</td><td>'.$value["avg"].'</td></tr>';
		} else {
			echo '<tr><td>'.$value["name"].'</td><td>'.$value["max"].'</td><td>'.$value["min"].'</td><td>'.$value["avg"].'</td></tr>';
		}
	}
	?>
</table>