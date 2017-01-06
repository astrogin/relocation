<?php 
namespace library_function;
class config
{
	public static function clean($value) {
		    $value = trim($value);
		    $value = stripslashes($value);
		   	$value = strip_tags($value);
		    $value = htmlspecialchars($value);
		    return $value;
	}
	public static function randomVirtualityName() {
			$key = ''; 
			$array = array_merge(range('A','P'),range('R','Z'),range('a','p'),range('r','z'),range('0','9')); 
			$c = count($array); 
			for($i=0;$i<=3;$i++) {
				@$key .= $array[rand(0,$c)];
			};
			return $key;
	}
	public static function result_row_mysql_in_array(...$args){
			$mass = array();
			while($rows = $args[1]($args[0])){
				if (isset($args[2])) {
					array_push($mass, "$rows[0]","$args[2]");
				}else{
					$mass[] = $rows;
				}
			}
			return $mass;
	}
}
 ?>
