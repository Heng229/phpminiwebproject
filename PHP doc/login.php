<?php include "include/header.inc.php" ?>
<!--Style-->
<link href="../css/login.css?<?php echo time(); ?>"       rel="stylesheet" type="text/css">
<title>PC Outstanding - Login</title>
<?php include "include/header2.inc.php" ?>
<?php if(!isset($_SESSION['idUser'])) {?>
<!---------------------------------Middle Content Start----------------------------------------->

<?php 
    if(isset($_GET['email'])){
        $email = $_GET['email'];
    }
    else{
        $email = "";
    }
?>


<div class="container">
    <div class=loginCont>
        <form action="action/loginProcess.act.php" method="post">
            <div class="labelForm">
                <label for="email">Login Email :</label>
                <input type="email" name="email" placeholder="email" value="<?php echo $email ?>" required>
            </div>
            <div class="labelForm">
                <label for="password">Password &nbsp;&nbsp;&nbsp;:</label>
                <input type="password" name="passwordget" placeholder="password" required>
            </div>
            <div class="formButton">
            <button type="submit" name="login-submit">Login</button>
            <a href="register.php">
            <div  class="register">
            Register Now!
            </div>
            </a> 
            </div>
        </form>
    </div>
</div>
<!--Error Message Alert-->
        <?php 
            if(isset($_GET['error'])){
                if($_GET['error'] == "emptyfields"){
                    echo "<script> alert('Please fill in all the fields') </script>";
                }
                elseif($_GET['error'] == "passOremailInvalid"){
                    echo "<script> alert('Password is incorrect.') </script>";
                }
                elseif($_GET['error'] == "invalidUser"){
                    echo "<script> alert('Email is invalid or not registered.') </script>";
                }
            }
        ?>

<!---------------------------------Middle Content End----------------------------------------->

<?php include "include/footer.inc.php" ?>
<?php }
else{
 header("Location: profile.php");   
}?>