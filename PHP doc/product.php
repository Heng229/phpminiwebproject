<?php include_once 'action/conndb.act.php'; ?>
<script src="../javascript/productButton.js"></script>
<!--Style-->
<link href="../css/product.css?<?php echo time(); ?>"     rel="stylesheet" type="text/css">
<?php include "include/header.inc.php" ?>
<title>PC Outstanding - Product</title>
<?php include "include/header2.inc.php" ?>

<?php 
    $sqlHighperf = "SELECT * FROM productpc WHERE type = 'highperf';";
    $sqlOffice = "SELECT * FROM productpc WHERE type = 'officeUse';";
    $resultHighperf = mysqli_query($conn,$sqlHighperf);
    $resultOffice = mysqli_query($conn,$sqlOffice);
    #store the result array by > create an array variable with array(); 

    #stroe high perf pc products.
    $proddatas = array();
    if (mysqli_num_rows($resultHighperf) > 0){
        while($row = mysqli_fetch_assoc($resultHighperf)){
            #the datas here is the array created
            $proddatas[] = $row;
        }
    }
    #store office pc products.
    $proddatas2 = array();
    if (mysqli_num_rows($resultOffice) > 0){
        while($row = mysqli_fetch_assoc($resultOffice)){
            #the datas here is the array created
            $proddatas2[] = $row;
        }
    }

?>
    <div class="containerProd">
        <!---------------------------High Performance PC Product List BOX Start------------------------->
        <div class="highperf" style="background-color:black;">
            <h1 style="color:cyan;">High Performance PC</h1>
            <div class="productListBox">
            <?php foreach ($proddatas as $proddata) { ?>
                <div class="ProdList">
                    <form action="action/addCart.act.php" method="post">
                    <div class="imgLocator"><img src="<?php echo $proddata['prodImgLoc'] ?>" alt="<?php echo $proddata['model'] ?>"></div>
                    <input type="hidden" name="prodImgLoc" value="<?php echo $proddata['prodImgLoc'] ?>">
                    <div class="prodDesc">
                    <table style="color:cyan;">
                        <tr>
                            <td><label for="model">Model</label></td>
                            <td>:</td>
                            <td><input type="hidden" name="model" value="<?php echo $proddata['model'] ?>"><?php echo $proddata['model'] ?></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>:</td>
                            <td><input type="hidden" name="price" value="<?php echo $proddata['price'] ?>">RM <?php echo number_format($proddata['price']) ?></td>
                        </tr>
                        <tr>
                            <td>CPU</td>
                            <td>:</td>
                            <td><?php echo $proddata['cpu'] ?></td>
                        </tr>
                        <tr>
                            <td>GPU</td>
                            <td>:</td>
                            <td width="400px"><?php echo $proddata['gpu'] ?></td>
                        </tr>
                        <tr>
                            <td>Memory</td>
                            <td>:</td>
                            <td width="400px"><?php echo $proddata['memory'] ?></td>
                        </tr>
                        <tr>
                            <td>Display</td>
                            <td>:</td>
                            <td width="400px"><?php echo $proddata['display'] ?></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="initialQuantity" value="1"></td>
                            <td><input type="hidden" name="prodId" value="<?php echo $proddata['prodId'] ?>"></td>
                        </tr>
                    </table>
                    </div>
                        <?php 
                           if (isset($_SESSION['nameUser'])){ ?>
                             <button class='cartButton' type='submit' name='add-Cart'>
                             <img src='../symbol/cart.svg'>Add To Cart
                             </button>
                            <?php }else{ 
                                echo "<a href='login.php' id='cartButtonNoLogin' onclick='requestLogin()'><img src='../symbol/cart.svg'>Add To Cart</a>";
                            }
                            ?>
                    </form>
                </div>
            <?php } ?> 
            </div>
         </div>
            <!---------------------------High Performance PC Product List BOX END------------------------->
            <div class="officeUse" >
            <h1 style="color:#ccc">Workstation & Office PC</h1>
            <div class="productListBox">
            <?php foreach ($proddatas2 as $proddata2) { ?>
                <div class="ProdList">
                    <form action="action/addCart.act.php" method="post">
                    <div class="imgLocator"><img src="<?php echo $proddata2['prodImgLoc'] ?>" alt="<?php echo $proddata2['model'] ?>"></div>
                    <input type="hidden" name="prodImgLoc" value="<?php echo $proddata2['prodImgLoc'] ?>">
                    <div class="prodDesc">
                    <table>
                        <tr>
                            <td><label for="model">Model</label></td>
                            <td>:</td>
                            <td><input type="hidden" name="model" value="<?php echo $proddata2['model'] ?>"><?php echo $proddata2['model'] ?></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>:</td>
                            <td><input type="hidden" name="price" value="<?php echo $proddata2['price'] ?>">RM <?php echo number_format($proddata2['price']) ?></td>
                        </tr>
                        <tr>
                            <td>CPU</td>
                            <td>:</td>
                            <td><?php echo $proddata2['cpu'] ?></td>
                        </tr>
                        <tr>
                            <td>GPU</td>
                            <td>:</td>
                            <td width="400px"><?php echo $proddata2['gpu'] ?></td>
                        </tr>
                        <tr>
                            <td>Memory</td>
                            <td>:</td>
                            <td width="400px"><?php echo $proddata2['memory'] ?></td>
                        </tr>
                        <tr>
                            <td>Display</td>
                            <td>:</td>
                            <td width="400px"><?php echo $proddata2['display'] ?></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="initialQuantity" value="1"></td>
                            <td><input type="hidden" name="prodId" value="<?php echo $proddata2['prodId'] ?>"></td>
                        </tr>
                    </table>
                    </div>
                        <?php 
                           if (isset($_SESSION['nameUser'])){ ?>
                             <button class='cartButton' type='submit' name='add-Cart'>
                             <img src='../symbol/cart.svg'>Add To Cart
                             </button>
                            <?php }else{ 
                                echo "<a href='login.php' id='cartButtonNoLogin' onclick='requestLogin()'><img src='../symbol/cart.svg'>Add To Cart</a>";
                            }
                            ?>
                    </form>
                </div>
            <?php } ?> 
            </div>
         </div>
            
    </div>

<?php
    if(isset($_GET['addCart'])){
        if($_GET['addCart']=="success"){
            echo "<script>alert('Item added to cart!')</script>";
        }
        elseif($_GET['addCart']=="alreadyAdded"){
            echo "<script>alert('Item already in the cart, quantity + 1')</script>";
        }
    }
?>
<?php include "include/footer.inc.php" ?>