<?php
session_start();

if(!isset($_SESSION['email'])){
    header("location: Login.html");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "Login");
$email = $_SESSION['email'];
?>

<?php
if(isset($_POST['add_task'])){
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $dea = $_POST['dea'];

    $escaped_title = escapeshellarg($title);

    $command = "python predict_model.py ".$escaped_title;
    $output = shell_exec($command);

    $output = trim($output);

    if(strpos($output, ',') !== false){
        list($category, $confidence) = explode(",", $output);
    } else {
        $category = "Uncategorized";
        $confidence = "0";
    }
    
    $insert = mysqli_prepare($conn, "INSERT INTO tasks (user_email, title, description, deadline, category, confidence) VALUES (?, ?, ? ,?, ?, ?)");
    mysqli_stmt_bind_param($insert, "ssssss", $email, $title, $desc, $dea, $category, $confidence);
    mysqli_stmt_execute($insert);
    mysqli_stmt_close($insert);
    header("location: tasks.php");
    exit();
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $delete = mysqli_prepare($conn, "DELETE FROM tasks WHERE id = ? AND user_email = ?");
    mysqli_stmt_bind_param($delete, "is", $id, $email);
    mysqli_stmt_execute($delete);
    mysqli_stmt_close($delete);
    header("location: tasks.php");
    exit();
}

if(isset($_GET['complete'])){
    $id = $_GET['complete']; 
    
    $complete = mysqli_prepare($conn ,"UPDATE tasks SET status = 'completed' WHERE id = ? AND user_email = ?");
    mysqli_stmt_bind_param($complete, "is", $id, $email);
    mysqli_stmt_execute($complete);
    mysqli_stmt_close($complete);
    header("location: tasks.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM tasks WHERE user_email = ? ORDER BY deadline ASC");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>TASKS</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style_tasks.css">
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
            <h1>📋Your Tasks</h1>
        </header>
        <section>
            <div class="card">
            <h2>ADD NEW TASK?</h2>
                <form method="POST" action="">
                    <label>Title:</label>
                    <input type="text" name="title" required>
                    <label>Description:</label>
                    <textarea name="desc"></textarea>
                    <label>Deadline:</label>
                    <input type="date" name="dea" required>
                    <button type="submit" name="add_task">ADD</button>
                </form>
            </div>
            <div class="card">
            <h2>YOUR TASKS</h2>
                <div class="tasks">
                <?php
                    if(mysqli_num_rows($result) == 0){
                        echo "<h3>"."<strong>"."NO TASKS YET! ADD ONE ABOVE."."</strong>"."</h3>";
                    }else{
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<h3>"."<strong>".$row['title']."</strong>"."</h3>";
                            echo "<p>".$row['description']."</p>";
                            echo "<p>"."📅 Deadline: ".$row['deadline']."</p>";
                            echo "<p>"."Status: "."<Strong>".$row['status']."</strong>"."</p>";
                            echo "<p>🏷️ Category: <strong>" . $row['category'] . "</strong> (Confidence: " . $row['confidence'] . "%)</p>";

                        
                    
                        if($row['status'] == 'pending'){
                                echo "<a href='tasks.php?complete=" . $row['id'] . "' class='btn-complete'>✅ Complete</a>";
                        }
                        
                        echo "<a href='tasks.php?delete=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Delete this task?\")'>🗑️ Delete</a>";
                            
                        echo "<hr>";
                        }
                    }
                ?>
                </div>
            </div>
        </section>
    </body>
</html>