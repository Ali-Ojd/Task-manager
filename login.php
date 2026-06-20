<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "Login");

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE Email = ?");
mysqli_stmt_bind_param($stmt, "s", $_POST['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) > 0){

    $user = mysqli_fetch_assoc($result);
    
    if(password_verify($_POST['pass'], $user['Password'])){
        $_SESSION['name'] = $user['Name'];
        $_SESSION['email'] = $user['Email'];
        $_SESSION['id'] = $user['id'];
        header("location: home.php");
        exit();
    }else{
        echo"Password incorrect";
    }
    
}else{
    echo"Error: Account doesn't exist!";
}
?>