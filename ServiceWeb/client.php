<?php
try{
  $sClient = new SoapClient('http://localhost:8089/Projet5A/gameGeneratorMVC/ServiceWeb/server.wsdl');
  
  $response = $sClient->isAuthentified("julien.breton", "jusasju");
  
  var_dump($response);
  
  
} catch(SoapFault $e){
  var_dump($e);
}
?>
