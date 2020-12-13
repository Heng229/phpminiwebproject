<?php
if (isset($_POST['login-submit'])){
    require "conndb.act.php";
    
    $emailLog = $_POST['email'];
    $passLog = $_POST['passwordget'];

    if(empty($emailLog) || empty($passLog)){
        header("Location: ../login.php?error=emptyfields&email=".$emailLog);
        exit();
    }
    else{
                                                    #? for security 
        $sql = "SELECT * FROM users  WHERE userEmail=?;";

        #mysqli_stmt_init() is to start(initialize) the connection of the database.
        $stmt = mysqli_stmt_init($conn); #< $conn from conndb.act.php

        #mysqli_stmt_prepare to check if there is error in the SQL.
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../login.php?error=sqlError");
            exit();
        }
        else{
            #If no error now we parse the input as parameter into database. To find out whether there is email matched in database
            mysqli_stmt_bind_param($stmt,"s",$emailLog);
            #Execute the $stmt that are binded with the 
            #                       $stmt is binded with emailLog
            #mysqli_stmt_bind_param($stmt,"s",$emailLog)
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            
            #we used mysqli_fetch_assoc to make the raw data row from database and make it able to be used in the PHP by turning it into Associative Array.
            if ($row = mysqli_fetch_assoc($result)){

                #password_verify(the user input password , compare password from database) will return true false, to use for comparison
                $pwdCheck = password_verify($passLog,$row['userPass']);
                if($pwdCheck == false){
                    header("Location: ../login.php?error=passOremailInvalid&email=".$emailLog);
                    exit();
                }
                elseif ($pwdCheck == true){
                    #now if password and email correct, we will create session (Global variable can be accessed by different pages.)
                    session_start();
                    $_SESSION['idUser'] = $row['userId'];
                    $_SESSION['nameUser'] = $row['userName'];
                    $_SESSION['phone'] = $row['phone'];
                    $_SESSION['emailUser'] = $row['userEmail'];
                    $_SESSION['passUser'] = $row['userPass'];
                    $userid = $_SESSION['idUser'];

                    #Fetching purchase history data
                    $sql = "SELECT * FROM salesrecord WHERE userid = $userid ";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        header("Location: ../login.php?error=salerecordSqlError");
                        exit();
                    }
                    else{
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        
                            $_SESSION['histsalesid'] = array();
                            $_SESSION['histdate'] = array();
                            $_SESSION['histusername'] = array();
                            $_SESSION['histphone'] = array();
                            $_SESSION['histemail'] = array();
                            $_SESSION['histaddr'] = array();
                            $_SESSION['histstate'] = array();
                            $_SESSION['histcity'] = array();
                            $_SESSION['histpostcode'] = array();
                            $_SESSION['histtotalamount'] = array();
                            $_SESSION['histitem'] = array();
                            $_SESSION['histcardNum'] = array();

                            while($row = mysqli_fetch_assoc($result)){
                                array_push($_SESSION['histsalesid'],$row['salesid']);
                                array_push($_SESSION['histdate'],$row['datepurchase']);
                                array_push($_SESSION['histusername'],$row['username']);
                                array_push($_SESSION['histphone'],$row['phone']);
                                array_push($_SESSION['histemail'],$row['email']);
                                array_push($_SESSION['histaddr'],$row['deliverAddress']);
                                array_push($_SESSION['histstate'],$row['countrystate']);
                                array_push($_SESSION['histcity'],$row['city']);
                                array_push($_SESSION['histpostcode'],$row['postcode']);
                                array_push($_SESSION['histtotalamount'],$row['totalAmount']);
                                $unserializeitem = unserialize($row['cartItemlist']);
                                array_push($_SESSION['histitem'],$unserializeitem);

                                $cardNum = $row['cardNum'];
                                if(strlen($cardNum) == 16){
                                    $length = 12;
                                }
                                elseif(strlen($cardNum) == 13){
                                    $length = 9;
                                }
                                for($i = 0;$i < $length;$i++){
                                    $cardNum[$i] = "*";
                                }
                                array_push($_SESSION['histcardNum'],$cardNum);
                            }
                       
                    }

                    header("Location: ../index.php?login=success");
                }
                #Else > This return error message because unexpected problem.
                else{
                    header("Location: ../login.php?error=wrongInput");
                    exit();
                }
            }else{
                #This means that email input by user is not exist in database.
                header("Location: ../login.php?error=invalidUser");
                exit();
            }
        }
    }
}
else{
    header("Location: ../index.php");
    exit();
}