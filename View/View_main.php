<?php 
	function showInfo ($mass){
		echo "Ваши ссылки:<br>";
		for ($i=0; $i < count($mass); $i++) { 
			echo $mass[$i][2]."<br>";
			echo "Ссылка для переходов: asdasdwerc.000webhostapp.com/".$mass[$i][1]."Q".$mass[$i][0]."<br>";
			echo "Ссылка для статистки: asdasdwerc.000webhostapp.com/".$mass[$i][1]."Q".$mass[$i][0]."+<br><br>";
		}
	};
	function ShowEmptyUrls(){
		echo "Вы не сократили ещё ни одной ссылки";
	}
	echo <<<HTML
	<div class = "container_content">
		<form id = "form">
		<input type="text" id="mainInput">
		<button type="submit">Обрезалка</button>
		</form>
		<div id="test"></div>
	</div>
	<style>
	body{
		padding:0;
		margin:0;
	}
	.container_content{
		width: 100%;
		vertical-align: middle;
		text-align: center;
	}
	.container_content form{
		margin-top: 20%;
		color: green;
	}
	.function {
		width: 400px;
		height:200px;
		vertical-align: top;
	}
	</style>
HTML;
?>