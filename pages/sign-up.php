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
    Sign Up
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />

  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="">

  <main class="main-content  mt-0">
    <section class="min-vh-100 mb-8">
      <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="background-image: url('../assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
              <h1 class="text-white mb-0 mt-4">Welcome!</h1>
              <!-- <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p> -->
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
          <div class="col-xl-6 col-lg-8 col-md-10 mx-auto">
            <div class="card z-index-0">
              <div class="card-header text-center pt-4">
                <h5>Create Account</h5>
              </div>

              <div class="card-body">
                <form role="form text-left" class="form" method="post" action="registration.php">
                  <div class="row">
                    <div class="col-12 col-md-6">
                      <div class="mb-3">
                        <input type="text" class="form-control" name="firstname" placeholder="First Name"
                          aria-label="First Name" aria-describedby="">
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="mb-3">
                        <input type="text" class="form-control" name="lastname" placeholder="Last Name"
                          aria-label="Last Name" aria-describedby="">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email"
                          aria-describedby="email-addon">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <input type="text" class="form-control" name="username" placeholder="User Name"
                          aria-label="User Name" aria-describedby="">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password"
                          aria-label="Password" aria-describedby="password-addon">
                      </div>
                    </div>
                    <!-- <div class="col-12 col-md-6">
                      <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password" aria-describedby="password-addon">
                      </div>
                    </div> -->
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                  </div>
                  <p class="text-sm mt-3 mb-0 text-center">Already have an account? <a href="sign-in.php"
                      class="text-dark font-weight-bolder">Sign in</a></p>
                </form>
                <br><br>
                  <?php
                  if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                  }
                  ?>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>