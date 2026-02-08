<?php
	function get_terms(){
		include("../utilities/db.php");
		$sql_get_terms = $conn->prepare("SELECT * FROM TERM");
		$sql_get_terms->execute();
		$terms_table = $sql_get_terms->get_result();

		$terms = [];	
		while($term = $terms_table->fetch_assoc()){
			$terms[] = $term;
		}

		return $terms;
	}

?>