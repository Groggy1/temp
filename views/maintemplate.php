<!DOCTYPE html>
<html>
<head>
<title><?php echo TITLE, $viewModel -> get('pageTitle'); ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet" />
<script src="<?php echo URL; ?>public/js/jquery-2.1.3.min.js"></script>
<!--<div>Icon made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>-->
<link rel="shortcut icon" href="<?php echo URL; ?>public/img/favicon.ico" />
</head>
<body>
	<div class="container-fluid">
<div class="tempNow">
	<a href="<?php echo URL;?>">Temperatur</a> | <a href="<?php echo URL;?>chart/forecast">Prognos</a> | <a href="<?php echo URL;?>chart">Grafer</a> | <a href="<?php echo URL;?>chart/history">Historik</a>
</div>
<?php require ($this -> viewFile);?>
</div>
</body>
</html>
