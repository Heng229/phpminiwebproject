<?php
if (isset($_POST['changename-submit'])){
    require "conndb.act.php";
    
    $pwd = $_POST['password'];
    $uname = $_POST['newUname'];
    $userid = $_POST['userid'];
    
    #check receive input or not
    #echo "<script> alert('$userid,$uname,$userid'); </script>";
    
    if(empty($uname) || empty($pwd)){
        header("Location: ../profile.php?nameformerror=emptyfield");
        exit();
    }
    #name length
    elseif(strlen($uname) < 4 || strlen($uname) > 12 ){
        header("Location: ../profile.php?nameformerror=namelen4to12&newUname=".$uname);
        exit();
    }
    #name pattern
    elseif(!preg_match("/^[a-zA-Z0-9]*$/",$uname)){
        header("Location: ../profile.php?nameformerror=invaliduname&newUname=".$uname);
        exit();
    }
    else{
        $sql = "SELECT * FROM users WHERE userId = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../profile.php?nameformerror=sqlError");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$userid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($pwd,$row['userPass']);

                if($pwdCheck == false){
                    header("Location: ../profile.php?nameformerror=passwrong&newUname=".$uname);
                    exit();
                }
                elseif($pwdCheck == true){
                    #-----------------Email is valid/not exist in database, start inserting the register information.--------------------
                    $sql = "UPDATE users SET userName = ? WHERE userId = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql)){
                     header("Location: ../register.php?nameformerror=afterpasscheckmySqlError");
                    exit();
                    }
                    else{
                    #s is string, b is boolean , i is integer
                    mysqli_stmt_bind_param($stmt,"si",$uname,$userid); # < insert hashedPwd instead of userPass
                    #After check if safe then it can be execute by this function.
                    mysqli_stmt_execute($stmt);
                    #Return the result of the sql statement(query)
                    mysqli_stmt_store_result($stmt);
                    
                    header("Location: ../profile.php?updateName=success");
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