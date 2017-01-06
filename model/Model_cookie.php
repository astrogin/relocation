<?php 
	use library_function\config;
	abstract class Cookies{
		protected $Take_cookies_obj;
		protected $Mysql_result_obj;
		function __construct(ISeted_cookie $Take_cookies,IMysql_for_cookie $mysql_result){
			$this->Take_cookies_obj = $Take_cookies;
			$this->Mysql_result_obj = $mysql_result;
		}
	}
	class Take_cookies implements ISeted_cookie
	{
		public $cookie_id;
		private $cookie_install = false;
		function __construct(){
			if (isset($_COOKIE["ID"])) {
				$this->cookie_id = config::clean($_COOKIE["ID"]);
			}
		}
		public function seted_cookie(){
			if (isset($this->cookie_id)) {
				$this->cookie_install = false;
				return $this->cookie_install;
			}else{
				$this->cookie_install = true;
				return $this->cookie_install;
			}
		}

	}
	class Set_cookies extends Cookies implements ISetting_cookie
	{
		public function setting_cookies()
		{
			if ($this->Take_cookies_obj->seted_cookie() === true) {
				$cookie_id_new = config::randomVirtualityName();
				$mysql_bool = $this->Mysql_result_obj->setting_cookies_SELECT('statisticurl','cookie_ID',$cookie_id_new);
				if ($mysql_bool === true) {
					return $this->setting_cookies();
				}else{
					setcookie("ID",$cookie_id_new,time()+999999999);
					//$this->Mysql_result_obj->setting_cookies_INSERT('statisticurl','cookie_ID',$cookie_id_new);
				}
				//string in Model_main.php
				return $cookie_id_new;
			}else{
				//string in Model_main.php
				return $this->Take_cookies_obj->cookie_id;
			}
		}
	}
	class Mysql_for_cookie extends Mysql implements IMysql_for_cookie
	{
		public function setting_cookies_SELECT($table,$coll,$cookie_id_new){
			$query = "SELECT * FROM $table WHERE $coll LIKE '$cookie_id_new'";
			$result = mysqli_query($this->link,$query);
			if ($result->num_rows < 1) {
				$this->mysql_result = false;
			}
			return $this->mysql_result;
		}
		/*public function setting_cookies_INSERT($table,$coll,$cookie_id_new){
			$query = "INSERT INTO $table ($coll) VALUES ('$cookie_id_new')";
			$result = mysqli_query($this->link,$query);
		}*/
	}
 ?>