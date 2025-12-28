<?php
	include("../utilities/utilities.php");
	$id = $_GET['id'];
	if(isset($id)){
		echo "<div class='w-75 mx-auto'>";
			echo "<div class='alert alert-danger'>DO YOU REALLY WANT TO DELETE THE TEACHER ?</div>";
			echo "<a href='delete_teacher.php?id=$id'><button class='me-2 btn btn-danger'>YES SURE</button></a>";
			echo "<a href='teachers.php'><button class='btn btn-primary'>NO GO BACK TO TEACHER</button></a>";
		echo "</div>";
	}
?>