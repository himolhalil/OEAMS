<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Students</title>
	<link rel="stylesheet" href="bootstrap.css">
	<link rel="stylesheet" href="style.css">
</head>
<?php
	include('utilities.php');
?>

<body>
	<h1>Students</h1>
	<button class="btn btn-primary mx-2" onClick="addClassTo('shown-pop-up', document.getElementById('addStudentForm'))">Add Student</button>
	<form  class="pop-up-form hidden-pop-up" id="addStudentForm" method="POST" action="">
		<input required class="form-control" type="text" name="student_first_name" placeholder="First Name">
		<input class="form-control" type="text" name="student_middle_names" placeholder="Middle Names">
		<input required class="form-control" type="text" name="student_last_name" placeholder="Last Name">
		<input required class="form-control" type="text" name="student_phone_number" placeholder="Phone Number">
		<div class="buttons">
			<button class="btn btn-success" type="submit">Add</button>
			<button type="button" class="btn btn-danger" onClick="removeClassFrom('shown-pop-up', document.getElementById('addStudentForm'))">Cancel</button>
		</div>
	</form>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
				$student_first_name = is_valid($_POST["student_first_name"], 20);
				$student_middle_names = is_valid($_POST["student_middle_names"], 100);
				$student_last_name = is_valid($_POST["student_last_name"], 20);
				$sanitized_phone_number = filter_var($_POST["student_phone_number"], FILTER_SANITIZE_NUMBER_INT);
				$student_phone_number = is_valid($sanitized_phone_number, 25);

				if (!($student_first_name && $student_middle_names && $student_last_name && $student_phone_number)) {
					die("<p class='alert alert-danger w-75 mx-auto my-4'>Your data is too long</p>");
				} 
	
				if($conn->connect_error){
					die("Failed Connection") . $conn->connect_error;
				}

				$sql_insert_student = $conn->prepare("INSERT INTO STUDENT(FIRST_NAME, MIDDLE_NAMES, LAST_NAME, PHONE_NUMBER, REGISTER_DATE) values (?, ?, ?, ?, NOW())");
				if($sql_insert_student){
					$sql_insert_student->bind_param(
						"ssss", 
						$student_first_name,
						$student_middle_names,
						$student_last_name,
						$student_phone_number
					);
					$sql_insert_student->execute();
					echo ("<p class='alert alert-success w-75 mx-auto my-4'>The Student Was Added Successfully</p>");
				}
				 else {
					die("<p class='alert alert-danger w-75 mx-auto my-4'>Your data is corrupter</p>");
				}
			}
		?>



<script src="bootstrap.js"></script>
<script src="script.js"></script>
</body>
</html>