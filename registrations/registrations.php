<?php
	include("../utilities/auth.php");
	go_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration</title>
	<?php include('../utilities/utilities.php'); ?>
</head>

<body>
	<h1>Registration</h1>
	<!--  start Showing the data -->
	<table>
		<tr>
			<th>STUDENT ID</th>
			<th>Student Name</th>
			<th>TERM</th>
		</tr>

		<?php
			$sql_select_registrations = $conn->prepare("SELECT STUDENT_ID, FIRST_NAME, MIDDLE_NAMES, LAST_NAME, TERM_ID FROM REGISTRATION natural join STUDENT natural join CLASS");
			$sql_select_registrations->execute();
			$registrations_data = $sql_select_registrations->get_result();
			while($registration = $registrations_data->fetch_assoc()){
				$student_full_name = $registration["FIRST_NAME"]. " " . $registration["MIDDLE_NAMES"] . " " . $registration["LAST_NAME"];
				echo "<tr>";
					echo "<td>" . $registration["STUDENT_ID"] . "</td>";
					echo "<td>" . $student_full_name . "</td>";
					echo "<td> $registration[TERM_ID] </td>";
				echo "<tr/>";
			}
		?>
	</table>
</body>
</html>