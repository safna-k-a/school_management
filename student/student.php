<?php
    require '../connection.php';
    session_start();
    require '../header.php';
?> 
<?php
    $val=false;
    if(isset($_POST['stud_id'])&&isset($_POST['name'])&&isset($_POST['dob'])&&isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['phone_number'])&&isset($_POST['batch'])){
        $stud_id=$_POST['stud_id'];
        $name=$_POST['name'];
        $dob=$_POST['dob'];
        $email=$_POST['email'];
        $password=($_POST['password']);
        $confirm_password=($_POST['confirm_password']);
        $phone_number=($_POST['phone_number']);
        $batch=($_POST['batch']);
        $pic=$_FILES['image']['name']; 
        $temp=$_FILES['image']['tmp_name'];
        $target="../uploads/".basename($pic);
        $_SESSION['email']=$email;
        $_SESSION['password']=$password;
        $move_pic=move_uploaded_file($temp,$target);
        $sql=("SELECT * FROM main_details WHERE email=:email LIMIT 1");
        $statement=$connection->prepare($sql);
        $statement->execute([':email' => $email]);
        $check_email=$statement->fetch(PDO::FETCH_ASSOC);
        if ($check_email) {
            $val=true;
        }
        else{

            if($password!=$confirm_password){
                $val=true;
            }
            else{
            $sql='INSERT INTO main_details(name,email,password,phone,photo,status,batch,approval) VALUES(:name,:email,:password,:phone,:photo,:status,:batch,:approval)';
            $statement=$connection->prepare($sql);
            if($statement->execute([':name'=>$name,':email'=>$email,':password'=>md5($password),':phone'=>$phone_number,':photo'=>$pic,':status'=>'student',':batch'=>$batch,':approval'=>'waiting'])){
                $sql=("SELECT * FROM main_details WHERE email=:email");
                $statement=$connection->prepare($sql);
                $statement->execute([':email' => $email]);
                $user=$statement->fetch(PDO::FETCH_OBJ);
                $id=$user->M_id;
                $sql='INSERT INTO stud_details(M_id,stud_id,dob) VALUES(:m_id,:stud_id,:dob)';
                $statement=$connection->prepare($sql);
                if($statement->execute([':m_id'=>$id,':stud_id'=>$stud_id,':dob'=>$dob])){
              
                    echo "<script>
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Data Added Successfully',
                    showConfirmButton: false,
                    timer: 2000
                    }).then(function(){
                    window.location='../index.php';
                    });

                    </script>";
                }}
            }
        }
        
    }
    ?>
    <div class="container">
        <div class="row mt-5">  
            <div class="col-sm-6">
                <div class="mt-5"><h2 class="text center"> Register</h2></div>
                <?php
                if($val){
                echo"
                    <div class='alert alert-danger' role='alert'>
                    Incorrect email or password!
                  </div>";}
                ?>
                <form action="" method="POST" enctype="multipart/form-data" class="">
                <div><input type="text" name="stud_id" placeholder="Student Id" class="form-control mt-5 p-2" required></div> 
                    <div><input type="text" name="name" placeholder="Name" class="form-control mt-3 p-2" required></div>
                    <div><input type="date" name="dob" placeholder="Date of birth" class="form-control mt-3 p-2" required></div>
                    <div><input type="email" name="email" placeholder="Email" class="form-control mt-3 p-2"></div>
                    <div><input type="password" name="password" placeholder="Password" class="form-control mt-3 p-2" required></div>
                    <div><input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control mt-3 p-2" required></div>
                    <div><input type="text" name="phone_number" placeholder="Phone Number" class="form-control mt-3 p-2" required></div>
                    <div><input type="file" name="image" value="No File Choosen" class="form-control mt-3 p-2" required></div>
                    <div><select id="batch" name="batch" class="form-control" required>
                    <option value="cs">Computer Science</option>
                    <option value="science">Biology Science</option>
                    <option value="humanities">Humanities</option>
                    
                    </select></div>
                    <div><input type="submit" name="submit" value="Submit" class="form-control btn btn-primary mt-3 p-2"></div>
                    <div><a href="index.php" name="create" value="Already have an Account??" class="form-control btn btn-info mt-3 mb-3 p-3 bg-opacity-75">Already have an Account??</a></div>

                </form>
            </div>
        </div>
        </div>
    
        <?php

        require '../footer.php';
    ?>