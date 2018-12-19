<?php
	if(@$_GET['id'] > 0){
		require_once('lib/nusoap.php');
		//$wsdl = "http://10.33.34.151/server.php?wsdl";
		$wsdl = "http://localhost:8080/soap/server.php?wsdl";
		$client = new nusoap_client($wsdl, true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2>' . $err;
			exit();
		}
		try {
			$id = $_GET['id'];
			
			$result = $client->call('deleteBook',array($id));
			//print_r($result);
			echo $result;
			header('Location: http://localhost:8080/soap/client.php');
		}catch(Exception $e) {
			echo 'Caught exception: '.$e->getMessage()."\n";
		}
	}
?>
