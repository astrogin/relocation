<?php 
	use library_function\config;
	require_once 'Model_abstract_class_mysql.php';
	require_once 'D:\phpapachemsql\www\library\library_function.php';
	class Model_relocation implements IModel_relocation{
		private $mysqli;
		function __construct(IMysql_model_relocation $msq)
		{
			$this->mysqli = $msq;
		}
		public function Action_relocation(){
			$this->logic_relocation();
		}
		private function logic_relocation(){
			$vertual_uri = explode("Q",substr(config::clean($_SERVER["REQUEST_URI"]), 1))[0];
			$result_real_uri = $this->mysqli->real_url_SELECT('realurl','Vertuality',$vertual_uri);
			if ($result_real_uri->num_rows) {
				$reaul_uri_nonfixed = mysqli_fetch_assoc($result_real_uri)['Reality'];
				$real_uri = $this->fixed_real_url($reaul_uri_nonfixed);
				header("Location: http://$real_uri",true,301);
			}else{
				header("Location: 404.php",true,301);
			}
		}
		private function fixed_real_url($real){
			$rowFixed = explode("://",$real);
			$res = '';
			if (isset($rowFixed[1])) {
				$res = $rowFixed[1];
			}else{
				$res = $real;
			};
			return $res;
		}
	}
	class Mysql_model_relocation extends Mysql implements IMysql_model_relocation{
		public function real_url_SELECT($table,$col,$val){
			$result = mysqli_query($this->link,"SELECT HIGH_PRIORITY * FROM $table WHERE $col LIKE '$val'");
			return $result;
		}
	}
 ?>