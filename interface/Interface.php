<?php 
	//Controller Interface

	//Model Interface
	interface ISeted_cookie{
		function seted_cookie();
	}
	interface ISetting_cookie{
		function setting_cookies();
	}
	interface IMysql_for_cookie{
		function setting_cookies_SELECT($table,$coll,$cookie_id_new);
		//function setting_cookies_INSERT($table,$coll,$cookie_id_new);
	}
	interface IModel_main{
		function Action_index();
	}


	interface IMysql_for_answer_url{
		function answer_url_SELECT($table,$col_one,$col_two,$cookie_id);
		function second_answer_url_SELECT($conditions_first,$conditions_second);
	}
	interface IAnswer_urls{
		function answer_urls();
	}


	interface IModel_handler{
		function Action_handler($array);
	}
	interface IMysql_comands_handler{
		function same_real_url_SELECT($table,$col,$val);
		function same_vertual_url_SELECT($table,$col_first,$col_second,$val_first,$val_second);
		function INSERT_one_table(...$args);
		function addInTablesStatisticurlAndStatisticNewUrl($table_1,$table_2,$col,$val_1,$val_2,$val_3);
	}
	interface IExecutor_handler{
		function executer($array,$callback);
	}
	interface IExecutor_supporting_function{
		function create_array_new_links($vert_url,$statistic_url,$real_url);
		function chekRandomVirtualityNameInMysqlForStatistic();
		function addInTableRealurlNewUrl($real_url);
	}
	#Model_relocation
	interface IModel_relocation{
		function Action_relocation();
	}
	interface IMysql_model_relocation{
		function real_url_SELECT($table,$col,$val);
	}
	#Model_take_data.php
	interface IModel_take_data{
		function Action_take_data();
	}
	interface ITake_ip{
		function return_ip();
	}
	interface ITake_date_and_time{
		function return_date();
	}
	interface ITake_browser_version_platform {
		function return_b_v_p();
	}
	interface ITake_region{
		function return_region();
	}
	#Model_statistic.php
	interface IModel_statistic{
		function Action_statistic();
	}
	interface IMysql_statistic{
		function real_url_SELECT(...$args);
	}
	#browser_chek.php
	interface IScript_browser_version_platform{
		function browser_and_version($user_agent);
		function platform($user_agent);
	}
	interface IMysql_model_take_data{
		function statistic_url_SELECT($table,$col,$val);
		function statistic_UPDATE($date,$time,$ip,$region,$browser,$version,$platform,$val);
		function statistic_INSERT($date,$time,$ip,$region,$browser,$version,$platform,$val);
	}
?>