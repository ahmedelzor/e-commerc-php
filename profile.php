<?php 


session_start();
$pageTitle = ' Profile';

include "init.php";
if(isset($_SESSION['user'])){

    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ? ");

    $getUser->execute(array($sessionUser));

    $info = $getUser->fetch();
    $userid = $info['Usersid'];
    $do='';


?>
<div class="information my-5 block">
    <div class="container">
            <h1>My Profile</h1>
        <div class="media">
        <img src="./login.jpg" class="align-self-start mr-3" style="width:250px;height: 200px;" alt="...">
        <div class="media-body">
            <h3 class="mt-0"> <i class="fa fa-unlock fa-fw"></i> <?php echo $info['Username']  ?></h3>
            <p><i class="fa fa-user fa-fw"></i> <strong>Full Name : </strong>  <?php echo $info['Fullname'] ?> </p>
            <p> <i class="far fa-envelope fa-fw"></i> <strong>Email :</strong>  <?php echo $info['Email'] ?></p>
            <p> <i class="far fa-calendar-alt fa-fw"></i> <strong>Registerd Date :</strong>  <?php echo $info['Date'] ?></p>
            <p> <i class="fa fa-tag fa-fw"></i> <strong>Fav Category : </strong> </p>
             <div class="btn btn-info">
                 <?php
           echo  "<a href='member.php?do=Edit&userid=" . $info['Usersid'] . "' class='btn btn-info far fa-edit '>Edit Profile</a>";
             ?>
             </div>
        </div>
        </div>
    </div>
</div>
        
       <div id="my-Ads" class="my-Ads my-5 block">
            <div class="container">
             <div class="col-sm-12 mb-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-tag"> </i> Latest Items
                    </div>
                    <div class="panel-body">
                    
            <?php
            $myItems = getAllFrom("*" , "items" ,"where Member_ID = $userid " ,"" , "Item_ID");
            if(! empty($myItems)) {
                echo '<div class="row">';
            foreach($myItems as $item){
                echo '<div class="col-lg-4  col-md-4">';
                    echo '<div class="card item my-3" >';
                    if($item['Approve'] == 0) {
                        echo '<span class="approve-status">Waiting Approve</span>';
                    } 
                         echo  '<span class="Price-tag ">' . $item['Price'] . '</span>';
                         echo '<img src="imgman.jpg" class="card-img-top" alt="">';
                         echo '<div class="card-body tools">';
                             echo '<h5 class="card-title"><a href="items.php?itemid= ' . $item['Item_ID'] .  '">' . $item['Name'] .  '</a></h5>';
                             echo '<p class="card-text">' . $item['Description'] . '</p>';
                             echo '<div class="date">' . $item['Add_Date'] . '</div>';
                         echo '</div>';
                    echo '</div> ';       
                echo '</div>';
            }
            echo '</div>';
        }else {
            echo'There are no Ads for you on the site , Create <a href="./newad.php">New Ads</a> ';
           
            
        }
            ?>
        
                    </div>
                </div>
            </div>
        </div>

        <div id="my-comment" class="my-comment my-5 block">
            <div class="container">
             <div class="col-sm-12 mb-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-comment"> </i> Latest Comments
                    </div>
                    <div class="panel-body">
                   <?php  
                   
                   $myComments = getAllFrom("Comment" , "comments" ,"where UserID = $userid"  ,"" , "C_ID");

                       if(! empty($myComments)){

                        foreach($myComments as $comment){
                            echo '<p>' . $comment['Comment'] . '</p>';
                        }

                       }else{
                         echo'There are no comments for you on the site';


                       }


                    
                   ?>
                    </div>
                </div>
            </div>
        </div>

<?php
}else{
    header('location: login.php');
    exit();
}

 include $tpl .'footer.php';
?>