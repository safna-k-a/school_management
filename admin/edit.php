<?php 
require '../connection.php';
if(isset($_GET['a_id'])){
    $email=$_GET['a_id'];
    $sql='UPDATE main_details SET approval="approved" where email=:email';
    $statement=$connection->prepare($sql);
    if($statement->execute([':email'=>$email])){
        header("Location:profile.php?del='done'");
    }
                        
    }
    if(isset($_GET['r_id'])){
        $email=$_GET['r_id'];
        $sql='UPDATE main_details SET approval="rejected" where email=:email';
        $statement=$connection->prepare($sql);
        if($statement->execute([':email'=>$email])){
            header("Location:profile.php?del='reject'");
        }
                            
        }
    ?>