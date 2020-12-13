<?php
session_start();
    
if(isset($_POST['purchase-button'])){
  if(isset($_SESSION['cartItem'])){
    require "conndb.act.php";
    $iduser = $_SESSION['idUser'];
    $grandTotal = $_POST['grandTotal'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $postalcode = $_POST['postalcode'];
    $cardNum = $_POST['cardNum'];
    $cardExpY = $_POST['expyear'];
    $cvv = $_POST['cvv'];
    $date = date('d-m-Y');
    $cartItems = $_SESSION['cartItem'];
    $serializedCart = serialize($cartItems);
    //Card Number Pattern
    $mastercard = "/^([5]{1}[1-5]{1}[0-9]{14})*$/";
    $visacard = "/^([4]{1}[0-9]{12,15})$/";

    //echo $name."<br/>".$phone."<br/>".$email."<br/>".$address."<br/>".$state."<br/>".$city."<br/>".$postalcode."<br/>".$cardNum."<br/>".$cardExpY."<br/>".$cvv."<br/>".$date."<br/>".$iduser."<br/>".$grandTotal."<br/>".$serializedCart."<br/>";

    //---------------------------------------Input Validation Start---------------------------------------------
    if(empty($name) || empty($phone) || empty($email) || empty($address) || empty($state) || empty($city) || empty($postalcode) || empty($cardNum) || empty($cardExpY) || empty($cvv)){
        header("Location: ../register.php?error=emptyfields&name=".$name."&phone=".$phone."&email=".$email."&address=".$address."&state=".$state."&city=".$city."&postalcode=".$postalcode."&expyear=".$cardExpY);
        exit();
    }

    elseif(!preg_match("/^[a-zA-Z0-9]*$/",$name)){
        header("Location: ../cart.php?error=invalidName&phone=".$phone."&email=".$email."&address=".$address."&state=".$state."&city=".$city."&postalcode=".$postalcode."&expyear=".$cardExpY);
        exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../cart.php?error=invalidEmail&phone=".$phone."&name=".$name."&address=".$address."&state=".$state."&city=".$city."&postalcode=".$postalcode."&expyear=".$cardExpY);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9, -]*$/",$address)){
        header("Location: ../cart.php?error=invalidAddress&phone=".$phone."&email=".$email."&name=".$name."&state=".$state."&city=".$city."&postalcode=".$postalcode."&expyear=".$cardExpY);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z -]*$/",$city)){
        header("Location: ../cart.php?error=invalidCity&phone=".$phone."&email=".$email."&address=".$address."&state=".$state."&name=".$name."&postalcode=".$postalcode."&expyear=".$cardExpY);
        exit();
    }
    elseif(!preg_match("/^[0-9]*$/",$postalcode)){
        header("Location: ../cart.php?error=invalidPostcode&phone=".$phone."&email=".$email."&address=".$address."&state=".$state."&city=".$city."&name=".$name."&expyear=".$cardExpY);
        exit();
    }

    elseif(!preg_match("/^[0-9]*$/",$cardExpY)){
        header("Location: ../cart.php?error=invalidExpYear&phone=".$phone."&email=".$email."&address=".$address."&state=".$state."&city=".$city."&postalcode=".$postalcode."&name=".$name);
        exit();
    }
    elseif($cardExpY < 2021 || $cardExpY > 2030 ){
        header("Location: ../cart.php?error=invalidExpYear&phone=".$phone."&email=".$email."&address=".$address."&state=".$state."&city=".$city."&postalcode=".$postalcode."&name=".$name);
        exit();
    }

    elseif(!preg_match("/^[0-9]*$/",$cvv)){
        header("Location: ../cart.php?error=invalidCvv&phone=".$phone."&email=".$email."&address=".$address."&state=".$state."&city=".$city."&postalcode=".$postalcode."&name=".$name);
        exit();
    }

    elseif(!preg_match($visacard,$cardNum)){
        if(!preg_match($mastercard,$cardNum)){
            header("Location: ../cart.php?error=invalidCardNum&phone=".$phone."&email=".$email."&address=".$address."&state=".$state."&city=".$city."&postalcode=".$postalcode."&expyear=".$cardExpY."&name=".$name);
            exit();
        }
        //After all validation start inserting to the sales record database.
        else{
            $sql = "INSERT INTO salesrecord (datepurchase,userid,username,phone,email,deliverAddress,countryState,city,postcode,cardNum,expyear,cvv,totalAmount,cartItemlist) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../cart.php?error=mysqlError");
                exit();
            }
            else{
                $hashedcvv = password_hash($cvv,PASSWORD_DEFAULT);
                if(strlen($cardNum) == 16){
                    $length = 12;
                }
                elseif(strlen($cardNum) == 13){
                    $length = 9;
                }
                for($i = 0;$i < $length;$i++){
                    $cardNum[$i] = "*";
                }
                $hashedCardNum = $cardNum;
                mysqli_stmt_bind_param($stmt,"sssissssisisds",$date,$iduser,$name,$phone,$email,$address,$state,$city,$postalcode,$hashedCardNum,$cardExpY,$hashedcvv,$grandTotal,$serializedCart);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                header("Location: ../cart.php?purchase=success");
                exit();
            }
        }
    }
    elseif(preg_match($visacard,$cardNum)){
        $sql = "INSERT INTO salesrecord (datepurchase,userid,username,phone,email,deliverAddress,countryState,city,postcode,cardNum,expyear,cvv,totalAmount,cartItemlist) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../cart.php?error=mysqlError");
                exit();
            }
            else{
                $hashedcvv = password_hash($cvv,PASSWORD_DEFAULT);
                if(strlen($cardNum) == 16){
                    $length = 12;
                }
                elseif(strlen($cardNum) == 15){
                    $length = 11;
                }
                elseif(strlen($cardNum) == 14){
                    $length = 10;
                }
                elseif(strlen($cardNum) == 13){
                    $length = 9;
                }
                for($i = 0;$i < $length;$i++){
                    $cardNum[$i] = "*";
                }
                $hashedCardNum = $cardNum;
                mysqli_stmt_bind_param($stmt,"sssissssisisds",$date,$iduser,$name,$phone,$email,$address,$state,$city,$postalcode,$hashedCardNum,$cardExpY,$hashedcvv,$grandTotal,$serializedCart);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                header("Location: ../cart.php?purchase=success");
                exit();
            }
    }
  }
  else{
    header("Location: ../cart.php?noItemadded=true");
  }
}
else{
    header("Location: ../index.php");
}