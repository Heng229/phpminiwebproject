<?php 
if (isset($_POST['add-Cart'])){
session_start();
$model = $_POST['model'];
$quantity = $_POST['initialQuantity'];
$price = $_POST['price'];
$prodid = $_POST['prodId'];
$prodImg = $_POST['prodImgLoc'];


$product = array($prodImg,$model,$price,$quantity,$prodid);

  if(empty($_SESSION['cartItem'])){
    $_SESSION['cartItem'] = array();
    array_push($_SESSION['cartItem'],$product);
    header("Location: ../product.php?addCart=success");
  }else{
    //put the current cart item array session into a variable
    $checkItem = $_SESSION['cartItem'];
    $exist = false;
    $count = 0;

  // New use Foreach Loop
    foreach ($checkItem as $id => $val){
      if($val[4] == $product[4]){
        $exist = true;
        $existedItem = $id;
      }
    }

    // Original , used 2D array for loop

    /*for($x=0;$x < count($checkItem);$x++){
      if($checkItem[$x][4] == $product[4]){
        $exist = true;
        $existedItem = $x;
      }
    }*/

    if($exist){
      $_SESSION['cartItem'][$existedItem][3]++;
      header("Location: ../product.php?addCart=alreadyAdded");
    }else{
      array_push($_SESSION['cartItem'],$product);
      header("Location: ../product.php?addCart=success");
    }

  }
}
else{
  header("Location: ../index.php");
}