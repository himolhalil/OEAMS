<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration Marks</title>
	<?php include('../utilities/utilities.php'); ?>
</head>

<body>
	<?php include('../utilities/nav.php'); ?>
	<h1>Registration Marks</h1>
	<!--  start Showing the data -->
	<table>
		<tr>
			<th>Student ID</th>
			<th>Student name</th>
			<th>Term</th>
			<th>Course name</th>
			<th>Teacher name</th>
			<th>Price</th>
			<th>Paid</th>
		</tr>

		<?php
			$sql_select_registrations = $conn->prepare("
				SELECT
					STUDENT.FIRST_NAME,
					STUDENT.LAST_NAME,
					STUDENT.MIDDLE_NAMES,
					STUDENT.STUDENT_ID,
					CLASS.TERM_ID,
					COURSE.COURSE_NAME,
					TEACHER.FIRST_NAME as TFIRST_NAME,
					TEACHER.MIDDLE_NAMES as TMIDDLE_NAMES,
					TEACHER.LAST_NAME as TLAST_NAME,
					PRICE,
					PAID,
					REGISTRATION_ID
					FROM 
					REGISTRATION
						INNER JOIN STUDENT on REGISTRATION.STUDENT_ID = STUDENT.STUDENT_ID
						INNER JOIN CLASS on REGISTRATION.CLASS_ID = CLASS.CLASS_ID
						INNER JOIN TEACHER on CLASS.TEACHER_ID = TEACHER.TEACHER_ID
						INNER JOIN COURSE on CLASS.COURSE_ID = COURSE.COURSE_ID
			");
			$sql_select_registrations->execute();
			$registrations_data = $sql_select_registrations->get_result();
			while($registration = $registrations_data->fetch_assoc()){
				$student_full_name = $registration["FIRST_NAME"]. " " . $registration["MIDDLE_NAMES"] . " " . $registration["LAST_NAME"];
				$teacher_full_name = $registration["TFIRST_NAME"]. " " . $registration["TMIDDLE_NAMES"] . " " . $registration["TLAST_NAME"];
				echo "<tr data-id='$registration[REGISTRATION_ID]'>";
					echo "<td>" . $registration["STUDENT_ID"] . "</td>";
					echo "<td>" . $student_full_name . "</td>";
					echo "<td> $registration[TERM_ID] </td>";
					echo "<td> $registration[COURSE_NAME] </td>";
					echo "<td>" . $teacher_full_name . "</td>";
					echo "<td data-column='price' class='editable-ajax-input-fees'>$registration[PRICE] </td>";
					echo "<td data-column='paid' class='editable-ajax-input-fees'>$registration[PAID] </td>";
				echo "<tr/>";
			}

		?>
</table>
</body>
</html>;