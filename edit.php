<?php
include 'db.php';

//SELECT DATA YANG AKAN DI EDIT
$q_select = "SELECT * FROM task WHERE task_id = '".$_GET['id']."'";
$run_q_select = mysqli_query($conn, $q_select);
$d= mysqli_fetch_object($run_q_select);


//UPDATE DATA
if(isset($_POST['edit'])) {
    $q_update = "UPDATE task SET task_lable = '".$_POST['task']."' WHERE task_id = '".$_GET['id']."'";
    $run_q_update = mysqli_query($conn, $q_update);

    header('refresh:0; url=todo.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <!-- link css -->
    <link rel="stylesheet" href="stylee.css">
    <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <!-- INI UNTUK HEADER -->
        <div class="header">

            <div class="title">
                <i class='bx bx-sun'></i>
                <span>To Do List</span>
            </div>

            <div class="description">
                <?= date("l, d M Y")?>
            </div>

        </div>

        <!-- INI UNTUK KONTEN -->
        <div class="content">

            <!-- ini buat add -->
            <div class="card">
                <form action="" method="post">
                    <input name="task"  type="text" class="input-control" placeholder="Edit Task" value="<?=$d->task_lable?>">
                    <div class="text-right">
                        <button type="submit" name="edit">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>