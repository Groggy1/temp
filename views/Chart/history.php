<?php $history = $viewModel -> get("history"); ?>
<script type="text/javascript">
	$(function() {

		var ranges = [
            <?php echo $history[1]["range"];?>
        ],
        averages = [
            <?php echo $history[1]["average"];?>
         ],
            ranges2 = [
            <?php echo $history[2]["range"];?>
        ],
        averages2 = [
            <?php echo $history[2]["average"];?>
        ];

		$('#history').highcharts({

			title : {
				text : 'Historik'
			},

			xAxis : {
				type : 'datetime'
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

			legend : {
			},

			series : [{
				name : 'Medel vardagsrum',
				data : averages,
				zIndex : 1,
				marker : {
					fillColor : 'white',
					lineWidth : 2,
					lineColor : Highcharts.getOptions().colors[0]
				}
			}, {
				name : 'Max och min vardagsrum',
				data : ranges,
				type : 'arearange',
				lineWidth : 0,
				linkedTo : ':previous',
				color : Highcharts.getOptions().colors[0],
				fillOpacity : 0.3,
				zIndex : 0
			}, {
				name : 'Medel ute',
				data : averages2,
				zIndex : 1,
				marker : {
					fillColor : 'white',
					lineWidth : 2,
					lineColor : Highcharts.getOptions().colors[1]
				}
			}, {
				name : 'Max och min ute',
				data : ranges2,
				type : 'arearange',
				lineWidth : 0,
				linkedTo : ':previous',
				color : Highcharts.getOptions().colors[1],
				fillOpacity : 0.3,
				zIndex : 0
			}]
		});
	});
</script>

<script src="<?php echo URL; ?>public/js/highcharts.js"></script>
<script src="<?php echo URL; ?>public/js/highcharts-more.js"></script>
<script src="<?php echo URL; ?>public/js/dark-unica.js"></script>
<div id="history" style="max-width: 600px; height: 400px; margin: 0 auto"></div>
