<?php 
	use library_function\config;
	class Model_statistic implements IModel_statistic {
		private $mysqli;
		function __construct($msq)
		{
			$this->mysqli = $msq;
		}
		public function Action_statistic(){
			//assoc array in controller
			return $this->push_array_answer();
		}
		private function push_array_answer(){
			preg_match("/[\w]{2,4}Q[\w]{2,4}+/m",config::clean($_SERVER['REQUEST_URI']),$matches);
			$array_urls = explode("Q",$matches[0]);
			$arr_in_msq = ['s',$array_urls[0]];
			$real_uri = $this->mysqli->find("realurl","Vertuality = ?",$arr_in_msq)->fetch_assoc()['Reality'];
			$arr_in_msq[1] = $array_urls[1];
			$result_statistic = $this->mysqli->find("statistic","statistic_url = ?",$arr_in_msq);
			if ($result_statistic->num_rows) {
				$answer = $result_statistic->fetch_all(MYSQLI_ASSOC);
				return array("date"=>$answer,"real"=>"$real_uri");
			}
			$statistic_date = array("date"=>null,"real"=>$real_uri);
			return $statistic_date;
		}
	}
 ?>