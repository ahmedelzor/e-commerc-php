<?php 
ob_start();
session_start();

if(isset($_SESSION['Username']))
{
    $pageTitle = 'Dashboard';
    
include 'init.php';
$numusers = 5 ;
$latestusers = getlatest("*" , "users" , "Usersid" , $numusers);

$numitems = 5 ;

$latestitems = getlatest("*" , "items" , "Item_ID" , $numitems);

$numcomment = 3 ;


?>

<h1 class="text-center my-5"> <?php echo lang('DASHBOARD') ?></h1>

<div class="container text-center home-stats my-5">
    <div class="row">
            <div class="col-md-3 mb-2 stat st-members">
                <i class="fa fa-users" ></i>
        <div class="info">
        <?php echo lang('TOTAL_MEMBERS') ?>
                    <span><a href="./members.php"><?php echo countItems('Usersid' ,'users') ?></a></span>
        </div>
            </div>
            <div class="col-md-3 mb-2 stat st-pending">
                <i class="fa fa-user-plus"></i>
                <div class="info">
                <?php echo lang('PENDING_MEMBERS') ?>
                    <span><a href="./members.php?page=Pending"><?php echo checkItem("RagStatus" , "users" ,"0") ?></a></span>
                </div>          
            </div>
            <div class="col-md-3 mb-2 stat st-items">
                <i class="fa fa-tag" ></i>
                <div class="info">
                <?php echo lang('TOTAL_ITEMS') ?>
            <span><a href="./items.php"><?php echo countItems('Item_ID' ,'items') ?></a></span>
                </div>     
            </div>
            <div class="col-md-3 mb-2 stat st-comments">
                <i class="fa fa-comments"></i>
                <div class="info">
                <?php echo lang('TOTAL_COMMENTS') ?>
                <span>
                    <a href="./comments.php"><?php echo countItems('C_ID' ,'comments') ?></a></span>

                </div>
            </div>
     </div>
</div>

<div class="latest">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 mb-2">
                <div class="panel panel-default">            
                    <div class="panel-heading"> 
                        <i class="fa fa-users"> <?php echo $numusers ?> </i> <?php echo lang('LATEST_REGISTERD_USERS')?> 
                        <span class='pull-right toggle-info ml-2 '>
                        <i class="fa fa-minus"></i>
                        </span>            
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latset-users">
                           <?php 
                           if(! empty($latestusers)){
                           foreach ($latestusers as $user) {
                             echo '<li>';
                             echo  $user['Username'];
                             echo '<a href="members.php?do=Edit&userid=' . $user['Usersid'] . '">';
                             echo' <span class="badge badge-primary badge-pill">';
                             echo '</span>' ;
                             echo'</a>';
                             echo '</li>';
                                 }
                                }else {
                                    echo  'No Data';
                                }
                            ?>
                        </ul> 
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"> <?php echo $numitems ?> </i>  <?php echo lang('LATEST_ITEMS') ?>
                        <span class='pull-right toggle-info ml-2 '>
                        <i class="fa fa-minus"></i>
                        </span> 
                    </div>
                    <div class="panel-body">
                    <ul class="list-unstyled latset-users">
                           <?php 
                           if(! empty($latestitems)){
                           foreach ($latestitems as $item) {
                             echo '<li>';
                             echo  $item['Name'];
                             echo '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
                             echo' <span class="badge badge-primary badge-pill">';
                             echo '</span>' ;
                             echo'</a>';
                             echo '</li>';
                                 } 
                                }else {
                                    echo  'No Data';
                                }         
                            ?>
                        </ul> 
                    </div>
                </div>
            </div>
                        <!-- start comment -->

            <div class="col-sm-6 mb-2">
                <div class="panel panel-default">            
                    <div class="panel-heading"> 
                        <i class="fa fa-comments"> <?php echo $numcomment ?> </i> <?php echo lang('LATEST_COMMENTS')?> 
                        <span class='pull-right toggle-info ml-2 '>
                        <i class="fa fa-minus"></i>
                        </span>            
                    </div>
                    <div class="panel-body">
                        <?php 
                          $stmt = $con->prepare("SELECT comments .* ,users.Username FROM comments

                          INNER JOIN users ON users.Usersid = comments.	UserID
                          ORDER BY C_ID DESC
                          LIMIT $numcomment ");
                          
                          $stmt->execute();
                          
                          $comments = $stmt->fetchAll();
                          if(! empty($comments)){
                            foreach ($comments as $comment){
                                echo '<div class="comment-box col-md-12">';
                                echo '<span class="member-n " >' . $comment['Username'] . '</span>' ;   
                                echo '<p class="member-c " >' . $comment['Comment'] . '</p>' ; 
                                echo '</div>';
                            }
                        }else {
                            echo  'No Data';
                        }

                          ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>





<?php

include $tpl .'footer.php';

}else{

    header('location : index.php');
    
    exit();
}
ob_end_flush();
?>