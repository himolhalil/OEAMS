<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TERMS</title>
	<?php include('../utilities/utilities.php'); ?>
</head>

<body>
	<h1>Terms</h1>
	<button class="btn btn-primary mx-2" onClick="addClassTo('shown-pop-up', document.getElementById('addTermForm'))">Add Term</button>
	<form  class="pop-up-form hidden-pop-up" id="addTermForm" method="POST" action="terms.php">
		<label for="term_start_date">Term Start</label>
		<input required id="term_start_date" class="form-control" type="date" name="term_start_date" placeholder="Term Start">

		<label for="term_end_date">Term End</label>
		<input id="term_end_date" class="form-control" type="date" name="term_end_date" placeholder="Term End">

		<div class="buttons">
			<button class="btn btn-success" type="submit">Add</button>
			<button type="button" class="btn btn-danger" onClick="removeClassFrom('shown-pop-up', document.getElementById('addTermForm'))">Cancel</button>
		</div>
	</form>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
				$term_start_date = is_valid($_POST["term_start_date"], 10);
				$term_end_date = is_valid($_POST["term_end_date"], 10);
				$diffrence_start_end_form_dates = (strtotime($term["$term_end_date"]) - strtotime($term["$term_start_date"]));
				if ($diffrence_start_end_form_dates < 0) {
					die("<p class='alert alert-danger w-75 mx-auto my-4'>End Should be later than the start</p>");
				}

				if (!($term_start_date && $term_end_date)) {
					die("<p class='alert alert-dangr w-75 mx-auto my-4'>Your data is too long</p>");
				} 
	
				if($conn->connect_error){
					die("Failed Connection") . $conn->connect_error;
				}

				$sql_insert_term = $conn->prepare("INSERT INTO TERM(TERM_START, TERM_END) values (?, ?)");
				if($sql_insert_term){
					$sql_insert_term->bind_param(
						"ss", 
						$term_start_date,
						$term_end_date
					);
					$sql_insert_term->execute();
					header("Location: terms.php?success=1");
				}
				 else {
					die("<p class='alert alert-danger w-75 mx-auto my-4'>Your data is corrupted</p>");
				}
			} else {
				// GET Request 
				if(isset($_GET["success"])){
					echo ("<p class='alert alert-success w-75 mx-auto my-4'>The Term Was Added Successfully </p>");
				}
			}
		?>


		<!--  start Showing the data -->
		<table>
			<tr>
				<th>ID</th>
				<th>Term Start</th>
				<th>Term End</th>
				<th>Term Length</th>
				<th>Actions</th>
			</tr>

			<?php
				$sql_select_terms = $conn->prepare("SELECT * FROM TERM");
				$sql_select_terms->execute();
				$terms_data = $sql_select_terms->get_result();
				while($term = $terms_data->fetch_assoc()){
					$diffrence_start_end_query_dates = (strtotime($term["TERM_END"]) - strtotime($term["TERM_START"])) / 60 / 60 / 24;
					echo "<tr>";
						echo "<td>" . $term["TERM_ID"] . "</td>";
						echo "<td>" . substr($term["TERM_START"], 0, 10) . "</td>";
						echo "<td>" . substr($term["TERM_END"], 0, 10) . "</td>";
						echo "<td>" . "$diffrence_start_end_query_dates days" . "</td>";
						echo "<td>
							<a href='./edit_term.php?id=$term[TERM_ID]'><button class='btn btn-secondary'>Edit</button></a>
						</td>";
					echo "<tr/>";
				}
			?>
		</table>
</body>
</html>