<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>COURSES</title>
	<?php include('../utilities/utilities.php'); ?>
</head>

<body>
	<h1>Courses</h1>
	<button class="btn btn-primary mx-2" onClick="addClassTo('shown-pop-up', document.getElementById('addCourseForm'))">Add Course</button>
	<form  class="pop-up-form hidden-pop-up" id="addCourseForm" method="POST" action="courses.php">
		<input required class="form-control" type="text" name="course_name" placeholder="Course Name">
		<input class="form-control" type="text" name="course_book" placeholder="Course Book">
		<div class="buttons">
			<button class="btn btn-success" type="submit">Add</button>
			<button type="button" class="btn btn-danger" onClick="removeClassFrom('shown-pop-up', document.getElementById('addCourseForm'))">Cancel</button>
		</div>
	</form>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
				$course_name = is_valid($_POST["course_name"], 250);
				$course_book = is_valid($_POST["course_book"], 250);

				if (!($course_name && $course_book)) {
					die("<p class='alert alert-dangr w-75 mx-auto my-4'>Your data is too long</p>");
				} 
	
				if($conn->connect_error){
					die("Failed Connection") . $conn->connect_error;
				}

				$sql_insert_course = $conn->prepare("INSERT INTO COURSE(COURSE_NAME, COURSE_BOOK) values (?, ?)");
				if($sql_insert_course){
					$sql_insert_course->bind_param(
						"ss", 
						$course_name,
						$course_book
					);
					$sql_insert_course->execute();
					header("Location: courses.php?success=1");
				}
				 else {
					die("<p class='alert alert-danger w-75 mx-auto my-4'>Your data is corrupted</p>");
				}
			} else {
				// GET Request 
				if(isset($_GET["success"])){
					echo ("<p class='alert alert-success w-75 mx-auto my-4'>The Course Was Added Successfully </p>");
				}
			}
		?>


		<!--  start Showing the data -->
		<table>
			<tr>
				<th>ID</th>
				<th>Course Name</th>
				<th>Course Book</th>
				<th>Actions</th>
			</tr>

			<?php
				$sql_select_courses = $conn->prepare("SELECT * FROM COURSE");
				$sql_select_courses->execute();
				$courses_data = $sql_select_courses->get_result();
				while($course = $courses_data->fetch_assoc()){
					echo "<tr>";
						echo "<td>" . $course["COURSE_ID"] . "</td>";
						echo "<td>" . $course["COURSE_NAME"] . "</td>";
						echo "<td>" . $course["COURSE_BOOK"] . "</td>";
						echo "<td>
							<a href='./edit_course.php?id=$course[COURSE_ID]'><button class='btn btn-secondary'>Edit</button></a>
						</td>";
					echo "<tr/>";
				}
			?>
		</table>
</body>
</html>