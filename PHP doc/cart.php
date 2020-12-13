<?php include "include/header.inc.php" ?>
<!--Style-->
<link href="../css/cart.css?<?php echo time(); ?>"    rel="stylesheet" type="text/css">
<title>PC Outstanding - Cart</title>
<?php include "include/header2.inc.php" ?>

<!----------------------------------Middle Content Start--------------------------------------->
<div class="containerCart">
   
        <?php 
        if(isset($_SESSION['idUser'])){ 
        ?>
         <div class="cart">
            <h1 style="margin-left:10px;color:gray;">Cart</h1>            
                <table class="headerCart" style="width:100%;margin-bottom:0px;" >
                        <th class="tabftColumn">Item</th>
                        <th class="tabsecColumn">Item name</th>
                        <th class="tabthColumn">Price</th>
                        <th class="tabfrColumn">Quantity</th>
                        <th class="tabfiColumn">Update Button</th>
                        <th class="tabsiColumn">Total Price</th>
                        <form action="action/removeAllCart.act.php" method="post">
                        <input type="hidden" name="removeAllCart" value="removeAllCart">
                        <th class="tabsvColumn"><button class='btn-rmv-all' type="submit" name="remove-All-Cart">Remove All</button></th>
                        </form>
                </table>
            <table id="listingtab" style="width:100%" >
                <?php
                if(isset($_SESSION['cartItem']) && count($_SESSION['cartItem'])>0 ){
                foreach ($_SESSION['cartItem'] as $item){
                    echo "<form action='action/editCart.act.php' method='post'>"; 
                    echo "<tr style='height:200px;'>";
                    foreach($item as $details => $value){
                        if($details == 0){
                            $imgLoc = $value;
                            echo "<td class='tabftColumn'><img src='$imgLoc' alt='modelImg'></td>";
                        }
                        elseif($details == 1){
                            $modelname = $value;
                            echo"<td class='tabsecColumn'>".$modelname."</td>";
                            echo"<input type='hidden' name='cartModel' value='$modelname'>";
                        
                        }
                        elseif($details == 2){
                            $price = $value;
                            echo"<td class='tabthColumn'>RM ".number_format($price,2)."</td>";
                            echo" <input type='hidden' name='cartPrice' value='$price'>";
                        
                        }
                        elseif($details == 3){
                            $quantity = $value;
                            echo "<td class='tabfrColumn'><input type='number' class='quantity' id='quantity' name='quantity' min='1' value='$quantity' required></td>";
                            
                        }
                        elseif($details == 4){
                            $prodId = $value;
                            echo "<input type='hidden' name='prodId' value='$prodId'>";
                        }
                    }
                       echo"<td class='tabfiColumn'><button class='btn-update' name='event' value='update' type='submit'>Update Price</button></td>
                       <td class='tabsiColumn'>RM ".number_format($quantity*$price,2)."</td>
                       <td class='tabsvColumn'><button class='btn-rmv' type='submit' name='event' value='delete'>Remove</button></td>
                       </tr>";
                       $grandTotalPrice += $quantity*$price; 
                echo "</form>";
                }
                ?>
                <?php     
                    }
                    else{
                     echo "<h1 style='color:cyan;text-align:center;'>Please add some item to the cart.</h1>";;
                    }   
                ?>
            </table>
        </div>
        <div id="totalPrice">
            <h1>Total Price (RM) :  <input id="grandtotaltextbox" type="text" value="
            <?php 
            if(isset($_SESSION['cartItem'])){
                echo number_format($grandTotalPrice,2); 
            }else{
                echo " ";
            }
            ?>" disabled>
        </h1>
           <?php 
            if(isset($_GET['name'])){
               $nameEntered = $_GET['name'];
            }
            else{
               $nameEntered = $_SESSION['nameUser'];
            }
            if(isset($_GET['phone'])){
                $phoneEntered = $_GET['phone'];
            }
            else{
                if(!empty($_SESSION['phone'])){
                    $phoneEntered = $_SESSION['phone'];
                }else{
                    $phoneEntered = '';
                }
            }
            if(isset($_GET['email'])){
                $emailEntered = $_GET['email'];
            }
            else{
                $emailEntered = $_SESSION['emailUser'];
            }
            if(isset($_GET['address'])){
                $addressEntered = $_GET['address'];
            }
            else{
                $addressEntered = '';
            }
            if(isset($_GET['state'])){
                $stateEntered = $_GET['state'];
            }
            else{
                $stateEntered = '';
            }
            if(isset($_GET['city'])){
                $cityEntered = $_GET['city'];
            }
            else{
                $cityEntered = '';
            }
            if(isset($_GET['postalcode'])){
                $postalEntered = $_GET['postalcode'];
            }
            else{
                $postalEntered = '';
            }
            if(isset($_GET['expyear'])){
                $expyEntered = $_GET['expyear'];
            }
            else{
                $expyEntered = '';
            } 
           ?>
        </div>
        <div class="checkoutform">
            <form action='action/purchase.act.php' id="idcheckoutform" method='post'>
               <fieldset>
                   <h3 style='margin-top:0px;'>Safe & Secure Payment</h3>
                   <img src='../symbol/mastercardcolor.svg' width="50px" height="50px">
                   <img src='../symbol/visacolor.svg' width="50px" height="50px">
                   <legend><h1>Checkout Form</h1></legend>
                   <table id="formtable">
                       <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td><input type='text' required maxlength="100" value="<?php echo $nameEntered ?>" placeholder="Your name" required name='name'></td>
                       </tr>
                       <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><input type='tel' required maxlength="10" value="<?php echo $phoneEntered ?>" pattern="[0]{1}[1]{1}[0-9]{1}[0-9]{7}" placeholder="10 Digits without dash 0121234567" required name='phone'></td>
                       </tr>
                       <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><input type="email" value="<?php echo $emailEntered ?>" maxlength="100" placeholder="example123@hotmail.com" required name='email'></td>
                       </tr>
                       <tr>
                            <td>Delivery Address</td>
                            <td>:</td>
                            <td><input type="text" value="<?php echo $addressEntered ?>" style="height: 50px;" minlength="20" maxlength="100" required placeholder="Please enter a valid address to prevent inconvenient cause" name='address' ></td>
                       </tr>
                       <tr>
                            <td><label for='state'>State</label></td>
                            <td>:</td>
                            <td>
                                <select name='state' value='<?php echo $stateEntered?>'>   
                                    <option value="Selangor">Selangor</option>
                                    <option value="Perak">Perak</option>
                                    <option value="Johor">Johor</option>
                                    <option value="Pahang">Pahang</option>
                                    <option value="Kedah">Kedah</option>
                                    <option value="Kelantan">Kelantan</option>
                                    <option value="Terengganu">Terengganu</option>
                                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                                    <option value="Penang">Penang</option>
                                    <option value="Perlis">Perlis</option>
                                    <option value="Malacca">Malacca</option>
                                </select>
                            </td>
                       </tr>
                       <tr>
                            <td>City</td>
                            <td>:</td>
                            <td><input type="text" value="<?php echo $cityEntered ?>" maxlength="40" placeholder="City eg. Bandar Sunway" required name='city'></td>
                       </tr>
                       <tr>
                            <td>Postal Code</td>
                            <td>:</td>
                            <td><input type="text" value="<?php echo $postalEntered ?>" maxlength="5" placeholder="Postal Code eg. 47500" required name='postalcode'></td>
                       </tr>
                       <tr>
                           <td>Card Number</td>
                           <td>:</td>
                           <td><input type="text" minlength='13' maxlength='16' placeholder="Card Number Accept only Mastercard & Visacard" required name='cardNum'></td>
                       </tr>
                       <tr>
                           <td>Card EXP Year</td>
                           <td>:</td>
                           <td><input type="text" value="<?php echo $expyEntered ?>" maxlength="4" minlength='4' placeholder="Card Expiration Year eg.2024" required name='expyear'></td>
                       </tr>
                       <tr>
                           <td>CVV</td>
                           <td>:</td>
                           <td><input type="text" minlength="3" maxlength="3" placeholder="Card CVV code eg.100" required name='cvv'></td>
                           <td><input type="hidden" value='<?php echo $grandTotalPrice ?>' name='grandTotal'></td>
                       </tr>
                   </table>
               </fieldset>
                            <input type='submit' id='purchase-button' name='purchase-button' value='Purchase'>
            </form>
        </div>  
        <?php  
        }
        else{    
            echo "<h1 style='text-align:center;margin-top:250px;margin-bottom:250px;'>The cart can only be accessed after login, please login to the website thank you.</h1>";
            echo "<h1 style='text-align:center;margin-top:250px;margin-bottom:250px;'><a href='login.php' style='text-decoration:none;font-weight:bold;color:blue;cursor:pointer;'>Click here go to login page.</a></h1>";
        }
        ?>
