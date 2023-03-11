<?php
    require '../connection.php';
    session_start();
    require '../header.php';
    if(!isset($_SESSION['email'])) {
        header("Location:../index.php");
    }
    $email=$_SESSION['email'];
    $sql=("SELECT * FROM main_details WHERE email=:email");
    $statement=$connection->prepare($sql);
    $statement->execute([':email'=>$email]);
    $stud=$statement->fetch(PDO::FETCH_OBJ);
    $_SESSION['batch']=$stud->batch;
    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header("Location:../index.php");

    }
?>  <nav class="navbar navbar-expand-lg bg-body-tertiary">
<div class="container-fluid">
  <a class="navbar-brand">Student</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Change Password</a>
      </li>
      <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="library.php">Library</a>
      </li>
      <li>
      <form method="POST">
                <button name="logout" onclick="return confirm('Are you sure?');"><i class="fa fa-sign-out" aria-hidden="true" ></i></button></form>
</div>
</nav>

        <div class="container">
            <div class="row mt-5 justify-content-end">
                <div class="col-sm-3 img"><img src="../uploads/<?=$stud->photo ; ?>" class="img-fluid h-75 img"></h3></div>
                <div class="col-sm-6"><h3><?=$stud->name ?></h3>
                <h3><?=$stud->email ?></h3>
                
            </div>
            </div>
        

        </div>
        <?php

        require '../footer.php';
    ?>