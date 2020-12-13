<?php
session_start();
if(isset($_POST['remove-All-Cart'])){
    $removeAll = $_POST['removeAllCart'];

    if(isset($_SESSION['cartItem'])){
        if ($removeAll == "removeAllCart"){
            unset($_SESSION['cartItem']);
            unset($_SESSION['addedProduct']);
            header("Location: ../cart.php?removeAll=success");
        }
    }
    else{
        header("Location: ../cart.php?noItemAdded=true");
    }
}
else{
    header("Location: ../index.php");
}