<?php
	include("../utilities/auth.php");
	go_login();
?>
<?php
	function get_students($id, $name, $phone){
		include("../utilities/db.php");
		$sql_get_students = $conn->prepare("
		SELECT 
		CONCAT(FIRST_NAME,' ', IFNULL(MIDDLE_NAMES, ''), ' ', LAST_NAME) AS FULL_NAME,
		PHONE_NUMBER,
		STUDENT_ID
			FROM STUDENT WHERE STUDENT_ID = ? OR CONCAT(FIRST_NAME,' ',
			IFNULL(MIDDLE_NAMES, ''), ' ', LAST_NAME) LIKE CONCAT('%', ?, '%')
			OR PHONE_NUMBER LIKE CONCAT('%', ?)
		 ");

		$sql_get_students->bind_param('iss', $id, $name, $phone);
		$sql_get_students->execute();
		$students_table = $sql_get_students->get_result();
		$students = [];

		while ($student = $students_table->fetch_assoc()) {
			$students[] = $student;
		}

		return $students;
	}
?>