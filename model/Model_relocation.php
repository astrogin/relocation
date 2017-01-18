<?php 
	use library_function\config;
	class Model_relocation implements IModel_relocation{
		private $mysqli;
		function __construct($msq)
		{
			$this->mysqli = $msq;
		}
		public function Action_relocation(){
			$this->logic_relocation();
		}
		private function logic_relocation(){
			preg_match("/[\w]{2,4}Q[\w]{2,4}+/m",config::clean($_SERVER['REQUEST_URI']),$matches);
			$array_urls = explode("Q",$matches[0]);
			$arr_im_msq = ['s',$array_urls[0]];
			$result_real_uri = $this->mysqli->find('realurl','Vertuality = ?',$arr_im_msq);
			if ($result_real_uri->num_rows) {
				$reaul_uri_nonfixed = $result_real_uri->fetch_assoc()['Reality'];
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
 ?>