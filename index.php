<?php
    require 'connection.php';
    session_start();
    require 'header.php';
?> 
<?php
    $val=false;
    if(isset($_POST['email'])&&isset($_POST['password'])){
        $email=$_POST['email'];
        $password=($_POST['password']);
        $_SESSION['email']=$email;
        $_SESSION['password']=$password;
        $sql='SELECT * from main_details where email=:email LIMIT 1';
        $statement=$connection->prepare($sql);
        $statement->execute([':email'=>$email]);
        $stud=$statement->fetch(PDO::FETCH_OBJ);
        if($stud){
            $var=$stud->password;
            $status=$stud->status;
            $approval=$stud->approval;
            if((md5($password)==$var)&&($status=='student')&&($approval=='approved')){
                header("Location:student/profile.php");
            }elseif((md5($password)==$var)&&($status=='teacher')&&($approval=='approved')){
                header("Location:teacher/profile.php");
            }
            elseif((md5($password)==$var)&&($status=='admin')&&($approval=='approved')){
                header("Location:admin/profile.php");
            }
            else{
                $val=true;
            }
           
            
        }
        else{
            $val=true;
        }
        
    
    }?>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-sm-6">
                <h2 class="mt-5">Login</h2>
                <?php
                if($val){
                echo"
                    <div class='alert alert-danger' role='alert'>
                    Incorrect email or password!
                  </div>";}
                ?>
                <form action="" method="POST" class="">
                    <div><input type="email" name="email" placeholder="Email" class="form-control mt-5 p-3"></div>
                    <div><input type="password" name="password" placeholder="Password" class="form-control mt-3 p-3"></div>
                    <div><input type="submit" name="submit" value="Login" class="form-control btn btn-primary mt-3 p-3"></div>
                    <div class="row">
                        <div class="col-sm-6"><a href="student/student.php" name="create" value="Sign Up for student" class="form-control btn btn-info mt-3 mb-3 p-3 bg-opacity-75">Sign Up for student</a></div>
                        <div class="col-sm-6"><a href="teacher/register.php" name="create" value="Sign Up for Teacher" class="form-control btn btn-info mt-1 mb-3 p-3 bg-opacity-75">Sign Up for teacher</a></div>
                    </div>
                    <a href="" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Forgotten Password</a>
                </form>
                <!--  -->
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form method="POST" action="mail.php">
            <div><input type="email" id="femail" name="f_email" placeholder="Email Please"class="form-control" required></div>
            <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="submit_email">Submit</button>
      </div>
            </form>
        </div>
      
    </div>
  </div>
</div>
        <?php
        if(isset($_SESSION['message'])){
            echo "<script>
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Password changed Successfully',
                    showConfirmButton: false,
                    timer: 2000
                    }).then(function(){
                        
                    window.location='index.php';
                    });

                    </script>";


        }
        unset($_SESSION['message']);
        if(isset($_SESSION['error'])){
            echo "<script>
                    Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error',
                    showConfirmButton: false,
                    timer: 2000
                    }).then(function(){
                        
                    window.location='index.php';
                    });

                    </script>";


        }
        unset($_SESSION['error']);
        require 'footer.php';
    ?>