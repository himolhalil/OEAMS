<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration</title>
	<?php include_once("../utilities/utilities.php"); ?>
	<?php include_once("./get_students.php"); ?>
	<?php ?>
</head>

<body>
	<?php include('../utilities/nav.php'); ?>
	<h1>Add Registration</h1>
	<div class="inputs-search-container d-flex">
		<div>
			<label for="searchId">Search By ID</label>
			<input class="form-control" id="searchId" name="search_id" type="number" onInput="fetchStudents()">
		</div>
		<div>
			<label for="searchName">Search By Name</label>
			<input class="form-control"  type="text" name="search_name" id="searchName" onInput="fetchStudents()">
		</div>
		<div>
			<label for="searchPhone">Search By Phone Number</label>
			<input class="form-control"  type="text" id="searchPhone" name="search_phone" onInput="fetchStudents()">
		</div>
	</div>

	<script>
		let registration_details = {}
		function fetchStudents(){
			fetch("./get_students_ajax.php", {
				method: "POST",
				body: JSON.stringify({
					student_id: searchId.value,
					student_name: searchName.value,
					student_phone: searchPhone.value
				})
			})
			.then(response => response.json())
			.then(students => {
				let selectStudents = document.getElementById("students")
				selectStudents.innerHTML =  "<option>Choose ID</option>"
				// handle students here
				students.forEach(std => {
					let option = document.createElement("option")
					option.value = std.STUDENT_ID
					option.innerText = `${std.STUDENT_ID}-${std.FULL_NAME}(${std.PHONE_NUMBER})`
					selectStudents.append(option)

					registration_details.student_name = std.FULL_NAME
					registration_details.student_id = std.STUDENT_ID
					registration_details.student_phone = std.PHONE_NUMBER
				})
			});
		}
	</script>

	<select name="student_id" class="mt-3 form-control" id="students">
		echo "<option>Choose ID</option>";
	</select>
	<hr>

	<h2>Choose Class</h2>
	<label for="selectTerm">Choose The Term ID</label>
	<select name="term_id" id="selectTerm" class="form-control" onInput='fetchCourses()'>
		<option value="">Choose Term</option>
		<?php
			include_once("../models/get_terms.php"); 
			foreach ($terms = get_terms() as $term) {
				echo "<option>" . $term['TERM_ID'] . "</option>";
			}
		?>
	</select>

	<label for="selectCourse" class='mt-4'>Choose the course name</label>
	<select name="select_course" id="selectCourse" class="form-control" onInput="fetchClass()" >
			<option value="">Choose ID</option>
	</select>
	<label for="price" class="mt-4">Enter the price for the student</label>
	<input type="number" id="price" class="form-control" value="15000">

	<div class="alert alert-warning mt-4">
		<p class='w-50 m-0' id="addRegistration"></p>
	</div>
	<button class="btn btn-success" onClick="addRegistration()" id="addRegistrationButton">Add Student</button>
	<script>
		function fetchCourses(params) {
			fetch("./get_courses_ajax.php", {
				method: "POST",
				body: JSON.stringify({
					term_id: selectTerm.value,
				})
			})
			.then(response => response.json())
			.then(courses => {
				let selectCourses = document.getElementById("selectCourse")
				selectCourses.innerHTML =  "<option>Choose ID</option>"
				// handle students here
				courses.forEach(course => {
				 	let option = document.createElement("option")
				 	option.value = course.COURSE_ID
				 	option.innerText = `${course.COURSE_NAME}`
				 	selectCourse.append(option)
				 })
			});
		}

		function fetchClass(){
			fetch("./get_class_ajax.php", {
				method: "POST",
				body: JSON.stringify({
					course_id: selectCourse.value,
					term_id: selectTerm.value,
				})
			})
			.then(response => response.json())
			.then(_class => {
				registration_details.class_id = _class.CLASS_ID
				registration_details.course_name = _class.COURSE_NAME
				let message = `<h2>Are you sure you want to add this record: \n</h2>`;
				Object.entries(registration_details).forEach( entry => {
					console.log()
					message += `${entry[0]}: <strong>${entry[1]}</strong><br>`
				})
				document.getElementById("addRegistration").innerHTML = message;
			});
		}

	function addRegistration(){
		fetch("./add_registration_ajax.php", {
			method: "POST",
			body: JSON.stringify({...registration_details, price: (document.getElementById("price").value)})
		})
		.then(response => response.text())
		.then(data => { console.log(data) })
		.catch(error => {alert("There was an error, contact the site adminstration")})
	};

	</script>

</body>
</html>