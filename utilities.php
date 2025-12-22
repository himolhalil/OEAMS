<?php
	function is_valid($string, $length){
		if(strlen($string) <= $length){
			return trim(htmlspecialchars($string));
		} else {
			return false;
		}
	}

	$conn = mysqli_connect("localhost" ,"root","new_password", "OEAMS");
?>