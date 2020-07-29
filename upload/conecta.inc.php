<?php
	$mysqli = new mysqli("mysql05-farm76.kinghost.net", "cruz01", "Cubldsv2017", "cruz01");

	/* check connection */
	if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
	}
	?>