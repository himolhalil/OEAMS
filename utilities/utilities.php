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
	include('../utilities/db.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<script src="../js/bootstrap.js"></script>
<script src="../js/script.js" defer></script>
