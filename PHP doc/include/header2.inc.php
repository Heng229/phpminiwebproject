</head>
<body>
<!----------------------------------Navigation Bar Start--------------------------------------->
    <nav>   
        <ul>
            <a href="index.php" id="logoAnchor">
            <img src="../symbol/logo.svg" width="200" height="100">
            </a>
            <?php
            if(isset($_SESSION['nameUser'])){
                echo "<div class='usernameBox'><a href='profile.php'>Hello <span style='color:cyan;'>".$_SESSION["nameUser"]."</span>. You are Logged In, click here to go to your profile</a></div>";
            }else{
                echo "<span id='logButton'><a href='login.php'><img src='../symbol/user.svg'>&nbsp;&nbsp;&nbsp; Login/Register</a></span>";
            }
            ?>
            
            <a href="index.php"><li>Home</li></a>
            <a href="aboutUs.php"><li>About Us </li></a>
            <a href="home.php"><li id="thirdLiLogo"></li></a>
            <a href="product.php"><li>Product</li></a>
            <a href="cart.php"><li>Cart</li></a>
        </ul>
    </nav>
<!----------------------------------Navigation Bar End--------------------------------------->