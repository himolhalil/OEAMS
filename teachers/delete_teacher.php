<!-- <title>Delete Student</title> -->
<?php
	include("../utilities/utilities.php");
	if(!isset($_GET['id'])){
		header("Location: ./teachers.php");
	}
	$id = $_GET['id'];
	$sql_delete_teacher = $conn->prepare("DELETE FROM TEACHER WHERE TEACHER_ID = ?");
	if($sql_delete_teacher){
		$sql_delete_teacher->bind_param("i", $id);
		$sql_delete_teacher->execute();
		echo "<div class='alert alert-success mx-auto w-75'>Teacher Was Deleted Successfully</div>";
		echo "<div class='w-75 mx-auto text-center'><a class='btn btn-primary' href='./teachers.php'>Teachers Page</a></div>";
	} else {

	}

?>