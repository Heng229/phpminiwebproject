<?php include "include/header.inc.php" ?>
<!--Script -->
<script src="../javascript/homeSlide.js"></script>
<!--Style-->
<link href="../css/home.css?<?php echo time(); ?>"        rel="stylesheet" type="text/css">
<title>PC Outstanding - Home</title>
<?php include "include/header2.inc.php" ?>

<div class="container">
    <div class="slogan">
        <h1>PC Outstanding</h1><br>
        <h1>Your PC you <span style="color:red">DECIDE</span>.</h1>
    </div>

<!----------------------------------Middle Content Start--------------------------------------->
   
        <div class="slideContainer">
        <h1 style='text-align:center;'>High Performance</h1>
            <div class="slide1">
               
                <div class="slideButton">                    
                    <div class="prev" onclick="plusSlides(-1)">&#10094;</div>
                </div>
                <a href="product.php"><img src="../Product Image & video/High performance/Asus Mothership.jpg" alt="rogMothership" class="latestProd" >
                <img src="../Product Image & video/High performance/Asus_Rog_Strix.jpg" alt="rogstrix" class="latestProd">
                <img src="../Product Image & video/High performance/Dell_G5.jpg" alt="macbook" class="latestProd">
                <img src="../Product Image & video/High performance/Msi_gs75.jpg" alt="HP Envy" class="latestProd"></a>
                <div class="slideButton">                   
                    <div class="next" onclick="plusSlides(1)">&#10095;</div>
                </div>
            </div>
        </div>

        <div class="slideContainer2">
        <h1 style='text-align:center;'>Office Use</h1>
            <div class="slide2">
                <div class="slideButton">                    
                    <div class="prev" onclick="plusSlides2(-1)">&#10094;</div>
                </div>
                <a href="product.php"><img class="eventSlide" src="../Product Image & video/office use/msiwt75.jpg"  >
                <img class="eventSlide" src="../Product Image & video/office use/asus_zenbook_14.jpg">
                <img class="eventSlide" src="../Product Image & video/office use/macbookair.jpg"  >
                <img class="eventSlide" src="../Product Image & video/office use/acer_swift_7.jpg"  ></a>
                <div class="slideButton">                   
                    <div class="next" onclick="plusSlides2(1)">&#10095;</div>
                </div>
                <div class="videoContainer">
                    <video controls>
                        <source src="../Product Image & video/Introducing the new MacBook Air Apple.mp4" type="video/mp4" >
                    </video>
                </div>
            </div>

        </div>
    </div>

    <script>
        initialize();
        <?php 
            if(isset($_GET['logout'])){
                echo "alert('You had logged out successfully!')";
            }
            if(isset($_GET['login'])){
                echo "alert('You had logged in successfully!')";
            } 
        ?>
    </script>

       

<!----------------------------------Middle Content End--------------------------------------->

<?php include "include/footer.inc.php" ?>