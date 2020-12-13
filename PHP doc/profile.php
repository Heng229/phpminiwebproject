<?php include "include/header.inc.php" ?>
<!--Style-->
<link href="../css/profile.css?<?php echo time(); ?>"     rel="stylesheet" type="text/css">
<title>PC Outstanding - Profile</title>
<?php include "include/header2.inc.php" ?>
        <?php
            if(isset($_SESSION['idUser'])){
        ?>   
        
        <?php
             if(isset($_GET['newUname'])){
                $newunameEntered = $_GET['newUname'];
            }
            else{
                $newunameEntered = "";
            }

            if(isset($_GET['newContact'])){
                $newContactEntered = $_GET['newContact'];
            }
            else{
                $newContactEntered = "";
            }
        ?>       
        <div class="containerProfile">
        <h1 class="pageIndicator">Profile</h1>
        <div class="profileCont">
            <form action="action/logoutProcess.act.php" method="post">
                <button class="logoutButton" type="submit" name="logout-submit">Logout</button>
            </form>

            <a href="purchasehist.php"><button style="margin-top: 10px;" class="logoutButton">Purchase History</button></a>

            <div class="personalInfoBox">
                <fieldset>
                <legend><h1>Personal Information</h1></legend>
                <table>
                    <tr>
                        <td style="text-align:right">User ID :</td>
                        <td id="personalInfoStyle"><?php echo $_SESSION['idUser']; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right">Email :</td> 
                        <td id="personalInfoStyle"><?php echo $_SESSION['emailUser']; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right">Name :</td> 
                        <td id="personalInfoStyle"><?php echo $_SESSION['nameUser']; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right">Phone :</td> 
                        <td id="personalInfoStyle"><?php 
                        if(isset($_SESSION['phone'])){
                        echo $_SESSION['phone']; 
                        }else{
                        echo "No contact number uploaded.";
                        }
                        ?></td>
                    </tr>
                </table>
                </fieldset>
            </div>
        
            <div class="formContainer">
                <fieldset style="display:flex;">
                    <legend><h1>Change Information</h1></legend>
                <div class="chgPassBox">
                    <fieldset>
                    <legend>Change Password</legend>
                        <form action="action/chgPass.act.php" method="post">
                            <table>
                                <tr>
                                    <td style="text-align: right;"><label for="oldpass">Old Password:</label></td>
                                    <td><input type="password" name="oldpass" id="inputBox" placeholder="old password"></td>                                   
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><label for="newpass">New Password:</label></td>
                                    <td><input type="password" name="newpass" id="inputBox" placeholder="new password"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><label for="repeatPass">New Password Repeat:</label></td>
                                    <td><input type="password" name="repeatPass" id="inputBox" placeholder="new password repeat"></td>
                                </tr>
                                <tr>
                                    <td style="display:none;"><input type="text" name="userid" value="<?php echo $_SESSION['idUser']?>"></td>
                                </tr>
                            </table>
                            <button type="submit" id="chgButton" name="changepass-submit">Change Password</button>
                        </form>
                    </fieldset>
                </div>

                <div class="chgNameBox">
                <fieldset>
                    <legend>Change Username</legend>
                        <form action="action/chgUname.act.php" method="post">
                            <table>
                                <tr>
                                    <td>Current Username :</td>
                                    <td><span style="background-color:black;color:cyan;font-size:25px;font-weight:bold;"><?php echo $_SESSION['nameUser'] ?></span></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><label for="newUname"></label>New Username :</td>
                                    <td><input type="text" name="newUname" id="inputBox" placeholder="new username" value="<?php echo $newunameEntered ?>"></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><label for="password"></label>Password :</td>
                                    <td><input type="password" name="password" id="inputBox" placeholder="password"></td>
                                </tr>
                                <tr>
                                    <td style="display:none;"><input type="text" name="userid" value="<?php echo $_SESSION['idUser']?>"></td>
                                </tr>
                            </table>
                            <button type="submit" id="chgButton" name="changename-submit">Change Username</button>
                        </form>
                    </fieldset>
                </div>

                <div class="chgPhoneBox">
                <fieldset>
                    <legend>Change Contact</legend>
                        <form action="action/chgPhone.act.php" method="post">
                            <table>
                               <tr>
                                   <td><label for="contact">Your Contact : </label></td>
                                   <td><?php 
                                   if(isset($_SESSION['phone'])){
                                   echo "<span style='background-color:black;color:cyan;font-size:25px;font-weight:bold;'>".$_SESSION['phone'];
                                   }
                                   else{
                                   echo "<span style='color:red;font-size:17px;font-weight:bold;'>Please update your contact number(Optional).";
                                   }
                                   ?></span></td>
                               </tr>
                               <tr>
                                   <td><label for="newContact">New Contact : </label></td>
                                   <td><input type="tel" name="newContact" id="inputBox" placeholder="No dash pure digits 0121234567" value="<?php echo $newContactEntered ?>" pattern="[0]{1}[1]{1}[0-9]{1}[0-9]{7}"></td>
                               </tr>
                               <tr>
                                    <td style="text-align:right;"><label for="password"></label>Password :</td>
                                    <td><input type="password" name="password" id="inputBox" placeholder="password"></td>
                                </tr>
                               <tr>
                                    <td style="display:none;"><input type="text" name="userid" value="<?php echo $_SESSION['idUser']?>"></td>
                                </tr>
                            </table>
                            <button type="submit" id="chgButton" name="changecontact-submit">Change Contact</button>
                        </form>
                    </fieldset>
                </div>
                </fieldset>
            </div>
        </div>
    </div>

    <?php 
    #password change form alert message.
        if(isset($_GET['passformerror'])){
            if($_GET['passformerror'] == "emptyfield"){
                echo "<script>alert('Please fill up all fields in password changing form.')</script>";
            }
            elseif($_GET['passformerror'] == "wrongPass"){
                echo "<script>alert('Old password entered is incorrect.')</script>";
            }
            elseif($_GET['passformerror'] == "passlen8to12"){
                echo "<script>alert('A password must be 8 characters long or above and not more than 12 characters.')</script>";
            }
            elseif($_GET['passformerror'] == "invalidPass"){
                echo "<script>alert('A password can only consist of alphabets and numbers.')</script>";
            }
            elseif($_GET['passformerror'] == "passNotMatch"){
                echo "<script>alert('The new password and repeat password entered is not same!')</script>";
            }
            elseif($_GET['passformerror'] == "passwrong"){
                echo "<script>alert('The old password is incorrect.')</script>";
            }
        }   
        elseif(isset($_GET['updatePass'])){
            if($_GET['updatePass'] == "success")
            echo "<script>alert('Password Changed Successfully!')</script>";
        }

    #name change form alert message.
        if(isset($_GET['nameformerror'])){
            if($_GET['nameformerror'] == "emptyfield"){
                echo "<script>alert('Please fill up all fields in username changing form.')</script>";
            }
            elseif($_GET['nameformerror'] == "namelen4to12"){
                echo "<script>alert('The username must be 4 characters long or above and not more than 12 characters.')</script>";
            }
            elseif($_GET['nameformerror'] == "invaliduname"){
                echo"<script>alert('The username can only consist of alphabets and numbers.')</script>";
            }
            elseif($_GET['nameformerror'] == "passwrong"){
                echo"<script>alert('The password is incorrect.')</script>";
            }
        }
        elseif(isset($_GET['updateName'])){
            if($_GET['updateName'] == "success"){
                echo"<script>alert('The username is updated successfully! Please re-login the website to see the updated username.')</script>";
            }
        }

    #Contact change form alert message.
        if(isset($_GET['contactformerror'])){
            if($_GET['contactformerror'] == "emptyfield"){
                echo"<script>alert('Please fill up all the fields.')</script>";
            }
            elseif($_GET['contactformerror'] == "passwrong"){
                echo"<script>alert('The password is incorrect.')</script>";
            }
        }
        elseif(isset($_GET['updatePhone'])){
            if($_GET['updatePhone'] == "success"){
                echo"<script>alert('The contact number is updated successfully! Please re-login the website to see the updated contact number.')</script>";
            }
        }
    ?>

<?php 
        }else{
            echo "<script>alert('You already logged Out!.')</script>";
        }
?>

<?php include "include/footer.inc.php" ?>