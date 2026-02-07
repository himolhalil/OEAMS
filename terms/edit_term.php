<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Term </title>
	<?php include('../utilities/utilities.php'); ?>
</head>
<body>
<?php

	if (!isset($_GET['id'])) die("You Must Specify A Term");

		$id = $_GET['id'];

		$sql_select_term = $conn->prepare("SELECT * FROM TERM WHERE TERM_ID = ?");
		$sql_select_term->bind_param("i", $id);
		$sql_select_term->execute();

		$term = $sql_select_term -> get_result() -> fetch_assoc();

		if(!$term){
			die("<p class='alert alert-danger w-75 mx-auto my-4'>This Term Doesn't Exist</p>");
		}



		$term_id =  $term["TERM_ID"];
		$term_start = substr($term["TERM_START"], 0, 10);
		$term_end = substr($term["TERM_END"], 0, 10);

		echo "
			<form  class='pop-up-form' id='addTermForm' method='POST' action='edit_term.php?id=$id'>
				<label for='term_start_date'>Term Start</label>
				<input required id='term_start_date' class='form-control' type='date' name='term_start_date' placeholder='Term Start' value='$term_start'>

				<label for='term_end_date'>Term End</label>
				<input id='term_end_date' class='form-control' type='date' name='term_end_date' placeholder='Term End' value='$term_end'>

				<div>
					<button class='btn btn-warning' type='submit'>Edit</button>
					<a href='./terms.php'><button type='button' class='btn btn-danger'>Cancel</button></a>
				</div>
			</form>
		";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$new_start_date =  $_POST["term_start_date"];
		$new_end_date =  $_POST["term_end_date"];
		$diffrence_new_start_new_end_dates = (strtotime($new_end_date) - strtotime($new_start_date));

		if ($diffrence_new_start_new_end_dates < 0) {
			die("<p class='alert alert-danger w-75 mx-auto my-4'>End Should be later than the start</p>");
		}

		$sql_update_term = $conn->prepare('update TERM set TERM_START = ?, TERM_END = ? where TERM_ID = ?');
		$sql_update_term->bind_param("ssi", $new_start_date, $new_end_date, $id);
		$sql_update_term->execute();
		header('Location: terms.php');
	}
?>
</body>
</html>