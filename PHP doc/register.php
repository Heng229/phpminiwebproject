<?php include "include/header.inc.php" ?>
<!--Style-->
<link href="../css/register.css?<?php echo time(); ?>"    rel="stylesheet" type="text/css">
<title>PC Outstanding - Register</title>
<?php include "include/header2.inc.php" ?>
<?php if(!isset($_SESSION['idUser'])) {?>
<!---------------------------------Middle Content Start----------------------------------------->
<div class="container">
    <h1 style="text-align: center;color: gray; font-weight: bold;font-size: 50px;">Registration</h1>
    <div class=registerCont>  

        <?php 
            if(isset($_GET['email'])){
                $emailEntered = $_GET['email'];
            }
            else{
                $emailEntered = "";
            }
            if(isset($_GET['username'])){
                $unameEntered = $_GET['username'];   
            }
            else{
                $unameEntered = "";
            }
        ?>

        <form action="action/register.act.php" method="post">
              <label for="email">Email :</label>
              <input type="email" placeholder="Email" value="<?php echo $emailEntered ?>" name="email" required>
              <label for="username">Username :</label>
              <input type="username" placeholder="Username" value="<?php echo $unameEntered?>" name="username" required>
              <label for="password">Password :</label>
              <input type="password" placeholder="Password" name="password" required>
              <label for="passwordConf">Password Confirmation :</label>
              <input type="password" placeholder="Password Confirmation"   name="passwordConf" required>
              <div class="regLogButton">
              <button type="submit" name="register-submit">Register</button>
              <a href="login.php">Back to Login</a>
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
                elseif($_GET['error'] == "invalidMailUsername"){
                    echo "<script> alert('Please enter a valid email or username must consist only alphabets and numbers') </script>";
                }
                elseif($_GET['error'] == "invalidMail"){
                    echo "<script> alert('Please enter a valid email') </script>";
                }
                elseif($_GET['error'] == "invalidUsername"){
                    echo "<script> alert('Please enter a valid username with only alphabets and numbers') </script>";
                }
                elseif($_GET['error'] == "username4n12char"){
                    echo "<script> alert('Username must only consist not less than 4 characters and not more than 12 characters.') </script>";
                } 
                elseif($_GET['error'] == "userpass8n12char"){
                    echo "<script> alert('Password must consist of more than 8 characters and not more than 12 characters.') </script>";
                }
                elseif($_GET['error'] == "invalidPassword"){
                    echo "<script> alert('Password must only consist of alphabets and numbers.') </script>";
                }
                elseif($_GET['error'] == "WrongConfirmationPassward"){
                    echo "<script> alert('Confirmation password is not matched with the password.') </script>";
                }
                elseif($_GET['error'] == "emailAlreadyExist"){
                    echo "<script> alert('The email already registered.') </script>";
                }
                
            }
            elseif(isset($_GET['register'])){
                echo "<script> alert('You had successfully registered an account, please login, thank you!') </script>";
            }
        ?>
<!---------------------------------Middle Content End----------------------------------------->

<?php include "include/footer.inc.php" ?>
<?php }
else{
 header("Location: profile.php");   
}?>