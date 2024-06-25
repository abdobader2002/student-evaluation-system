<?php
session_start();
include ("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // checking empty fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($password)) {

        if (empty($firstname)) {
            $_SESSION['msg'] = "Firstname field is empty!";
            header('Location:sign-up.php');
        }

        if (empty($lastname)) {
            $_SESSION['msg'] = "Lastname field is empty!";
            header('Location:sign-up.php');
        }

        if (empty($email)) {
            $_SESSION['msg'] = "Email field is empty!";
            header('Location:sign-up.php');
        }

        if (empty($username)) {
            $_SESSION['msg'] = "Username field is empty!";
            header('Location:sign-up.php');
        }

        if (empty($password)) {
            $_SESSION['msg'] = "Password field is empty!";
            header('Location:sign-up.php');
        }
    } else {
        //updating the table
        $query = "INSERT INTO students (first_name, last_name, email, username, password) 
                VALUES ('$firstname','$lastname','$email','$username','$password')";

        $result = mysqli_query($dbconn, $query);

        if ($result) {
            //redirecting to the display page. In our case, it is index.php
            header("sign-in: index.php");
        }

    }
}
?>