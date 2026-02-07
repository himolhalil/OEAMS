<?php
	include("../utilities/auth.php");
	go_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Teacher </title>
	<?php include('../utilities/utilities.php'); ?>
</head>
<body>
<?php

	if (!isset($_GET['id'])) die("You Must Specify A Teacher");

		$id = $_GET['id'];

		$sql_select_teacher = $conn->prepare("SELECT * FROM TEACHER WHERE TEACHER_ID = ?");
		$sql_select_teacher->bind_param("i", $id);
		$sql_select_teacher->execute();

		$teacher = $sql_select_teacher -> get_result() -> fetch_assoc();

		if(!$teacher){
			die("<p class='alert alert-danger w-75 mx-auto my-4'>This Teacher Doesn't Exist</p>");
		}


		$teacher_id =  $teacher["TEACHER_ID"];
		$teacher_first_name = $teacher["FIRST_NAME"];
		$teacher_middle_names = $teacher["MIDDLE_NAMES"];
		$teacher_last_name = $teacher["LAST_NAME"];
		$teacher_phone_number = $teacher["PHONE_NUMBER"];
		
		echo "

			<form class='pop-up-form' method='POST' action='./edit_teacher.php?id=$id'>
				<input  class='form-control' name='id' type='hidden'>

				<label for='first_name'>First Name</label>
				<input id='first_name' placeholder='First Name' type='text' value='$teacher_first_name' class='form-control' name='first_name' />

				<label for='middle_names'>Middle Names</label>
				<input id='middle_names' placeholder='Middle Names' value='$teacher_middle_names' class='form-control' name='middle_names' />

				<label for='last_name'>Last Name</label>
				<input id='last_name' placeholder='Last Name' value='$teacher_last_name' class='form-control' name='last_name' />

				<label for='phone_number'>Phone Number</label>
				<input id='phone_number' placeholder='Phone Number' value='$teacher_phone_number' class='form-control' name='phone_number' />

				<button class='btn btn-warning' type='submit'>Edit</button>

				<a href='./teachers.php'><button type='button' class='btn btn-danger'>Cancel</button></a>


			</form>


		";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$new_teacher_first_name =  $_POST["first_name"];
		$new_teacher_last_name =  $_POST["last_name"];
		$new_teacher_middle_names =  $_POST["middle_names"];
		$new_teacher_phone_number =  $_POST["phone_number"];

		$sql_update_teacher = $conn->prepare('update TEACHER set FIRST_NAME = ?, MIDDLE_NAMES = ?, LAST_NAME = ?, PHONE_NUMBER = ? where teacher_ID = ?');
		$sql_update_teacher->bind_param("ssssi", $new_teacher_first_name, $new_teacher_middle_names, $new_teacher_last_name, $new_teacher_phone_number, $id);
		$sql_update_teacher->execute();

		header('Location: teachers.php');

	}

?>
</body>
</html>