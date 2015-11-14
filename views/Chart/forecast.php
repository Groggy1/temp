<?php
$history = $viewModel -> get("history");
$forecastTemp = $viewModel -> get("forecastTemp");
$forecastPrec = $viewModel -> get("forecastPrec");
 ?>
<script type="text/javascript">
	$(function() {
		var ranges = [
            <?php echo $history["range"];?>
        ],
				forcasttemp = [
					<?php echo $forecastTemp["data"];?>
				],
				precipitation = [
					<?php echo $forecastPrec["data"];?>
				];

		$('#forecast').highcharts({

			title : {
				text : 'Prognos'
			},

			xAxis : {
				type : 'datetime',
				plotLines: [{
                color: '#850000',
                width: 2,
                value: <?php echo time() * 1000;?>
            }]
			},

			yAxis : {
				title : {
					text : null
				}
			},

			tooltip : {
				crosshairs : true,
				shared : true,
				valueSuffix : '°C'
			},
			series : [{
				name : 'Prognos <?php echo $history["name"];?>',
				data : forcasttemp,
				zIndex : 1,
				marker : {
					fillColor : 'white',
					lineWidth : 2,
					lineColor : Highcharts.getOptions().colors[0]
				}
			},{
				name : 'Max och min <?php echo $history["name"];?>',
				data : ranges,
				type : 'arearange',
				lineWidth : 0,
				linkedTo : ':previous',
				color : Highcharts.getOptions().colors[0],
				fillOpacity : 0.3,
				zIndex : 0
			}, {
				name : 'Regn',
				data : precipitation,
				zIndex : 1,
				marker : {
					fillColor : 'white',
					lineWidth : 2,
					lineColor : Highcharts.getOptions().colors[1]
				},
				tooltip : {
					crosshairs : true,
					shared : true,
					valueSuffix : 'mm/h'
				}
			}]
		});
	});
</script>

<script src="<?php echo URL; ?>public/js/highcharts.js"></script>
<script src="<?php echo URL; ?>public/js/highcharts-more.js"></script>
<script src="<?php echo URL; ?>public/js/dark-unica.js"></script>
<div id="forecast" style="max-width: 600px; height: 400px; margin: 0 auto"></div>
