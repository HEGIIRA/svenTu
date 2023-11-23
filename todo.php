<?php
include 'db.php';

//Proses insert data
if(isset($_POST['add'])) {
    $q_insert = "INSERT INTO task (task_lable, task_status) VALUE (
        '".$_POST['task']."',
        'open'
    )";
    $run_q_insert =mysqli_query($conn, $q_insert);
    if($run_q_insert) {
        header('refresh:0; url=todo.php');
    }
}

//SHOW DATA
$q_select = "SELECT * FROM task ORDER BY task_id DESC";
$run_q_select = mysqli_query($conn, $q_select);


//DELETE DATA
if(isset($_GET['delete'])) {
    $q_delete = "DELETE FROM task WHERE task_id =  '" .$_GET['delete']."'";
    $run_q_delete = mysqli_query($conn, $q_delete);
    header('refresh:0; url=todo.php');
}

//UPDATE STATUS DATA (OPEN/CLOSE)
if(isset($_GET['done'])) {
    $status = 'close';

    if($_GET['status'] == 'open') {
        $status = 'close';
    }else {
        $status = 'open';
    }

    $q_update = "UPDATE task SET task_status = '".$status."' WHERE task_id = '".$_GET['done']."'";
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

    <div class="back">
        <a href="index.php"><i class='bx bx-arrow-back'></i></a>
    </div>

    <div class="container">
        <!-- INI UNTUK HEADER -->

        
        <div class="header">

            <div class="title">
                <i class='bx bx-sun'></i>
                <h2>To Do List</h2>
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
                    <input name="task"  type="text" class="input-control" placeholder="Add Task">
                    <div class="text-right">
                        <button type="submit" name="add">Add</button>
                    </div>
                </form>
            </div>

            <!-- ini buat tugas -->
            <?php
            if(mysqli_num_rows($run_q_select) > 0) {
                while($r = mysqli_fetch_array($run_q_select)) {
            
            ?>
            <div class="card">
                <div class="task-item <?= $r['task_status'] == 'close' ? 'done':''?>">
                    <div>
                        <input type="checkbox" onclick="window.location.href= '?done=<?=$r['task_id']?>&status=<?= $r['task_status']?>'"  <?= $r['task_status'] == 'close' ? 'checked': '' ?>>
                        <span><?= $r['task_lable']?></span>
                    </div>
                    <div>
                        <a href="edit.php?id= <?= $r['task_id']?>" class="edit-task" title="edit"><i class='bx bx-edit-alt'></i></a>
                        <a href="?delete=<?= $r['task_id']?>" class="delete-task" title="Remove" onclick="return confirm('Are you sure?')"><i class='bx bx-trash'></i></a>
                    </div>
                </div>
            </div>

            <?php } } else {  ?>
            <div>Tidak ada data</div>
            <?php } ?>
            
        </div>
    </div>
    

    

    
</body>

<script src="dist/sweetalert2.all.min.js"></script>
<script>
    const btn = document.getElementById('delete-task');
    btn.addEventListener('click', function(){
        Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
    }).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success"
        });
    }
});
    })
</script>
</html>