</div>
<!--Edit Cart Message-->
<?php
    if(isset($_GET['removeAll'])){
        echo "<script>alert('Successfully remove all item from cart!')</script>";
    }
    else if(isset($_GET['noItemAdded'])){
        echo "<script>alert('No item is added to the cart yet!')</script>";
    }
    else if(isset($_GET['removeItem'])){
        echo "<script>alert('Item removed from cart!')</script>";
    }
    else if(isset($_GET['updatePrice'])){
        echo "<script>alert('Price successfully updated!')</script>";
    }
?>

<!--Purchase Verification Message-->
<?php
    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyfields"){
            echo "<script>alert('Please fill up all the fields!')</script>";
        }
        elseif($_GET['error'] == "invalidCardNum"){
            echo "<script>alert('Please enter a valid card number. Only Mastercard & Visa Card are accepted!')</script>";
        }
        elseif($_GET['error'] == "invalidName"){
            echo "<script>alert('Please enter a valid name!')</script>";
        }
        elseif($_GET['error'] == "invalidEmail"){
            echo "<script>alert('Please enter a valid email!')</script>";
        }
        elseif($_GET['error'] == "invalidAddress"){
            echo "<script>alert('Please enter a valid address!')</script>";
        }
        elseif($_GET['error'] == "invalidCity"){
            echo "<script>alert('Please enter a valid city!')</script>";
        }
        elseif($_GET['error'] == "invalidPostcode"){
            echo "<script>alert('Please enter a valid postal code!')</script>";
        }
        elseif($_GET['error'] == "invalidExpYear"){
            echo "<script>alert('Please enter a valid Card Expiry Year!')</script>";
        }
        elseif($_GET['error'] == "invalidCvv"){
            echo "<script>alert('Please enter a valid CVV code!')</script>";
        }
    }

    elseif(isset($_GET['noItemadded'])){
        echo "<script>alert('No item added, please add some item to the cart before make purchase')</script>";
    }

    elseif(isset($_GET['purchase'])){
        echo "<script>alert('Purchase successfully! Thank you! Please contact us if you have any question. You may refer your purchase history in your profile page.')</script>";
    }
?>

<!----------------------------------Middle Content End--------------------------------------->

<?php include "include/footer.inc.php" ?>
