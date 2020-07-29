<?php
	$pdo = new PDO('mysql:host=mysql.cruz.ce.gov.br;dbname=cruz01;port=3306;charset=utf8', 'cruz01', 'Cubldsv2017');
	
	$sql = "SELECT COUNT(*) AS totalg FROM ost_ticket";
	
	$statement = $pdo->prepare($sql);
	
	$statement->execute();
	
	while($results = $statement->fetch(PDO::FETCH_ASSOC)) {
		
		$result[] = $results;
		
	}
	
	$sql2 = "SELECT COUNT(*) AS totalg FROM ost_ticket WHERE closed";
	
	$statement = $pdo->prepare($sql2);
	
	$statement->execute();
	
	while($results2 = $statement->fetch(PDO::FETCH_ASSOC)) {
		
		$result[] = $results2;
		
	}
	
	header("Access-Control-Allow-Origin: *");
	
	echo json_encode($result);
?>