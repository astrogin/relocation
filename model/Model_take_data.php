<?php
	use library_function\config;
	class Model_take_data implements IModel_take_data{
		private $ip;
		private $date_time;
		private $BVP;
		private $region;
		private $mysqli;
		function __construct(ITake_data $ips,ITake_data $date,ITake_data $bvps,ITake_data $reg,$msq){
			$this->ip = $ips;
			$this->date_time = $date;
			$this->BVP = $bvps;
			$this->region = $reg;
			$this->mysqli = $msq;
		}
		public function Action_take_data()
		{
			$this->logic_data();
		}
		private function logic_data(){
			$table = 'statistic';
			preg_match("/[\w]{2,4}Q[\w]{2,4}+/m",config::clean($_SERVER['REQUEST_URI']),$matches);
			$statistic_uri = explode("Q",$matches[0])[1];
			$arr_in_msq = [
				'ssssssss',
				$statistic_uri,
				"date" => $this->date_time->return_data()[0],
				"time" => $this->date_time->return_data()[1],
				"ip_address" => $this->ip->return_data(),
				"region" => $this->region->return_data(),
				"browser" => $this->BVP->return_data()['browser'],
				"version" => $this->BVP->return_data()['version'],
				"platform" => $this->BVP->return_data()['platform'],
			];
			$result_mysqli = $this->mysqli->find($table,'statistic_url = ?',['s',$statistic_uri]);
			if ($result_mysqli->fetch_assoc()['date'] === null) {
				$this->mysqli->update($table,"statistic_url = ?",$arr_in_msq);
			}else{
				$arr_in_msq[0] = 'ssssssss';
				$arr = array_values($arr_in_msq);
				$this->mysqli->insert($table,$arr);
			}
		}
	}
	class take_ip implements ITake_data {
		public function return_data(){
			return $_SERVER['REMOTE_ADDR'];
		}
	}
	class take_date_and_time implements ITake_data{
		public function return_data(){
			return array(date("Y-m-d"),date("H:i:s"));
		}
	}
	class take_browser_version_platform implements ITake_data {
		private $script_ckeker;
		private $array_answer = array();
		function __construct($scr){
			$this->script_ckeker = $scr;
		}
		public function return_data(){
			$this->array_answer = $this->browser_version();
			$this->array_answer["platform"] = $this->platform();
			return $this->array_answer;
		}
		private function browser_version(){
			return $this->script_ckeker->browser_and_version($_SERVER['HTTP_USER_AGENT']);
		}
		private function platform(){
			return $this->script_ckeker->platform($_SERVER['HTTP_USER_AGENT']);
		}
	}
	class take_region implements ITake_data{
		public function return_data(){
					$SxGeo = new SxGeo('library\SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
					$region = $SxGeo->getCityFull($_SERVER["REMOTE_ADDR"])['region']['name_ru'];
					if ($region == '') {
						$region = 'Неизвестный регион';
					};
					return $region;
			}
	}
 ?>