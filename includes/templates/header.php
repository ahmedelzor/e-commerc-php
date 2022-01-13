<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php getTitle() ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">
</head>
<body >
   
 <div class="Upper-nav">
   <div class="container">
      <?php 
          if(isset($_SESSION['user'])){?>

            <div class="btn-group my-info">
            <li style="list-style-type: none; margin:5px"><i class="fas fa-shopping-cart"></i><a href="./market.php">My Cart</a></li>
            <img class="mr-3" src="./imgman.jpg" style="width:30px;border-radius: 50%;" alt="">
              <span class="btn dropdown-toggle" data-toggle = "dropdown">
                    <?php echo $sessionUser?>  
                    <span class="caret"></span>
                    </span>
                    <ul class="dropdown-menu">
                      <li><a href="./profile.php">My Profile</a></li>
                      <li><a href="./profile.php#my-comment">My Comments</a></li>
                      <li><a href="./profile.php#my-Ads">My Items</a></li>
                      <li><a href="./newad.php">New Items</a></li>
                      <li><i class="fas fa-shopping-cart"></i><a href="./market.php">My Cart</a></li>
                      <li><a href="./logout.php">Log Out</a></li>
                    </ul>
              
            </div>
            


          <?php

            }else{

            ?>
     <a href="./login.php">Login </a>
       <?php } ?>

   </div>

 </div>




    <!-- start navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="./index.php"><img src="./logo 1.png" style="width:100px;" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <?php  

                
                
                $categories = getCat();

                foreach($categories as $cat){

                echo '<li><a class="ahmed "
                 href="./categories.php?pageid='. $cat['ID'] .'">
                ' . $cat['name'] . '</a></li>';
                }
        ?>
    </ul>
  </div>
</nav>