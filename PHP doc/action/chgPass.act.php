<?php
if (isset($_POST['changepass-submit'])){
    require "conndb.act.php";
    
    $oldPass = $_POST['oldpass'];
    $newPass = $_POST['newpass'];
    $repeatPass = $_POST['repeatPass'];
    $userid = $_POST['userid'];
    
    #check receive input or not
    echo "<script> alert(' $oldPass , $newPass , $repeatPass , $userid ')</script>";

    if(empty($oldPass) || empty($newPass) || empty($repeatPass)){
        header("Location: ../profile.php?passformerror=emptyfield");
        exit();
    }
    #passlength
    elseif(strlen($newPass) < 8 || strlen($newPass) > 12 ){
        header("Location: ../profile.php?passformerror=passlen8to12");
        exit();
    }
    #pass pattern
    elseif(!preg_match("/^[a-zA-Z0-9]*$/",$newPass)){
        header("Location: ../profile.php?passformerror=invalidPass");
        exit();
    }
    #pass confirm matching.
    elseif($newPass !== $repeatPass){
        header("Location: ../profile.php?passformerror=passNotMatch");
        exit();
    }
    else{
        $sql = "SELECT * FROM users WHERE userId = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../profile.php?passformerror=sqlError");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$userid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($oldPass,$row['userPass']);

                if($pwdCheck == false){
                    header("Location: ../profile.php?passformerror=passwrong");
                    exit();
                }
                elseif($pwdCheck == true){
                    #-----------------Email is valid/not exist in database, start inserting the register information.--------------------
                    $sql = "UPDATE users SET userPass = ? WHERE userId = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql)){
                     header("Location: ../register.php?passformerror=afterpasscheckmySqlError");
                    exit();
                    }
                    else{
                    #this is to encrypt the password so no password can be seen in the database as they are all encrypted and doesn't make sense to hacker.
                    $hashedPwd = password_hash($newPass,PASSWORD_DEFAULT);
                    #this function is used to prevent sql injection(security)
                    #s is string, b is boolean , i is integer
                    #1 s 1 i because 2 data inserting are 1 string and 1 integer
                    mysqli_stmt_bind_param($stmt,"si",$hashedPwd,$userid); # < insert hashedPwd instead of userPass
                    #After check if safe then it can be execute by this function.
                    mysqli_stmt_execute($stmt);
                    #Return the result of the sql statement(query)
                    mysqli_stmt_store_result($stmt);
                    
                    header("Location: ../profile.php?updatePass=success");
                    exit();
                    } 
                }
                else{
                    header("Location: ../profile.php?passformerror=unknownError");
                    exit();
                }
            }
        }       
    }
}
else{
    header("Location: ../index.php");
}