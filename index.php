<?php

	require("PhpCrawler.php");

	header('Content-Type: application/json');
	$crawler = new PhpCrawler();


	echo json_encode($crawler->run($_GET['url'], $_GET['depth']));

	

?>
