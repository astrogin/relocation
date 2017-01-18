<?php
	require_once 'Route.php';
	$rr = new Route(array("controller_name" => "main"),'Controller_','controller/');
	$rr->run();
?>
