<?php 


session_start();
$pageTitle = ' Show Items';

include "init.php";


$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
// select all data depend on this id


$stmt = $con->prepare("SELECT items .* ,categories.name AS category_Name,users.Username FROM items
                       INNER JOIN categories ON categories.ID = items.Cat_ID 
                       INNER JOIN users ON users.Usersid = items.Member_ID
                       WHERE Item_ID=? 
                       AND Approve = 1");

  $stmt->execute(array($itemid));

  $count = $stmt->rowCount();

  if ($count > 0){

 

  $item = $stmt->fetch();

?>
            
            <div class="information my-5 block">
                <div class="container">
                        <h1 class="ml-3 my-4"><?php echo $item['Name'] ?></h1>
                    <div class="media">
                        <div class="col-md-6">
                        <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active" data-interval="10000">
                                        <img src="./imgman.jpg"  class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item" data-interval="2000">
                                        <img src="./imgman.jpg" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                        <img src="./imgman.jpg" class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                    <i class="carousel-control-prev" type="i" data-target="#carouselExampleInterval" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </i>
                                    <i class="carousel-control-next" type="i" data-target="#carouselExampleInterval" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </i>
                                    </div>
             </div>
        
        <div class="media-body">
            <h2 class=" ml-4"> <?php echo $item['Name'] ?></h2>
            <p class="my-3 ml-4"> <?php echo $item['Description'] ?></p>
                <ul>
                    <li><strong> Add Date </strong> :<?php echo $item['Add_Date'] ?></li>
                    <li><strong> Price    </strong> :<?php echo $item['Price'] ?></li>
                    <li><strong> Made In  </strong> :<?php echo $item['Country_Made'] ?></li>
                    <li><strong> Category </strong> :<a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"> <?php echo $item['category_Name'] ?></a></li>
                    <li><strong> Add By   </strong> :<a href=""><?php echo $item['Username'] ?></a>  </li>
                 <?php   if(isset($_SESSION['user'])){?>
                                 

                                 <div class="card-title  btn btn-warning "><a href="market.php"> <i class="fas fa-shopping-cart"></i> Buy Now</a></div>
  
                              <?php
  
  
                          
                   }else {
                       echo '<div class="card-title  btn btn-warning "><a href="login.php"> <i class="fas fa-shopping-cart"></i> Buy Now </a> </div>';
                      }
        ?>
                    
            </ul>
         </div>
        </div>
    </div>
    
</div>
  
          <div class="container">
              <hr>
              <?php 
                 if(isset($_SESSION['user'])){ ?>

              <div class="row">
                  <div class="col-md-offset-3">
                      <h3>Add Your Comment</h3>
                      <form  method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>">
                      <textarea style="display:block; " required name="comment" id="" cols="100%" rows="3"></textarea>
                          <input class="btn btn-info mt-2"  type="submit" value="Add Comment">
                        </form>
                        <?php
                           if($_SERVER['REQUEST_METHOD'] == 'POST'){
                              $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                              $itemsid = $item['Item_ID'];
                              $userid  = $_SESSION['uid'];

                              if(! empty($comment)){

                                $stmt = $con->prepare("INSERT INTO
                                                  comments(Comment, `Status` , Comment_Date ,ItemID ,UserID )
                                                  VALUES  (:zcomment , 0 , NOW() , :zitemid , :zuserid)");

                                $stmt->execute(array(
                                    'zcomment' => $comment,
                                    'zitemid'  => $itemsid,
                                    'zuserid'  => $userid
                                ));

                                if($stmt){

                                    echo '<div class="alert alert-success">Comment Added</div>';
                                }                 
                              }
                             
                           }
                           ?>
                  </div>
              </div>
              <?php  }else {
                  echo '<a href="login.php">Login</a> To Add <a href="login.php">Register</a> To Add Comment';
              } 
               ?>
          <hr>
          <?php
                         
                         $stmt = $con->prepare("SELECT 
                         comments .* ,users.Username FROM comments
                         INNER JOIN users ON users.Usersid = comments.UserID
                         WHERE ItemID =?
                         AND Status = 1 
                         ORDER BY C_ID DESC
                             ");
                         
                         // ececute the stmt
 
                         $stmt->execute(array($item['Item_ID']));
 
                         // assign 
 
                         $comments = $stmt->fetchAll();
                
                 foreach($comments as $comment){?>
                     <div class="row mb-5">
                     <div class="col-md-4"><img class="imgcomment" style="width:50px; border-radius:50%;" src="login.jpg" alt=""><strong class="ml-3"><?php echo $comment['Username'] ?></strong>  </div>
                     <div class="col-md-12 mt-4 "> <?php echo  $comment['Comment'] ?> </div>
                     </div>
                     <hr>
               <?php }?>
                
                
              </div>
          </div>
<?php
  }else {
      echo '<div class="container my-5 alert alert-danger">There Is No Such Id Or This Item Is Wating Approval</div>';
  }


 include $tpl .'footer.php';
?>