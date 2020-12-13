<?php include "include/header.inc.php" ?>
<!--Style-->
<link href="../css/purchasehist.css?<?php echo time(); ?>"   rel="stylesheet" type="text/css">
<title>PC Outstanding - Purchase History</title>
<?php include "include/header2.inc.php" ?>

<div class="container">
    <h1 id='purchase-history-title'>Purchase History</h1>

    <div class='historyBox'>
    <?php
        if(count($_SESSION['histsalesid']) > 0){
            $salesid = $_SESSION['histsalesid'];
            $date = $_SESSION['histdate'];
            $name = $_SESSION['histusername'];
            $phone = $_SESSION['histphone'];
            $email = $_SESSION['histemail'];
            $address = $_SESSION['histaddr'];
            $state = $_SESSION['histstate'];
            $city = $_SESSION['histcity'] ;
            $postcode = $_SESSION['histpostcode'];
            $totalAmount = $_SESSION['histtotalamount'];
            $itemlist = $_SESSION['histitem'];
            $cardNum = $_SESSION['histcardNum'];
    ?>
        <table id='historyTab'>
            <tr id='tablehead'>
                <th>Purchase ID</th>
                <th>Date</th>
                <th>Name</th>
                <th>Delivery Address</th>
                <th>State</th>
                <th>City</th>
                <th>Postcode</th>
                <th>Card Number Last 4 digits</th>
                <th>Total Amount (RM)</th>
                <th id='tab-itemlist'>Item(s) Purchased</th>
            </tr>
        <?php 
            $length_arr = count($salesid);
            $i = 0;
            while($i < $length_arr){
                $totalAmount[$i] = number_format($totalAmount[$i],2);
        ?>
            <tr style='outline:3px solid black;'>
                <td><?php echo $salesid[$i] ?></td>
                <td><?php echo $date[$i] ?></td>
                <td><?php echo $name[$i] ?></td>
                <td><?php echo $address[$i] ?></td>
                <td><?php echo $state[$i] ?></td>
                <td><?php echo $city[$i] ?></td>
                <td><?php echo $postcode[$i] ?></td>
                <td><?php echo $cardNum[$i] ?></td> 
                <td><?php echo $totalAmount[$i] ?></td>
                <td style='height:400px;'>
                <div class='itemlist' style='overflow:auto;height:100%;'>
                <table style="width: 100%;" border="1">
                    <tr>
                        <th>Item Image</th>
                        <th style="width:150px;">Item Name</th>
                        <th>Single Price(RM)</th>
                        <th>Quantity</th>
                    </tr>
                <?php 
                foreach($itemlist[$i] as $item){
                ?>
                    <tr style="background-color:black;color:cyan;font-weight:bold;text-align:center;vertical-align:middle;">
                <?php
                    foreach($item as $details => $value){
                ?>  
               
                        <?php
                        if($details == 0){
                            echo "<td><img style='height:200px;width:200px;' src='$value'></td>";
                        }
                        elseif($details == 1){
                            echo "<td>$value</td>";
                        }
                        elseif($details == 2){
                            $value = number_format($value,2);
                            echo "<td>$value</td>";
                        }
                        elseif($details == 3){
                            echo "<td>$value</td>";
                        }
                        ?>   
                
                <?php
                    }
                ?>
                </tr>
                <?php
                }    
                ?>
                 
                </table>
                </div>
                </td>
            </tr>
            <?php
            $i++;
                }    
            ?>
        </table>
    <?php
    }
    else{    
    ?>
        <table id='historyTab' >
            <tr id='tablehead'>
                <th>Purchase ID</th>
                <th>Date</th>
                <th>Delivery Address</th>
                <th>State</th>
                <th>City</th>
                <th>Postcode</th>
                <th>Card Number Last 4 digits</th>
                <th>Total Amount</th>
                <th id='tab-itemlist'>Item(s)</th>
            </tr>
        </table>
        <h1 style='text-align:center;'>No sales record, please re-login to refresh the sales record if you just made a purchase.</h1>
    <?php 
    }
    ?>
    </div>

</div>

<?php include "include/footer.inc.php" ?>