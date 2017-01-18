<?php
	#Model Interface
	/*Model_cookie.php*/
	//This inteface implements method which sends answer in model_main.
	interface ISetting_cookie{
		function setting_cookies();
	}
	/*Model_main.php*/
	//This inteface implements method which sends answer in controller.
	interface IModel_main{
		function Action_index();
	}
	//result in model_main
	interface IAnswer_urls{
		function answer_urls();
	}
	/*Mode_handler.php*/
	//This inteface implements method which sends answer in controller.
	interface IModel_handler{
		function Action_handler($array);
	}
	/*Model_relocation.php*/
	//This inteface implements method which sends answer in controller.
	interface IModel_relocation{
		function Action_relocation();
	}
	/*Model_take_data.php*/
	//This inteface implements method which sends answer in controller.
	interface IModel_take_data{
		function Action_take_data();
	}
	// return data in Model_take_data
	interface ITake_data{
		function return_data();
	}
	#Model_statistic.php
	//This inteface implements method which sends answer in controller.
	interface IModel_statistic{
		function Action_statistic();
	}
?>