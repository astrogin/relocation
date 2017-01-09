<?php 
	use library_function\config;
	abstract class Cookies{
		protected $Mysql_result_obj;
		public $cookie_id;
		function __construct(IMysql_for_cookie $mysql_result){
			$this->Mysql_result_obj = $mysql_result;
			$this->cookie_id = config::clean($_COOKIE['ID'] ?? "Anonymous");
		}
	}
	class Set_cookies extends Cookies implements ISetting_cookie
	{
		public function setting_cookies()
		{
			if ($this->cookie_id === "Anonymous"){
				$this->cookie_id = config::randomVirtualityName();
				$mysql_bool = $this->Mysql_result_obj->setting_cookies_SELECT('statisticurl','cookie_ID',$this->cookie_id);
				if ($mysql_bool->num_rows !== 0) return $this->setting_cookies();
				setcookie("ID",$this->cookie_id,time()+999999999);
			}
			//string
			return $this->cookie_id;
		}
	}
	class Mysql_for_cookie extends Mysql implements IMysql_for_cookie
	{
		public function setting_cookies_SELECT($table,$coll,$cookie_id_new){
			return mysqli_query($this->link,"SELECT * FROM $table WHERE $coll LIKE '$cookie_id_new'");
		}
	}
 ?>