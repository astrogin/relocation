<?php 
function sortInformationByDate($mass){
	echo "<div class = 'realLink'>".$mass["real"]."</div>";
	echo "<div class = 'numLinks'>Количество переходов - ".count($mass["date"])."</div>";
		for ($i = 0; $i <  count($mass["date"]) ; $i++) {
			echo "<div class = 'container'>";
			echo "<div class = 'date'><p>Дата посещения</p>".$mass["date"][$i]["date"]."</div>";
			echo "<div class = 'time'><p>Точное время</p>".$mass["date"][$i]["time"]."</div>";
			echo "<div class = 'ip'><p>IP адресс</p>".$mass["date"][$i]["ip_address"]."</div>";
			echo "<div class = 'region'><p>Регион</p>".$mass["date"][$i]["region"]."</div>";
			echo "<div class = 'browser'><p>Браузер</p>".$mass["date"][$i]["browser"]."</div>";
			echo "<div class = 'version'><p>Версия браузера</p>".$mass["date"][$i]["version"]."</div>";
			echo "<div class = 'platform'><p>Платформа</p>".$mass["date"][$i]["platform"]."</div>";
			echo "</div>";
		}
	};
	//end sort
	function sortNolinks($mass){
			echo "<div class = 'realLink'>".$mass["real"]."</div>";
			echo "По ссылке переходов не было.";
	}
	//css for information
	echo <<<HTML
	<style>
 	body {
 		margin:0px;
 		padding:0px;
 	}
 		.container{
 			display: inline-block;
 			width: 15%;
 			border: 1px solid black;
 			padding:15px;
 			margin:15px;
 		}
 		.date,.time,.ip,.region,.browser,.version{
			border-bottom: 1px solid black;
 		}
		.container div p {
			font-size: 12px;
			font-family: Arial;
			color: gray;
		}
		.realLink{
			font-size: 30px;
			margin-left: 50px;
		}
		.numLinks{
			font-size: 25px;
		}
		.vertualLink{
			margin-left: 30px;
		}
 	</style>
HTML;
 ?>