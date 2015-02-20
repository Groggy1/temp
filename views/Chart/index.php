<script type="text/javascript">
	$(function() {
		Highcharts.setOptions({
			chart : {
				type : 'spline'
			},
			xAxis : {
				type : 'datetime',
				dateTimeLabelFormats : {
					month : '%e. %b',
					year : '%b'
				},
				title : {
					text : 'Klockan'
				}
			},
			yAxis : {
				title : {
					text : 'Grader (°C)'
				},
				minRange: 2,
				allowDecimals: false
			},
			plotOptions: {
            spline: {
	                marker: {
	                    enabled: false
	                }
	            }
	        },
			tooltip : {
				headerFormat : '<b>{series.name}</b><br>',
				pointFormat : '{point.x:%H:%M %e/%m}: {point.y:.1f} °C'
			}
		});
		
		$('#daily').highcharts({
			title : {
				text : 'Temperatur senaste dygnet'
			},
			series : [
			<?php
			foreach ($viewModel -> get(dayData) as $key => $value) {
				echo "{ name : '".$value['name']."',";
				echo "data :[";
				foreach ($value['values'] as $key2 => $value2) {
					echo "[".$value['added'][$key2].",".$value2."]";
					if($key2 + 1 != sizeof($value['values'])){
						echo ', ';
					}
				}
				echo ']}';
				if(sizeof($viewModel -> get(dayData)) > 1 && $key + 1 == sizeof($viewModel -> get(dayData))){
					echo ',';
				}
			}
			?>
			]
		});
		$('#weekly').highcharts({
			title : {
				text : 'Temperatur senaste veckan'
			},
			series : [
			<?php
			foreach ($viewModel -> get(weekData) as $key => $value) {
				echo "{ name : '".$value['name']."',";
				echo "data :[";
				foreach ($value['values'] as $key2 => $value2) {
					echo "[".$value['added'][$key2].",".$value2."]";
					if($key2 + 1 != sizeof($value['values'])){
						echo ', ';
					}
				}
				echo ']}';
				if(sizeof($viewModel -> get(dayData)) > 1 && $key + 1 == sizeof($viewModel -> get(dayData))){
					echo ',';
				}
			}
			?>
			]
		});
	}); 
</script>

<script src="<?php echo URL; ?>public/js/highcharts.js"></script>
<div id="daily" style="max-width: 600px; height: 400px; margin: 0 auto"></div>
<div id="weekly" style="max-width: 600px; height: 400px; margin: 0 auto"></div>