
<?php
    session_start();
    require '../connection.php';
    if(!isset($_SESSION['email'])) {
        header("Location:../index.php");
    }
    $email=$_SESSION['email'];
    $sql=("SELECT * FROM main_details WHERE email=:email");
    $statement=$connection->prepare($sql);
    $statement->execute([':email'=>$email]);
    $admin=$statement->fetch(PDO::FETCH_OBJ);
    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header("Location:../index.php");

    }
    $sql='SELECT * FROM main_details where approval=:waiting';
    $statement=$connection->prepare($sql);
    $statement->execute([':waiting'=>'waiting']);
    $users=$statement->fetchAll(PDO::FETCH_OBJ);
    if(!$users){
        echo "<script>alert('No request available')</script>";
    }



?>
<?php
    require '../header.php';
?>
<div class="container">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand">Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Change Password</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="pdf.php">Upload PDF</a>
        </li>
        <li>
      <form method="POST">
<button name="logout" onclick="return confirm('Are you sure?');" class="">Logout</button></form></li>
    </div>
  </div>
</nav>
<div class="container">
<div class="row mt-5 justify-content-end">
    <div class="col-sm-6 row">
                <div class="col-sm-5 img"><img src="../uploads/20170205_122859.jpg" class="img-fluid h-75 img"></h3></div>
                <div class="col-sm-5"><h3><?= $admin->name; ?></h3>
                <h3><?= $admin->email; ?></h3>
                </div></div>
            
<div class="w-50 mt-5 p-5 overflow-scroll col-sm-6" style="height:300px">
    <table class="table table-primary table-striped">
        <thead>
            <tr>
                <th>
                    SlNo
                </th>
                <th>
                    Name
                </th>
                <th>
                    email
                </th>
                <th>
                    Mobile
                </th>
                <th>
                    User Type
                </th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach($users as $user): 
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->phone ?></td>
                    <td><?= $user->status ?></td>
                    <td ><a href="edit.php?a_id=<?php echo $user->email; ?>" class="btn btn-success" target="_blank" name="accept">Accept</a></td>
                    <?php if(isset($_GET['done'])){
                         echo "<script>alert('accepted Successfully')</script>";}?>
                    <td><a href="edit.php?r_id=<?php echo $user->email; ?>"class="btn btn-danger"onclick="return confirm('Are you sure?'); "name="reject">Reject</a>
                    <?php if(isset($_GET['reject'])){
                         echo "<script>alert('rejected Successfully')</script>";
                         }?>
                </td>
                </tr>
            <tr>
            
            <?php $i=$i+1; endforeach ?>
        </tbody>
    </table>
</div> 
</div>
</div>
<?php

    require '../footer.php';
?>