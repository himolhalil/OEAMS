<?php
	include("../utilities/auth.php");
	go_login();
?>
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

	if (!isset($_GET['id'])) die("You Must Specify a Course");

		$id = $_GET['id'];

		$sql_select_course = $conn->prepare("SELECT * FROM COURSE");
		$sql_select_course->execute();
		$courses = $sql_select_course->get_result();

		echo "<form  class='pop-up-form' method='POST' action='edit_class.php?id=$id'>
			<label for='course_id'>Choose The Course Name</label>
			<select class='form-select' name='course_id' id='course_id'> ";
				while ($course = $courses->fetch_assoc()){
					$class_course = $course["COURSE_ID"];
					echo " <option value='$class_course'>$course[COURSE_NAME]</option>";
				}
			echo "
				</select>
				<label for='term_id'>Choose The Term</label>
				<select class='form-select' name='term_id' id='term_id'>
			";

				$sql_select_term = $conn->prepare("SELECT * FROM TERM");
				$sql_select_term->execute();
				$terms = $sql_select_term->get_result();
				while ($term = $terms->fetch_assoc()){
					echo " <option>$term[TERM_ID]</option>";
				}

			echo "
				</select>
				<label for='teacher_id'>Choose The Teacher</label>
				<select class='form-select' name='teacher_id' id='teacher_id'>
			";

				$sql_select_teacher = $conn->prepare("SELECT * FROM TEACHER");
				$sql_select_teacher->execute();
				$teachers = $sql_select_teacher->get_result();
				while ($teacher = $teachers->fetch_assoc()){
					echo " <option value='$teacher[TEACHER_ID]'>$teacher[FIRST_NAME] $teacher[LAST_NAME]</option>";
				}
			echo 
			"<select/>
			<button class='btn btn-warning' type='submit'>Edit</button>
			<a href='./classes.php'><button type='button' class='btn btn-danger'>Cancel</button></a>
		</form>";
			
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$new_course_id =  $_POST["course_id"];
		$new_term_id =  $_POST["term_id"];
		$new_teacher_id =  $_POST["teacher_id"];
		$sql_update_class = $conn->prepare('update CLASS set COURSE_ID = ?, TERM_ID = ?, TEACHER_ID = ? where CLASS_ID = ?');
		$sql_update_class->bind_param("iiii",$new_course_id, $new_term_id, $new_teacher_id, $id);
		$sql_update_class->execute();
		header('Location: classes.php');
	}
?>
</body>
</html>