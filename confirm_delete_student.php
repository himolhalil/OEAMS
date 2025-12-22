<?php
	include("utilities.php");
	$id = $_GET['id'];
	if(isset($id)){
		echo "<div class='w-75 mx-auto'>";
			echo "<div class='alert alert-danger'>DO YOU REALLY WANT TO DELETE THE STUDENT ?</div>";
			echo "<a href='delete_student.php?id=$id'><button class='me-2 btn btn-danger'>YES SURE</button></a>";
			echo "<a href='students.php'><button class='btn btn-primary'>NO GO BACK TO STUDENTS</button></a>";
		echo "</div>";
	}
?>