<?php
	use library_function\config;
	require_once 'Model_abstract_class_mysql.php';
	require_once 'D:\phpapachemsql\www\library\library_function.php';
	require_once 'D:\phpapachemsql\www\library\SxGeo.php';
	require_once 'D:\phpapachemsql\www\library\browser_chek.php';
	class Model_take_data implements IModel_take_data{
		private $ip;
		private $date_time;
		private $BVP;
		private $region;
		private $mysqli;
		function __construct(ITake_ip $ips,ITake_date_and_time $date,ITake_browser_version_platform $bvps,ITake_region $reg,IMysql_model_take_data $msq){
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
			$statistic_uri = explode("Q",substr(config::clean($_SERVER["REQUEST_URI"]), 1))[1];
			$result_mysqli = $this->mysqli->statistic_url_SELECT('statistic','statistic_url',$statistic_uri);
			$mysqli_fetch = mysqli_fetch_row($result_mysqli);
			$date = $this->date_time->return_date()[0];
			$time = $this->date_time->return_date()[1];
			$ip = $this->ip->return_ip();
			$region = $this->region->return_region();
			$browser = $this->BVP->return_b_v_p()['browser'];
			$version = $this->BVP->return_b_v_p()['version'];
			$platform = $this->BVP->return_b_v_p()['platform'];
			if ($mysqli_fetch[1] == null) {
				$this->mysqli->statistic_UPDATE($date,$time,$ip,$region,$browser,$version,$platform,$statistic_uri);
			}else{
				$this->mysqli->statistic_INSERT($date,$time,$ip,$region,$browser,$version,$platform,$statistic_uri);
			}
		}
	}
	class take_ip implements ITake_ip {
		public function return_ip(){
			return $_SERVER['REMOTE_ADDR'];
		}
	}
	class take_date_and_time implements ITake_date_and_time{
		public function return_date(){
			return array(date("Y-m-d"),date("H:i:s"));
		}
	}
	class take_browser_version_platform implements ITake_browser_version_platform {
		private $script_ckeker;
		private $array_answer = array();
		function __construct(IScript_browser_version_platform $scr){
			$this->script_ckeker = $scr;
		}
		public function return_b_v_p(){
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
	class take_region implements ITake_region{
		public function return_region(){
					$SxGeo = new SxGeo('D:\phpapachemsql\www\library\SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
					$region = $SxGeo->getCityFull($_SERVER["REMOTE_ADDR"])['region']['name_ru'];
					if ($region == '') {
						$region = 'Неизвестный регион';
					};
					return $region;
			}
	}
	class Mysql_model_take_data extends Mysql implements IMysql_model_take_data{
		public function statistic_url_SELECT($table,$col,$val){
			$query = "SELECT * FROM $table WHERE $col LIKE '$val'";
			$result = mysqli_query($this->link,$query);
			return $result;
		}
		public function statistic_UPDATE($date,$time,$ip,$region,$browser,$version,$platform,$val){
			$query = "UPDATE statistic SET date = '$date',time='$time',ip_address='$ip',region='$region',browser='$browser',version ='$version',platform='$platform' WHERE statistic_url = '$val'";
			return mysqli_query($this->link,$query);
		}
		public function statistic_INSERT($date,$time,$ip,$region,$browser,$version,$platform,$val){
			$query = "INSERT INTO statistic VALUES ('$val','$date','$time','$ip','$region','$browser','$version','$platform')";
			return mysqli_query($this->link,$query);
		}
	}
 ?>