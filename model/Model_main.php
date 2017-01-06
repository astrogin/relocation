<?php 
	use library_function\config;
	require_once "Model_abstract_class_mysql.php";
	require_once "Model_cookie.php";
	class Model_main implements IModel_main
	{
		protected $answer_urls_array;
		protected $mysql_commands_answer;
		protected $set_cookie;
		function __construct(IAnswer_urls $answer,IMysql_for_answer_url $mca,ISetting_cookie $sc){
			$this->mysql_commands_answer = $mca;
			//get cookie in Model_cookie.php
			$this->set_cookie = $sc;
			$this->answer_urls_array = $answer;
		}
		public function Action_index()
		{
			//array in controller_main.php
			return $this->answer_urls_array->answer_urls();

		}
	}
	#sort info of db
	class form_answer_urls implements IAnswer_urls{
		protected $Take_cookies_obj;
		protected $Mysql_result_obj;
		protected $set_cook;
		private $answer_cookie = array();
		function __construct(ISeted_cookie $Take_cookies,IMysql_for_answer_url $mysql_result,ISetting_cookie $set_cookie){
			$this->Take_cookies_obj = $Take_cookies;
			$this->Mysql_result_obj = $mysql_result;
			$this->set_cook = $set_cookie;
		}
		public function answer_urls(){
			if ($this->Take_cookies_obj->seted_cookie() === true) {
				return $answer_cookie = false;
			}else{
				$res = $this->Mysql_result_obj->answer_url_SELECT('statisticurl','cookie_ID','vertual_url',$this->set_cook->setting_cookies());
				if ($res !== false) {
					$select_array_first_table = config::result_row_mysql_in_array($res,'mysqli_fetch_assoc');
					for ($i = 0; $i <  count($select_array_first_table) ; $i++) {
						$timerVar = $select_array_first_table[$i]['vertual_url'];
						$new_res = $this->Mysql_result_obj->second_answer_url_SELECT($this->set_cook->setting_cookies(),$timerVar);
						$this->answer_cookie[] = config::result_row_mysql_in_array($new_res,'mysqli_fetch_row',$timerVar);
					}
					//array
					return $this->answer_cookie;
				}
			}
		}
	}
	class Mysql_for_answer extends Mysql implements IMysql_for_answer_url
	{
		public function answer_url_SELECT($table,$col_one,$col_two,$cookie_id){
			$query = "SELECT $col_two FROM $table WHERE $col_one = '$cookie_id'";
			$result = mysqli_query($this->link,$query);
			if ($result->num_rows >= 1) {
				return $result;
			}
			$this->mysql_result = false;
			return $this->mysql_result;
		}
		public function second_answer_url_SELECT($conditions_first,$conditions_second){
			$query = "SELECT `statistic_url` FROM `statisticurl` WHERE cookie_ID = '$conditions_first' AND vertual_url = '$conditions_second' UNION SELECT Reality FROM `realurl` WHERE Vertuality = '$conditions_second'";
			$result = mysqli_query($this->link,$query);
			return $result;
		}
	}
 ?>