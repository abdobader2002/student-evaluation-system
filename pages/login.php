<?php
session_start();
include ('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_unsafe = $_POST['email'];
    $pass_unsafe = $_POST['password'];

    $user = mysqli_real_escape_string($dbconn, $user_unsafe);
    $pass = mysqli_real_escape_string($dbconn, $pass_unsafe);

    $query = mysqli_query($dbconn, "SELECT * FROM `students` WHERE email='$user' AND password='$pass'");
    //$res = mysqli_fetch_array($query);

    if (mysqli_num_rows($query) < 1) {
        $query = mysqli_query($dbconn, "SELECT * FROM `teachers` WHERE email='$user' AND password='$pass'");
        if (mysqli_num_rows($query) < 1) {
            $_SESSION['msg'] = "Login Failed, Teacher not found!";
            header('Location:sign-in.php');
        } else {
            $res = mysqli_fetch_array($query);
            $_SESSION['tid'] = $res['teacher_id'];
            $_SESSION['teacherName'] = $res['first_name'] . " " . $res['last_name'];
            header('Location: myCourses.php');
        }
    } else {
        $res = mysqli_fetch_array($query);
        $_SESSION['sid'] = $res['student_id'];
        $_SESSION['StudentName'] = $res['first_name'] . " " . $res['last_name'];
        header('Location: index.php');


        // $remarks="(Administrator) has logged in the system at ";  
        // mysqli_query($dbconn,"INSERT INTO logs(user_id,action,date) VALUES('$id','$remarks','$date')")or die(mysqli_error($dbconn));
    }
}
?>