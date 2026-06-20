<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "Login");

$name = $_POST['name'];
$email = $_POST['email'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE Email = ?");
mysqli_stmt_bind_param($stmt, "s", $_POST['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) > 0){
    echo"Error: Account already exist";
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

mysqli_stmt_close($stmt);

$insert = mysqli_prepare($conn, "INSERT INTO users (Name, Email, Password) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($insert,"sss", $name, $email, $pass);

if(mysqli_stmt_execute($insert)){
    header("location: Login.html");
    exit();
}else{
    echo"Error: Account cannot be created, please try later";
}

mysqli_stmt_close($insert);
mysqli_close($conn);
?>