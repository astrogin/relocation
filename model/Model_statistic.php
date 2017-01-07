<?php 
	use library_function\config;
	class Model_statistic implements IModel_statistic {
		private $mysqli;
		function __construct(IMysql_statistic $msq)
		{
			$this->mysqli = $msq;
		}
		public function Action_statistic(){
			//assoc array in controller
			return $this->push_array_answer();
		}
		private function push_array_answer(){
			$array_urls = explode("Q",substr(config::clean($_SERVER["REQUEST_URI"]), strrpos(config::clean($_SERVER["REQUEST_URI"]),'/')+1));
			$real_uri = mysqli_fetch_assoc($this->mysqli->real_url_SELECT("realurl","Vertuality",$array_urls[0]))['Reality'];
			$statistic_uri = substr($array_urls[1],0,-1);
			$result_statistic = $this->mysqli->real_url_SELECT("statistic","statistic_url",$statistic_uri,"date");
			if ($result_statistic->num_rows) {
				while($rows = mysqli_fetch_assoc($result_statistic)){
					$statistic_date[] = $rows;
				};
				//return assoc array
				return array("date"=>$statistic_date,"real"=>"$real_uri");
			}
			$statistic_date = array("date"=>null,"real"=>$real_uri);
			return $statistic_date;
		}
	}
	class Mysql_statistic extends Mysql implements IMysql_statistic{
		public function real_url_SELECT(...$args){
			if (isset($args[3])) {
				$query = "SELECT * FROM $args[0] WHERE $args[1] = '$args[2]' ORDER BY $args[3]";
				$result = mysqli_query($this->link,$query);
				return $result;
			}
			$query = "SELECT * FROM $args[0] WHERE $args[1] = '$args[2]'";
			$result = mysqli_query($this->link,$query);
			return $result;
		}
	}
 ?>