<?php
session_start();

if(!isset($_SESSION['email'])){
    header("location: Login.html");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "Login");

$Email = $_SESSION['email'];

$count = mysqli_prepare($conn, "SELECT COUNT(*) FROM tasks WHERE user_email = ?");
mysqli_stmt_bind_param($count, "s", $Email);
mysqli_stmt_execute($count);
mysqli_stmt_bind_result($count, $num_tasks);
mysqli_stmt_fetch($count);
mysqli_stmt_close($count);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>HOME</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style_home.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="home.php">🏠Home</a></li>
                    <li><a href="tasks.php">📃Your Tasks</a></li>
                    <li><a href="logout.php">🚪Logout</a></li>
                </ul>
            </nav>
            <?php
                echo"<h1>"."Welcome ".htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'utf-8')."!"."<h1>";
            ?>
        </header>

<section>
    <div class="welcome-card">
        <h2>Let's Get Things Done! 🚀</h2>
        <p>
            Hello, <strong><?php echo $_SESSION['name']; ?></strong>! 
            Welcome to your personal task manager. 
            You have <strong><?php echo $num_tasks; ?></strong> tasks waiting for you.
        </p>
        <p>
            Ready to organize your day? Head over to 
            <a href="tasks.php">Your Tasks</a> and start checking things off your list.
            Remember, every completed task is a step closer to your goals!
        </p>
        <p style="margin-top: 15px; font-style: italic; color: #aaa;">
            "The secret of getting ahead is getting started." — Mark Twain
        </p>
    </div>
</section>
    </body>
</html>