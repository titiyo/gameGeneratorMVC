<?php
	require_once '../Model/ModelUser.php';
	require_once '../Framework/Controller.php';
	require_once '../Framework/Model.php';

	ini_set("soap.wsdl_cache_enabled","0");
	$server = new SoapServer("server.wsdl");
	
	function isAuthentified($login, $pwd){
		$modelUser = new ModelUser();
		$user = $modelUser->getUser($login, $pwd);
		if($user != null)
        {
			return "true";
		}
		else
		{
			return "false";
		}
	}
	
	$server->AddFunction("isAuthentified");
	$server->handle();
?>
