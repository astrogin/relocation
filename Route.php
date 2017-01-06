<?php
use library_function\config;
require_once 'library/library_function.php';
abstract class As_router {
	protected $controlAndAction = array();
	protected $controller_name = '';
	protected $controller_path = '';
	function __construct($arr_controls_actions_name,$controller_name,$controller_path){
	$this->controlAndAction = $arr_controls_actions_name;
	$this->controller_name = $controller_name;
	$this->controller_path = $controller_path;
	}
	abstract function run();
	protected function Error404(){
		header("Location: 404.php",true,301);
	}
}

class Route extends As_router
{
	public function run(){
		$this->set_uri();
		$this->inc_files();
	}
	protected function get_uri($item)
	{
		$UriArray = explode("Q",substr(config::clean($item), 1));
		//array
		return $UriArray;
	}
	protected function set_uri()
	{
		#UriArray have two emlements only(first for realUri,second for statisticUri)
	 	$UriArray = $this->get_uri($_SERVER["REQUEST_URI"]);
		if (count($UriArray) === 2 && stripos($UriArray[1],'+')) 
		{
			$this->controlAndAction['controller_name'] = 'statistic';
			return;
		}
		else if (count($UriArray) === 2)
		{
			$this->controlAndAction['controller_name'] = 'relocation';
			return;			
		}
	}
	protected function inc_files(){
		$this->controller_path .= $this->controller_name.$this->controlAndAction['controller_name'].'.php';
		if (file_exists($this->controller_path)) {
			require_once "$this->controller_path";
		}else{
			$this->Error404();
		}
	}
}
 ?>
