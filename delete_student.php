<!-- <title>Delete Student</title> -->
<?php
	include("utilities.php");
	if(!isset($_GET['id'])){
		header("Location: ./students.php");
	}
	$id = $_GET['id'];
	$sql_delete_student = $conn->prepare("DELETE FROM STUDENT WHERE STUDENT_ID = ?");
	if($sql_delete_student){
		$sql_delete_student->bind_param("i", $id);
		$sql_delete_student->execute();
		echo "<div class='alert alert-success mx-auto w-75'>Student Was Deleted Successfully</div>";
		echo "<div class='w-75 mx-auto text-center'><a class='btn btn-primary' href='./students.php'>Students Page</a></div>";
	} else {

	}

?>