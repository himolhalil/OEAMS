<?php
	include("./get_terms.php");
	$terms = get_terms();
	echo json_encode($terms);
?>