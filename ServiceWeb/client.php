<?php
try{
  $sClient = new SoapClient('http://localhost:8089/gameGeneratorMVC/ServiceWeb/server.wsdl');
  
  $response = $sClient->isAuthentified("julien.breton", "juju");
  
  var_dump($response);
  
  
} catch(SoapFault $e){
  var_dump($e);
}
?>
