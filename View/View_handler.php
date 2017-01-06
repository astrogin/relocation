<?php 
	function result_new_urls($mass)
	{
		for ($i=0; $i < count($mass) ; $i++) { 
			echo $mass[$i][2]."<br>";
			echo "Ссылка для переходов: ".$mass[$i][0]."<br>";
			echo "Ссылка для статистки: ".$mass[$i][1]."<br><br>";
		}
	}
 ?>