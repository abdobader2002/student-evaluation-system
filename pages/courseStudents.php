<?php
session_start();
include('config.php');

// Check if teacher session is set
if (isset($_SESSION['tid'])) {
    // Fetch course_id from GET parameters
    $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : 0;

    // Initialize arrays to store student data and quiz scores
    $students = [];
    $quiz_scores = [];

    // Fetch students and their scores for quizzes in the given course
    $sql = "SELECT students.student_id, students.first_name, students.last_name, students.email,
                   studentquizzes.quiz_id, studentquizzes.score
            FROM students
            LEFT JOIN studentquizzes ON students.student_id = studentquizzes.student_id
            LEFT JOIN quizzes ON studentquizzes.quiz_id = quizzes.quiz_id
            WHERE quizzes.course_id = '$course_id'
            ORDER BY students.student_id, studentquizzes.quiz_id";
    $result = $dbconn->query($sql);

    // Organize the data by student and quiz
    while ($row = $result->fetch_assoc()) {
        $student_id = $row['student_id'];
        $quiz_id = $row['quiz_id'];
        $score = $row['score'];

        // Populate students array if not already exists
        if (!isset($students[$student_id])) {
            $students[$student_id] = [
                'student_id' => $student_id,
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'quiz_scores' => []
            ];
        }

        // Populate quiz_scores array
        if (!isset($quiz_scores[$quiz_id])) {
            $quiz_scores[$quiz_id] = [
                'quiz_id' => $quiz_id,
                'quiz_name' => '', // Populate quiz names later
                'score_counts' => []
            ];
        }

        // Store score for each student and quiz
        $students[$student_id]['quiz_scores'][$quiz_id] = $score;

        // Count score occurrences for each quiz
        if (!isset($quiz_scores[$quiz_id]['score_counts'][$score])) {
            $quiz_scores[$quiz_id]['score_counts'][$score] = 0;
        }
        $quiz_scores[$quiz_id]['score_counts'][$score]++;
    }

    // Fetch quiz names for the course
    $quiz_names = [];
    $sql_quizzes = "SELECT quiz_id, quiz_name FROM quizzes WHERE course_id = '$course_id'";
    $result_quizzes = $dbconn->query($sql_quizzes);
    while ($row_quizzes = $result_quizzes->fetch_assoc()) {
        $quiz_names[$row_quizzes['quiz_id']] = $row_quizzes['quiz_name'];
    }

    // Fetch quiz IDs for the course to ensure all columns are present
    $quiz_ids = [];
    $sql_quizzes = "SELECT quiz_id FROM quizzes WHERE course_id = '$course_id'";
    $result_quizzes = $dbconn->query($sql_quizzes);
    while ($row_quizzes = $result_quizzes->fetch_assoc()) {
        $quiz_ids[] = $row_quizzes['quiz_id'];
    }
    $sql2 = "SELECT * FROM courses WHERE course_id = " . $_GET['course_id'];
    $result2 = mysqli_query($dbconn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Students
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <!-- Buttons extension CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <!-- Buttons extension JS -->
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
  <!-- JSZip for Excel -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <!-- pdfmake for PDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <!-- Buttons for HTML5 export -->
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="index.php" target="_blank">
        <span class="ms-1 font-weight-bold">Evaluation System</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="myCourses.php">
            <div
              class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-house fs-6"></i>
            </div>
            <span class="nav-link-text ms-1">Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="myCourses.php">
            <div
              class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-book fs-6"></i>
            </div>
            <span class="nav-link-text ms-1">My Courses</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="courseQuestBank.php">
            <div
              class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-box-archive fs-6"></i>
            </div>
            <span class="nav-link-text ms-1">Question Bank</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="courseQuizCreate.php">
            <div
              class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-user-graduate fs-6"></i>
            </div>
            <span class="nav-link-text ms-1">Create Exam</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="topics.php">
            <div
              class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-user-tie fs-6"></i>
            </div>
            <span class="nav-link-text ms-1">Topics</span>
          </a>
        </li>
      </ul>
    </div>

  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <nav class="navbar navbar-main navbar-expand-lg bg-transparent shadow-none position-absolute px-4 w-100 z-index-2">
      <div class="container-fluid pt-4 pb-2">

        <div class="collapse navbar-collapse me-md-0 me-sm-4 mt-sm-0 mt-2" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">

          </div>
          <ul class="navbar-nav justify-content-end">

            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?php
                if (isset($_SESSION['StudentName'])) {
                  echo $_SESSION['StudentName'];
                }
                ?>
                </span></span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 pe-0 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                  </div>
                </a>
              </a>
            </li>

            <li class="nav-item dropdown px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa fa-cog cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end px-2 py-3 ms-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1 text-danger">
                          Logout
                        </h6>

                      </div>
                    </div>
                  </a>
                </li>

              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="page-header border-radius-xl mt-4"
        style="min-height: 230px !important;background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto my-auto px-4">
            <div class="h-100">
              <h5 class="mb-1">
                <?php echo $row2['course_name'] ?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                Home / Students
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="container-fluid py-4">

      <div class="row my-4">
        <div class="col-lg-11 mx-auto mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6><i class="fa fa-check text-info" aria-hidden="true"></i> Students</h6>

                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
        <canvas id="quizChart" width="800" height="400"></canvas>

    <div class="table-responsive px-3">
        <table id="example"  class="display" style="width:100%">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <?php foreach ($quiz_ids as $quiz_id) { ?>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Quiz <?php echo $quiz_id; ?>
                        </th>
                    <?php } ?>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Series
                    </th>
                    <th class="text-secondary opacity-7"></th>
                </tr>
            </thead>
            <tbody>
              
            <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                    <?php foreach ($quiz_ids as $quiz_id) { ?>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <button class="btn btn-sm btn-primary show-chart-btn"
                                data-quiz-id="<?php echo $quiz_id; ?>">Chart</button>
                        </th>
                    <?php } ?>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    </th>
                    <th class="text-secondary opacity-7"></th>
                </tr>
                <?php if (!empty($students)) {
                    foreach ($students as $student) { ?>
                        <tr>
                            <td>
                                <p class="mb-0 text-sm ps-3">#2024-<?php echo $student['student_id']; ?></p>
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm"><?php echo $student['first_name'] . " " . $student['last_name']; ?>
                                </h6>
                                <p class="mb-0 text-sm ps-3"><?php echo $student['email']; ?></p>
                            </td>
                            <?php foreach ($quiz_ids as $quiz_id) { ?>
                                <td class="align-middle text-center text-sm">
                                    <span
                                        class="text-xs font-weight-bold"><?php echo isset($student['quiz_scores'][$quiz_id]) ? $student['quiz_scores'][$quiz_id] : '-'; ?></span>
                                </td>
                            <?php } ?>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">2024-2025</span>
                            </td>
                            <td class="align-middle">
                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                    data-original-title="Edit user">
                                    Delete
                                </a>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
</div>
          </div>
        </div>

      </div>
      
    </div>
  </main>

  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
          {
            extend: 'excelHtml5',
            title: 'Data export'
          },
          {
            extend: 'pdfHtml5',
            title: 'Data export'
          }
        ]
      });
    });
  </script>
  <!-- Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Encode PHP variables to JavaScript
    var quizScores = <?php echo json_encode(array_values($quiz_scores)); ?>;
    var quizNames = <?php echo json_encode($quiz_names); ?>;

    // Log data to verify
    console.log(quizScores);
    console.log(quizNames);

    var quizChart;

