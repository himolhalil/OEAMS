<?php
	include("../utilities/auth.php");
	go_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Statistics</title>
    <?php include('../utilities/utilities.php'); ?>
    <script src="../js/chart.js"></script>
</head>
<body>

    <?php
    $start_term = isset($_POST['start_term']) ? (int) $_POST ['start_term']: 1;
    $end_term = isset($_POST['end_term']) ? (int) $_POST ['end_term']: 5;
    $sql_enrl = $conn->prepare("SELECT TERM.TERM_ID, COUNT(REGISTRATION.REGISTRATION_ID ) AS std_count FROM TERM
        LEFT JOIN CLASS ON TERM.TERM_ID = CLASS.TERM_ID
        LEFT JOIN REGISTRATION ON CLASS.CLASS_ID = REGISTRATION.CLASS_ID
        WHERE TERM.TERM_ID BETWEEN ? AND ?
        GROUP BY TERM.TERM_ID
        ORDER BY TERM.TERM_ID ASC
    ");
    $sql_enrl->bind_param("ii", $start_term , $end_term);
    $sql_enrl->execute();
    $enrl_res = $sql_enrl->get_result();

    $t_labels = [];
    $enrl_data = [];

    while($row = $enrl_res->fetch_assoc()){
        $t_labels[] = "Term " . $row['TERM_ID'];
        $enrl_data[] = $row['std_count'];
    }
    ?>
    <div style="display: flex; gap: 20px; justify-content: center; align-items: center; min-height: 100vh;">
    <div style="width: 45%; margin: 100px auto;">
         <form method="POST" action="" style="margin-bottom: 15px;">
         <label for="start_term">form the term</label>
         <input class="form-control" type="number" id="start_term" name="start_term" min="1" value="<?php echo htmlspecialchars($start_term);?>"style="width: 60px;">

         <label for="end_term">to the term</label>
         <input class="form-control" type="number" id="end_term" name="end_term" min="1" value="<?php echo htmlspecialchars($end_term);?>"style="width: 60px;">
         <button class="btn btn-primary mt-2" type="submit">Range display</button></form> 
        <h1>Enrollment Growth per Term</h1>
        <canvas id="enrlChart"></canvas>
    </div>

    <script>
    const enrlCtx = document.getElementById('enrlChart').getContext('2d');
    const enrlChart = new Chart(enrlCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($t_labels); ?>,
            datasets: [{
                label: 'Number of Students',
                data: <?php echo json_encode($enrl_data); ?>,
                fill: true,
                backgroundColor: 'rgba(88, 3, 122, 0.1)',
                borderColor: '#58037a',
                borderWidth: 3,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#58037a'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    </script>

    <?php
     $term_id_filter = isset($_POST["term_id"]) ? (int)$_POST["term_id"]: 1;
    $sql_top = $conn->prepare("SELECT STUDENT.FIRST_NAME, (IFNULL(REGISTRATION.PARTICIPATION_MARK, 0) + IFNULL(REGISTRATION.ATTENDANCE_MARK, 0)
     + IFNULL(REGISTRATION.MID_EXAM_MARK, 0) + IFNULL(REGISTRATION.HOMEWORKS_MARK, 0) + IFNULL(REGISTRATION.ACTIVITES_MARK, 0) 
     + IFNULL(REGISTRATION.FINAL_EXAM_MARK, 0)) AS total
        FROM REGISTRATION 
        JOIN STUDENT ON REGISTRATION.STUDENT_ID = STUDENT.STUDENT_ID
        JOIN CLASS ON REGISTRATION.CLASS_ID = CLASS.CLASS_ID WHERE CLASS.TERM_ID = ? 
        ORDER BY total DESC 
        LIMIT 5
    ");
    $sql_top->bind_param("i" , $term_id_filter);

    $sql_top->execute();
    $top_res = $sql_top->get_result();

    $std_names = [];
    $std_scores = [];

    while($row = $top_res->fetch_assoc()){
        $std_names[] = $row['FIRST_NAME'];
        $std_scores[] = $row['total'];
    }
    ?>
    <div style="width: 45%; margin: auto;">
        <form method="POST" action="">
         <label for="term_input">select term</label>
         <input  class="form-control" type="number" id="term_input" name="term_id" min="1" value="<?php echo htmlspecialchars($term_id_filter);?>">
         <button class="btn btn-primary mt-2" type="submit">First Show</button></form>    
        <h2>Top 5 Students Performing thes term <?php echo htmlspecialchars($term_id_filter);?></h2>
        <canvas id="topStdChart"></canvas>
    </div>
    </div>
    
    <script>
    const topCtx = document.getElementById('topStdChart').getContext('2d');
    const topChart = new Chart(topCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($std_names); ?>,
            datasets: [{
                label: 'Total Score',
                data: <?php echo json_encode($std_scores); ?>,
                backgroundColor: '#58037a',
                borderColor: '#58037a',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>

</body>
</html>
