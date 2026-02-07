<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Course </title>
	<?php include('../utilities/utilities.php'); ?>
</head>
<body>
<?php

	if (!isset($_GET['id'])) die("You Must Specify A Course");

		$id = $_GET['id'];

		$sql_select_course = $conn->prepare("SELECT * FROM COURSE WHERE COURSE_ID = ?");
		$sql_select_course->bind_param("i", $id);
		$sql_select_course->execute();

		$course = $sql_select_course -> get_result() -> fetch_assoc();

		if(!$course){
			die("<p class='alert alert-danger w-75 mx-auto my-4'>This Course Doesn't Exist</p>");
		}


		$course_id =  $course["COURSE_ID"];
		$course_name = $course["COURSE_NAME"];
		$course_book = $course["COURSE_BOOK"];
		
		echo "
			<form class='pop-up-form' method='POST' action='./edit_course.php?id=$id'>
				<input  class='form-control' name='id' type='hidden'>

				<label for='course_name'>Course Name</label>
				<input id='course_name' placeholder='Course Name' type='text' value='$course_name' class='form-control' name='course_name' />

				<label for='course_book'>Course Book</label>
				<input id='course_book' placeholder='Course Book' type='text' value='$course_book' class='form-control' name='course_book' />

				<button class='btn btn-warning' type='submit'>Edit</button>

				<a href='./courses.php'><button type='button' class='btn btn-danger'>Cancel</button></a>

			</form>
		";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$new_course_name =  $_POST["course_name"];
		$new_course_book =  $_POST["course_book"];
		echo "<script>alert($new_course_book)</script>";

		$sql_update_student = $conn->prepare('update COURSE set COURSE_NAME = ?, COURSE_BOOK = ? where COURSE_ID = ?');
		$sql_update_student->bind_param("ssi", $new_course_name, $new_course_book, $id);
		$sql_update_student->execute();
		header('Location: courses.php');
	}
?>
</body>
</html>