// Function to create or update chart
function createChart(quizId, quizName, scoreCounts) {
    var ctx = document.getElementById('quizChart');

    // Check if chart instance exists
    if (quizChart) {
        // Update chart data
        quizChart.data.labels = Object.keys(scoreCounts).map(String);
        quizChart.data.datasets[0].label = 'Score Distribution for ' + quizName;
        quizChart.data.datasets[0].data = Object.values(scoreCounts);
        quizChart.update(); // Update the chart
    } else {
        // Create new chart instance
        quizChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(scoreCounts).map(String),
                datasets: [{
                    label: 'Score Distribution for ' + quizName,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Example color
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    data: Object.values(scoreCounts)
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                }
            }
        });
    }
}

    // Attach click event listener to each chart button
    document.addEventListener('DOMContentLoaded', function() {
        var chartButtons = document.querySelectorAll('.show-chart-btn');

        chartButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var quizId = this.getAttribute('data-quiz-id');
                var quizName = quizNames[quizId];
                var scoreCounts = quizScores[quizId].score_counts;

                // Remove existing chart if exists
                var existingChart = document.getElementById('chart-' + quizId);
                if (existingChart) {
                    existingChart.parentNode.removeChild(existingChart);
                }

                // Create new chart
                createChart(quizId, quizName, scoreCounts);
            });
        });
    });
</script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>