<?php
	include("../utilities/auth.php");
	go_login();
?>
<?php
	header("Content-Type: application/json");
	include('../utilities/db.php');
	if($_SERVER["REQUEST_METHOD"] !== "POST"){
		die();
	}

	$map_column_name = [
		'attendance' => 'ATTENDANCE_MARK',
		'activites' => 'ACTIVITES_MARK',
		'homeworks' => 'HOMEWORKS_MARK',
		'mid_exam' =>  'MID_EXAM_MARK' ,
		'final_exam' => 'FINAL_EXAM_MARK',
		'comment' => 'TEACHER_COMMENT'
	];

	$map_column_max = [
		'attendance' => 50,
		'activites' => 10,
		'homeworks' => 10,
		'mid_exam' =>  10,
		'final_exam' => 20,
	];

	$raw = file_get_contents("php://input");
	$body = json_decode($raw, true);

	$column =  "$body[column]";
	$row =  "$body[row]";
	if($column !== "comment"){
		$new_value =  (int)("$body[new_value]");
		if($new_value == 0){
			echo json_encode(["message" => "Value must be a number", "code" => 403]);
			die();
		} else if ($new_value < 0){
			echo json_encode([ "message" => "Not Updated Min Value is 0", "code" => 403]);
			die();
		} else if ($new_value > $map_column_max[$column]){
			echo json_encode([ "message" => "Not Updated Max Value is $map_column_max[$column]", "code" => 403]);
			die();
		}
	}

	$new_value =  htmlspecialchars("$body[new_value]");
	$sql_update = $conn->prepare("UPDATE REGISTRATION SET $map_column_name[$column] = '$new_value' where REGISTRATION_ID = $row");
	$sql_update->execute();
	echo json_encode([ "message" => "Updated to $new_value Successfully", "code" => 200]);
?>