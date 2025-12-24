<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../css/style.css">
<?php
	function is_valid($string, $length){
		if(strlen($string) <= $length){
			return trim(htmlspecialchars($string));
		} else {
			return false;
		}
	}
	// edit with your own username and password
	$conn = mysqli_connect("localhost" ,"root","new_password", "OEAMS");
?>
<script src="../js/bootstrap.js"></script>
<script src="../js/script.js"></script>