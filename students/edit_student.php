<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Student </title>
	<?php include('../utilities/utilities.php'); ?>
</head>
<body>
<?php

	if (!isset($_GET['id'])) die("You Must Specify A Student");

		$id = $_GET['id'];

		$sql_select_student = $conn->prepare("SELECT * FROM STUDENT WHERE STUDENT_ID = ?");
		$sql_select_student->bind_param("i", $id);
		$sql_select_student->execute();

		$student = $sql_select_student -> get_result() -> fetch_assoc();

		if(!$student){
			die("<p class='alert alert-danger w-75 mx-auto my-4'>This Student Doesn't Exist</p>");
		}


		$student_id =  $student["STUDENT_ID"];
		$student_first_name = $student["FIRST_NAME"];
		$student_middle_names = $student["MIDDLE_NAMES"];
		$student_last_name = $student["LAST_NAME"];
		$student_phone_number = $student["PHONE_NUMBER"];
		
		echo "

			<form class='pop-up-form' method='POST' action='./edit_student.php?id=$id'>
				<input  class='form-control' name='id' type='hidden'>

				<label for='first_name'>First Name</label>
				<input id='first_name' placeholder='First Name' type='text' value='$student_first_name' class='form-control' name='first_name' />

				<label for='middle_names'>Middle Names</label>
				<input id='middle_names' placeholder='Middle Names' value='$student_middle_names' class='form-control' name='middle_names' />

				<label for='last_name'>Last Name</label>
				<input id='last_name' placeholder='Last Name' value='$student_last_name' class='form-control' name='last_name' />

				<label for='phone_number'>Phone Number</label>
				<input id='phone_number' placeholder='Phone Number' value='$student_phone_number' class='form-control' name='phone_number' />

				<button class='btn btn-warning' type='submit'>Edit</button>

				<a href='./students.php'><button type='button' class='btn btn-danger'>Cancel</button></a>


			</form>


		";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$new_student_first_name =  $_POST["first_name"];
		$new_student_last_name =  $_POST["last_name"];
		$new_student_middle_names =  $_POST["middle_names"];
		$new_student_phone_number =  $_POST["phone_number"];

		$sql_update_student = $conn->prepare('update STUDENT set FIRST_NAME = ?, MIDDLE_NAMES = ?, LAST_NAME = ?, PHONE_NUMBER = ? where STUDENT_ID = ?');
		$sql_update_student->bind_param("ssssi", $new_student_first_name, $new_student_middle_names, $new_student_last_name, $new_student_phone_number, $id);
		$sql_update_student->execute();

		header('Location: students.php');

	}

?>
</body>
</html>