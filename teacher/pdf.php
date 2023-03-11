<?php
    require '../connection.php';
    session_start();
    require '../header.php';
    if(!isset($_SESSION['email'])) {
        header("Location:../index.php");
    }
    $email=$_SESSION['email'];
    if(isset($_FILES['pdf'])&&isset($_POST['batch_name'])){
        $file=$_FILES['pdf']['name']; 
        $temp=$_FILES['pdf']['tmp_name'];
        $target="../uploads/".basename($file);
        $batch_name=$_POST['batch_name'];
        $move_file=move_uploaded_file($temp,$target);
        $sql='INSERT INTO t_details(batch,file) VALUES(:batch,:file)';
        $statement=$connection->prepare($sql);
        if($statement->execute([':batch'=>$batch_name,':file'=>$file])){
        
                echo "<script>
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Data Added Successfully',
                showConfirmButton: false,
                timer: 2000
                }).then(function(){
                window.location='profile.php';
                });

                </script>";
            }
        }
?> 
        
        <div class="container">
            <div class="row mt-5 justify-content-end">
            <div class="form w-50 mt-5 ms-5 bg-primary bg-opacity-25 p-5">
<form action="" method="POST" enctype="multipart/form-data" class="">
    <div class="mt-3"><input type="file" value="" class="form-control" name="pdf" ></div>
    <div class="mt-3"><select id="batch" name="batch_name" class="form-control" required>
                    <option value="cs">Computer Science</option>
                    <option value="science">Biology Science</option>
                    <option value="humanities">Humanities</option>
                    </select></div>
    <div class="text-center mt-3"><input type="submit" value="Upload" class="btn btn-primary" name="submit"></div>
</form> 
                
                
            </div>
            </div>
        

        </div>
        <?php

        require '../footer.php';
    ?>