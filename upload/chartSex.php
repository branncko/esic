<?php
	$pdo = new PDO('mysql:host=mysql.cruz.ce.gov.br;dbname=cruz01;port=3306;charset=utf8', 'cruz01', 'Cubldsv2017');
	
	// Sexo
	$sql = "SELECT value, CASE WHEN COUNT(sexo) > 0 THEN COUNT(sexo) ELSE 0 END AS total FROM ost_list_items LEFT JOIN ost_user__cdata ON ost_user__cdata.sexo = ost_list_items.id WHERE ost_list_items.list_id = 2 and ost_list_items.status = 1 GROUP BY ost_list_items.id";

	$statement = $pdo->prepare($sql);
	
	$statement->execute();
	
	while($results = $statement->fetch(PDO::FETCH_ASSOC)) {
		
		$result[] = $results;
		
	}
	
	header("Access-Control-Allow-Origin: *");
	
	echo json_encode($result);
?>