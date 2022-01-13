<?php 

session_start();

include "init.php";?>



   <div class="container">
       <h1 class="text-center my-3">Show Catgories</h1>
        <div class="row">
            <?php
            foreach(getItems('Cat_ID', $_GET['pageid']) as $item){
                echo '<div class="col-lg-3 col-md-4">';
                    echo '<div class="card my-3" >';
                         echo  '<span class="Price-tag ">$' . $item['Price'] . '</span>';
                         echo '<img src="imgman.jpg" class="card-img-top" alt="">';
                         echo '<div class="card-body">';
                             echo '<h5 class="card-title"><a href="items.php?itemid= ' . $item['Item_ID'] .  '">' . $item['Name'] .  '</a></h5>';
                             echo '<p class="card-text">' . $item['Description'] . '</p>';
                             

                             if(isset($_SESSION['user'])){?>
                                 

                                <div class="card-title  btn btn-warning "><a href="market.php?do=<?php echo $_GET['pageid']?>"> <i class="fas fa-shopping-cart"></i> Buy Now</a></div>
 
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
 include $tpl .'footer.php'; ?>