<?php
session_start();
include ('config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Create Questions
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .text-gradient.text-primary {
      background-image: linear-gradient(310deg, #7928CA, #03A9F4)!important;
  }
  .btn-outline-primary {
      --bs-btn-color: #2196F3;
      --bs-btn-border-color: #2196F3;
      --bs-btn-hover-color: #fff;
      --bs-btn-hover-bg: #3F51B5;
      --bs-btn-hover-border-color: #3F51B5;
      --bs-btn-focus-shadow-rgb: 203, 12, 159;
      --bs-btn-active-color: #fff;
      --bs-btn-active-bg: #3F51B5;
      --bs-btn-active-border-color: #3F51B5;
      --bs-btn-active-shadow: none;
      --bs-btn-disabled-color: #3F51B5;
      --bs-btn-disabled-bg: transparent;
      --bs-btn-disabled-border-color: #3F51B5;
      --bs-gradient: none;
  }
  .btn-outline-primary:hover:not(.active) {
      background-color: transparent;
      opacity: .75;
      box-shadow: none;
      color: #3F51B5;
  }
  .form-control.py-2 {
    padding-top: 0.75rem !important;
    padding-bottom: 0.75rem !important;
}
  </style>
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
          <a class="nav-link " href="myCourses.php">
            <div
              class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-book fs-6"></i>
            </div>
            <span class="nav-link-text ms-1">My Courses</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="courseQuestBank.php">
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
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
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
                }else if (isset($_SESSION['teacherName'])) {
                  echo $_SESSION['teacherName'];
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
                  <a class="dropdown-item border-radius-md" href="logout.php">
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
      <div class="page-header border-radius-xl mt-4" style="min-height: 230px !important;background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto my-auto px-4">
            <div class="h-100">
              <h5 class="mb-1">
               Create Question
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                Home / Question Bank/Create Question
              </p>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row my-4">
        <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header pb-0 px-3 d-flex justify-content-between">
              <h6 class="mb-0">Create Question</h6>
            </div>
            <div class="card-body pt-4 p-3">
            <form role="form text-left">
                <div class="row mx-0">
                  <div class="col-12 col-md-4">
                    <div class="mb-3">
                      <select class="form-control form-control-lg form-select py-2">
                      <option value="0">Select Topic</option>
                            <?php
                            $sql3 = "SELECT * FROM topics";
                            $result3 = mysqli_query($dbconn, $sql3);
                            while ($row3 = mysqli_fetch_assoc($result3)) {
                              ?>
                              <option value="<?php echo $row3['topic_id'] ?>"><?php echo $row3['title'] ?></option>
                            <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <select class="form-control form-control-lg form-select py-2" id="questType">
                      <option value="0">Question Type</option>
                      <option value="1">True Or False</option>
                      <option value="2">MCQ</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="mb-3">
                      <select class="form-control form-control-lg form-select py-2">
                        <option value="0">Difficulty Level</option>
                        <option value="Topic 1">Easy</option>
                        <option value="Topic 2">Medium</option>
                        <option value="Topic 2">Hard</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-12">
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" placeholder="Question Text">
                    </div>
                  </div>
                  <div class="col-12 p-0" id="chooseQuestOptions">
                    <div class="mb-3 row mx-0">
                      <div class="col-4">
                        <input type="text" class="form-control form-control-lg" placeholder="MCQ Option">
                      </div>
                      <div class="col-4">
                        <input type="text" class="form-control form-control-lg" placeholder="MCQ Option">
                      </div>
                      <div class="col-4">
                        <input type="text" class="form-control form-control-lg" placeholder="MCQ Option">
                      </div>
                    </div>
                  </div>
                  <div class="col-12 ps-3" id="TFOptions">
                    <h6>Answer</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="trueOrFalse" id="true">
                      <label class="form-check-label" for="true">
                        True
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="trueOrFalse" id="false">
                      <label class="form-check-label" for="false">
                        False
                      </label>
                    </div>
                  </div>
                  <div class="col-12 col-md-9">
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" placeholder="Model Answer" id="modelAnswer">
                    </div>
                  </div>
                  <div class="col-12 col-md-3">
                    <div class="mb-3">
                    <button type="button" class="btn btn-lg bg-gradient-dark">Add Question</button>
                    </div>
                  </div>
                  
                </div>
              </form>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
   $('#TFOptions, #chooseQuestOptions').hide();
            $('#questType').on('change', function() {
              $('#modelAnswer').val('');
              var selectedValue = $(this).val();
              if (selectedValue == '1') {
                $('#chooseQuestOptions').hide();
                $('#TFOptions').show();
              $('#modelAnswer').attr('disabled', true);

              } else if (selectedValue == '2') {
                $('#chooseQuestOptions').show();
                $('#TFOptions').hide();
                $('#modelAnswer').attr('disabled', false);
              } else {
                $('#TFOptions, #chooseQuestOptions').hide();
              }
            });

            
        $('input[name="trueOrFalse"]').change(function() {
                var selectedText = $('label[for="' + $(this).attr('id') + '"]').text().trim();
                $('#modelAnswer').val(selectedText);
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