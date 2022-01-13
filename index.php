<?php 

ob_start();
session_start();
$pageTitle = 'Home Page';

include "init.php";?>
   
   <div class="container">
        <div class="row" >
            <?php
            $allItems = getAllFrom('*','items' , 'where Approve = 1' ,'' , 'Item_ID' );
            foreach($allItems as $item){
                echo '<div class="col-lg-3 col-md-4">';
                    echo '<div class="card my-3" >';
                         echo  '<span class="Price-tag ">$' . $item['Price'] . '</span>';
                         echo '<img src="imgman.jpg" class="card-img-top" alt="">';
                         echo '<div class="card-body">';
                             echo '<h5 class="card-title"><a href="items.php?itemid= ' . $item['Item_ID'] .  '">' . $item['Name'] .  '</a></h5>';
                             echo '<p class="card-text">' . $item['Description'] . '</p>';
                             
                             echo '<div class="date">' . $item['Add_Date'] . '</div>';
                          if(isset($_SESSION['user'])){?>
                                 

                               <div class="card-title  btn btn-warning "><a href="market.php? "> <i class="fas fa-shopping-cart"></i> Buy Now</a></div>

                            <?php


                        
                 }else {
                     echo '<div class="card-title  btn btn-warning "><a href="login.php"> <i class="fas fa-shopping-cart"></i> Buy Now </a> </div>';
                    }
               


                         echo '</div>';
                    echo '</div> ';       
                echo '</div>';
            }

            
                
            ?>

        </div>
    </div>

<?php
 include $tpl .'footer.php';
 ob_end_flush();
  ?>