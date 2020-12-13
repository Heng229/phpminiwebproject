<?php
session_start();
if(isset($_POST['event'])){
    $newquantity = $_POST['quantity'];
    $prodId = $_POST['prodId'];
    $event = $_POST['event'];
    $cart = $_SESSION['cartItem'];
   //echo $_SESSION['cartItem'][1][3].",".$prodId;
   // echo "<br/>Quantity :".$quantity.",prod Id :".$prodId.",event :".$event;
    
    if($event == 'update'){
        foreach($cart as $key => $value){
            if($value[4] == $prodId){
                $cart[$key][3] = $newquantity;
                $_SESSION['cartItem'] = $cart;
                header("Location: ../cart.php?updatePrice=success");
                exit();
            }
        }
    }
    elseif($event == 'delete'){
        foreach($cart as $key => $value){
            if($value[4] == $prodId){
                unset($cart[$key]);
                if(count($cart) == 0){
                    unset($_SESSION['cartItem']);
                    header("Location: ../cart.php?removeAll=true");
                }else{
                    $_SESSION['cartItem'] = $cart;
                    header("Location: ../cart.php?removeItem=success");
                }
                exit();
            }
        }
    }

}
else{
    header("Location: ../index.php");
}


