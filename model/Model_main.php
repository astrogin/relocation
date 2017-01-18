<?php 
	use library_function\config;
	class Model_main implements IModel_main
	{
		protected $answer_urls_array;
		protected $mysql_commands_answer;
		protected $set_cookie;
		function __construct(IAnswer_urls $answer,$mca,ISetting_cookie $sc){
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
		protected $Mysql_result_obj;
		protected $set_cook;
		private $answer_cookie = array();
		function __construct($mysql_result,ISetting_cookie $set_cookie){
			$this->Mysql_result_obj = $mysql_result;
			$this->set_cook = $set_cookie;
		}
		public function answer_urls(){
			if ($this->set_cook->cookie_id === "Anonymous") {
				return $answer_cookie = false;
			}else{
				$res = $this->Mysql_result_obj->save_mode("SELECT vertual_url FROM statisticurl WHERE cookie_ID=?",["s",$this->set_cook->setting_cookies()]);
				if ($res->num_rows >= 1) {
					$select_array_first_table = config::result_row_mysql_in_array($res,'mysqli_fetch_assoc');
					for ($i = 0; $i <  count($select_array_first_table) ; $i++) {
						$timerVar = $select_array_first_table[$i]['vertual_url'];
						$new_res = $this->Mysql_result_obj->save_mode("SELECT statistic_url FROM statisticurl WHERE cookie_ID=? AND vertual_url=? 
									UNION SELECT Reality FROM realurl WHERE Vertuality=?",["sss",$this->set_cook->setting_cookies(),$timerVar,$timerVar]);
						$this->answer_cookie[] = config::result_row_mysql_in_array($new_res,'mysqli_fetch_row',$timerVar);
					}
					//array
					return $this->answer_cookie;
				}
			}
		}
	}
 ?>