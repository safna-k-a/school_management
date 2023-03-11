<?php
    require '../connection.php';
    session_start();?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>school management system</title>
    <!-- bootstrap css -->
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
        />
        <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <?php
    if(!isset($_SESSION['email'])) {
        header("Location:../index.php");
    }
    $email=$_SESSION['email'];
    $batch=$_SESSION['batch'];
    $sql_fetch='select * from t_details where batch=:batch ';
    $statement_fetch=$connection->prepare($sql_fetch);
    $statement_fetch->execute([':batch'=>$batch]);
    $files=$statement_fetch->fetchAll(PDO::FETCH_OBJ);
    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header("Location:../index.php");

    }


?><div class="container row">
    <?php foreach($files as $file): ?>
<div class=" p-5 ">
                <iframe src='../uploads//<?=$file->file ; ?>'></iframe>
</div> 
<?php endforeach ?>
</div> 
<?php

require '../footer.php';
?>