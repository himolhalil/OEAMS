<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CLASSES</title>
	<?php include('../utilities/utilities.php'); ?>
	<?php include('../utilities/nav.php'); ?>
</head>

<body>
	<h1>Classes</h1>
	<button class="btn btn-primary mx-2" onClick="addClassTo('shown-pop-up', document.getElementById('addClassForm'))">Add Class</button>
	<form  class="pop-up-form hidden-pop-up" id="addClassForm" method="POST" action="classes.php">
		<label for="course_id">Choose The Course Name</label>
		<select name="course_id" id="course_id" class="form-select">
			<?php
				$sql_select_courses = $conn->prepare("SELECT COURSE_ID, COURSE_NAME FROM COURSE");
				$sql_select_courses->execute();
				$courses_data = $sql_select_courses->get_result();
				echo "<option selected>-- Choose The Course Name -- </option>";
				while ($course = $courses_data->fetch_assoc()){
					echo "<option value='$course[COURSE_ID]'>$course[COURSE_NAME]</option>";
				}
			?>
		</select>


		<label for="term_id">Choose The Term</label>
		<select name="term_id" id="term_id" class="form-select">
			<?php
				$sql_select_terms = $conn->prepare("SELECT TERM_ID, TERM_START, TERM_END FROM TERM");
				$sql_select_terms->execute();
				$courses_data = $sql_select_terms->get_result();
				echo "<option selected>-- Choose The Term ID -- </option>";
				while ($term = $courses_data->fetch_assoc()){
					echo "<option value='$term[TERM_ID]'> TERM ($term[TERM_ID]), From: " . substr($term['TERM_START'], 0, 10) . " To: " . substr($term['TERM_END'], 0, 10) . "</option>";
				}
			?>
		</select>

		<label for="teacher_id">Choose The Teacher</label>
		<select name="teacher_id" id="teacher_id" class="form-select">
			<?php
				$sql_select_teacher = $conn->prepare("SELECT TEACHER_ID, FIRST_NAME, LAST_NAME, PHONE_NUMBER FROM TEACHER");
				$sql_select_teacher->execute();
				$teachers_data = $sql_select_teacher->get_result();
				echo "<option selected>-- Choose The Teacher -- </option>";
				while ($teacher = $teachers_data->fetch_assoc()){
					echo "<option value='$teacher[TEACHER_ID]'>$teacher[FIRST_NAME] $teacher[LAST_NAME] ($teacher[PHONE_NUMBER])</option>";
				}
			?>
		</select>

		<div class="buttons">
			<button class="btn btn-success" type="submit">Add</button>
			<button type="button" class="btn btn-danger" onClick="removeClassFrom('shown-pop-up', document.getElementById('addClassForm'))">Cancel</button>
		</div>
	</form>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
				$course_id = filter_var($_POST["course_id"], FILTER_SANITIZE_NUMBER_INT);
				$term_id = filter_var($_POST["term_id"], FILTER_SANITIZE_NUMBER_INT);
				$teacher_id = filter_var($_POST["teacher_id"], FILTER_SANITIZE_NUMBER_INT);
	
				if($conn->connect_error){
					die("Failed Connection") . $conn->connect_error;
				}

				$sql_insert_class = $conn->prepare("INSERT INTO CLASS(COURSE_ID, TERM_ID, TEACHER_ID) values (?, ?, ?)");
				if($sql_insert_class){
					$sql_insert_class->bind_param(
						"iii", 
						$course_id,
						$term_id,
						$teacher_id
					);
					$sql_insert_class->execute();
					header("Location: classes.php?success=1");
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
				<th>Class ID</th>
				<th>Course Name</th>
				<th>Term</th>
				<th>Teacher</th>
				<th>Actions</th>
			</tr>

			<?php
				$sql_select_classes = $conn->prepare("SELECT * FROM CLASS natural join COURSE natural join TEACHER natural join TERM");
				$sql_select_classes->execute();
				$classes_data = $sql_select_classes->get_result();
				while($class = $classes_data->fetch_assoc()){
					echo "<tr>";
						echo "<td>" . $class["CLASS_ID"] . "</td>";
						echo "<td>" . $class["COURSE_NAME"] . "</td>";
						echo "<td>" . "($class[TERM_ID]) " . substr($class["TERM_START"], 0, 10) . " / " . substr($class["TERM_END"], 0, 10) . "</td>";
						echo "<td>" . "$class[FIRST_NAME] $class[LAST_NAME]" . "</td>";
						echo "<td>
							<a href='./edit_class.php?id=$class[CLASS_ID]'><button class='btn btn-secondary'>Edit</button></a>
						</td>";
					echo "<tr/>";
				}
			?>
		</table>
</body>
</html>