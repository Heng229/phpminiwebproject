<?php
if (isset($_POST['changecontact-submit'])){
    require "conndb.act.php";
    
    $contact = $_POST['newContact'];
    $pwd = $_POST['password'];
    $userid = $_POST['userid'];
    
    #check receive input or not
    #echo "<script> alert('$contact,$pwd,$userid'); </script>";
    
    if(empty($contact) || empty($pwd)){
        header("Location: ../profile.php?contactformerror=emptyfield&newContact=".$contact);
        exit();
    }
    else{
        $sql = "SELECT * FROM users WHERE userId = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../profile.php?contactformerror=sqlError");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$userid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($pwd,$row['userPass']);

                if($pwdCheck == false){
                    header("Location: ../profile.php?contactformerror=passwrong&newContact=".$contact);
                    exit();
                }
                elseif($pwdCheck == true){
                    #-----------------Email is valid/not exist in database, start inserting the register information.--------------------
                    $sql = "UPDATE users SET phone = ? WHERE userId = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql)){
                     header("Location: ../register.php?contactformerror=afterpasscheckmySqlError");
                    exit();
                    }
                    else{
                    #s is string, b is boolean , i is integer
                    mysqli_stmt_bind_param($stmt,"si",$contact,$userid); # < insert hashedPwd instead of userPass
                    #After check if safe then it can be execute by this function.
                    mysqli_stmt_execute($stmt);
                    #Return the result of the sql statement(query)
                    mysqli_stmt_store_result($stmt);
                    
                    header("Location: ../profile.php?updatePhone=success");
                    exit();
                    }
                }
                else{
                    header("Location: ../profile.php?contactformerror=unknownError");
                    exit();
                }
            }
        }       
    }
}
else{
    header("Location: ../index.php");
}