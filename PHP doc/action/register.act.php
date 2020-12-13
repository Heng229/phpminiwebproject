<?php 
if (isset($_POST['register-submit'])){
    require "conndb.act.php";

    $userEmail = $_POST['email'];
    $userName = $_POST['username'];
    $userPass = $_POST['password'];
    $userPassConf = $_POST['passwordConf'];


    #--------------------------Input validation Start-------------------------------
    if(empty($userEmail) || empty($userName) || empty($userPass) || empty($userPassConf)){
        header("Location: ../register.php?error=emptyfields&email=".$userEmail."&username=".$userName);
        #exit() stop the code from keep running.
        exit();
    }
    elseif(!filter_var($userEmail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$userName)){
        header("Location: ../register.php?error=invalidMailUsername");
        exit();
    }
    #filter_var() is used to check email without self implementation, latest MySQLI makes life easier
    elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
        header("Location: ../register.php?error=invalidMail&username=".$userName);
        exit();
    }
    #preg_match() to check pattern
    elseif (!preg_match("/^[a-zA-Z0-9]*$/",$userName)){
        header("Location: ../register.php?error=invalidMailUsername&email=".$userEmail);
        exit();
    }

    elseif (strlen($userName) < 4 || strlen($userName) > 12){
        header("Location: ../register.php?error=username4n12char&email=".$userEmail."&username=".$userName);
        exit();
    }
    
    #measure user password length
    elseif (strlen($userPass) < 8 || strlen($userPass) > 12){
        header("Location: ../register.php?error=userpass8n12char&email=".$userEmail."&username=".$userName);
        exit();
    }
    #preg_match() to check pattern
    elseif (!preg_match("/^[a-zA-Z0-9]*$/",$userPass)){
        header("Location: ../register.php?error=invalidPassword&email=".$userEmail."&username=".$userName);
        exit();
    }
    elseif($userPass !== $userPassConf){
        header("Location: ../register.php?error=WrongConfirmationPassward&email=".$userEmail."&username=".$userName);
        exit();
    }
    #--------------------------Input validation end-------------------------------

    else{
        #-------------------------1st check email existence------------------------
        #else no error then start to compare with data existed in database.
        $sql = "SELECT userEmail FROM users WHERE userEmail=?";
        #create a prepared statement.
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../register.php?error=mySqlError");
            exit();
        }
        else{
            #this function is used to prevent sql injection(security)
            #s is string, b is boolean , i is integer
            mysqli_stmt_bind_param($stmt,"s",$userEmail);
            #After check if safe then it can be execute by this function.
            mysqli_stmt_execute($stmt);
            #Return and store the result of the sql statement(query)
            mysqli_stmt_store_result($stmt);

            #num row returns number of row of the result.
            $reusltCheck = mysqli_stmt_num_rows($stmt);
            if($reusltCheck > 0){
                header("Location: ../register.php?error=emailAlreadyExist&email=".$userEmail."&username=".$userName);
                exit();
            }
            else{
                #-----------------Email is valid/not exist in database, start inserting the register information.--------------------
                $sql = "INSERT INTO users (userEmail,userName,userPass) VALUES (?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../register.php?error=mySqlError");
                    exit();
                }
                else{
                    #this is to encrypt the password so no password can be seen in the database as they are all encrypted and doesn't make sense.
                    $hashedPwd = password_hash($userPass,PASSWORD_DEFAULT);
                    #this function is used to prevent sql injection(security)
                    #s is string, b is boolean , i is integer
                    #3 s because 3 data inserting are all string
                    mysqli_stmt_bind_param($stmt,"sss",$userEmail,$userName,$hashedPwd); # < insert hashedPwd instead of userPass
                    #After check if safe then it can be execute by this function.
                    mysqli_stmt_execute($stmt);
                    #Return the result of the sql statement(query)
                    mysqli_stmt_store_result($stmt);
                    
                    header("Location: ../register.php?register=success");
                    exit();
                    
                } 
            }
        }
    }
    #close all db connections and sql queries to save the resource.
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($conn);
}
else{
    header("Location: ../index.php");
    exit();
}