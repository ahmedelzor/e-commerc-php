<?php

ob_start();
// mangae comments page 

session_start();
$pageTitle = 'Comments';

if(isset($_SESSION['Username'])){

include 'init.php';


$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
// start manage page

if($do == 'Manage'){ 

  // select all user 

  $stmt = $con->prepare("SELECT comments .* ,items.name AS Item_Name,users.Username FROM comments
  INNER JOIN items ON items.Item_ID  = comments.ItemID
  INNER JOIN users ON users.Usersid = comments.	UserID
  ORDER BY C_ID DESC
    ");
  
  // ececute the stmt

  $stmt->execute();

  // assign 

  $com = $stmt->fetchAll();
   


   if(! empty($com)){
  ?> 

    <!-- // Manage page -->
    <h1 class ="text-center my-5"><?php echo lang('MANAGE_COMMENTS') ?></h1>
    <div class="container">
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td ><?php echo lang('#ID') ?></td>
            <td><?php echo lang('COMMENT') ?></td>
            <td><?php echo lang('ITEM_NAME') ?></td>
            <td><?php echo lang('USER_NAME') ?></td>
            <td><?php echo lang('ADDING_DATE') ?></td>
            <td><?php echo lang('CONTROL') ?></td>
          </tr>
          <?php
          
          foreach($com as $com){
            echo "<tr>";
              echo "<td>" . $com['C_ID'] . "</td>";
              echo "<td>" . $com['Comment'] . "</td>";
              echo "<td>" . $com['Item_Name'] . "</td>";
              echo "<td>" . $com['Username'] . "</td>";
              echo "<td>" . $com['Comment_Date'] . "</td>";
              echo "<td>
              <a href='comments.php?do=Delete&comid=" .$com['C_ID'] ."' class='btn btn-danger far fa-trash-alt confirm'></a>";
              
              if($com['Status'] == 0){
               echo " <a href='comments.php?do=Approve&comid=" .$com['C_ID'] ."' class='btn btn-info far fa-check-square'></a>";

              }
              
              echo" </td>";
              echo"<?tr>";
          }
          ?>
        </table>
      </div>
    </div>
  
<?php 

}else {
  echo '<div class="container alert alert-danger mt-5">';
  echo ' No Comments ';
  echo '</div>';
  
}
    
}elseif($do == 'Edit'){ // Edit page 
    // check if get request comid is nomeric & get the integer value of it

$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
// select all data depend on this id


$stmt = $con->prepare("SELECT * FROM comments WHERE C_ID =? ");

  $stmt->execute(array($comid));
  $com = $stmt->fetch();
  $count = $stmt->rowCount();

  if($count >0) {?>
     

<div class="container col-md-6 my-5">
     <h1 class ="text-center mb-5"><?php echo lang('EDIT_COMMENTS') ?></h1>
      <div class="card"  >
           <div class="card-body">
              <form class="form-horizontal" action="?do=Update" method="POST" >
              <input type="hidden" name="comid" value="<?php echo $comid ?>" >
                   <div class="form-group">
                      <label><?php echo lang('COMMENT') ?></label>
                      <textarea class="form-control" name="comment" cols="30" rows="10"> <?php echo $row['Comment'] ?> </textarea>
                    </div>

                    <input style="margin:20px 25% ;width:50%;" class="btn btn-info  " type="submit" value="<?php echo lang('SAVE') ?>" />

                </form>
            </div>
      </div>
</div>

  

<?php 
   }else {
    echo "<div class='container alert alert-danger my-5'>";

    $theMsg= 'Theres No Such ID !!!!!!!!';
    redirectHome($theMsg , 'back' ,10);

    echo "</div>";
}

      
   
}elseif ($do == 'Update') { 

 

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //    get variables from the form
    $id    = $_POST['comid'];
    $comment  = $_POST['comment'];
    
    // proced update


    $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE C_ID = ? ");
 
    $stmt->execute(array($comment,$id));
    
    header('location: comments.php')  ;
    
   
   }else{
    echo "<div class='container alert alert-danger my-5'>";

    $theMsg= 'sorry you can`t browse this page directly';
    redirectHome($theMsg , 'back');
}
echo "</div>";

}elseif($do == 'Delete'){

//  Delete page

$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
// select all data depend on this id


$stmt = $con->prepare("SELECT * FROM comments WHERE C_ID=? LIMIt 1 ");

  $stmt->execute(array($comid));
  
  $count = $stmt->rowCount();

  if($count >0) {
    
    $stmt =$con->prepare("DELETE FROM comments WHERE C_ID = :zcomm");

    $stmt->bindParam(":zcomm" , $comid);

    header('location: comments.php')  ;

    $stmt->execute();
  
  }else {
    $theMsg= '<div class="container alert alert-danger mt-5" >This ID Is Not Exist</div>';
    redirectHome($theMsg);
  }

}elseif($do == 'Approve'){

  
  //  Activate page

$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
// select all data depend on this id


  $check = checkItem('C_ID' , 'comments' , $comid);

  if( $check > 0) {
    
    $stmt = $con->prepare("UPDATE comments SET `Status` = 1 WHERE C_ID = ?");

    $stmt->execute(array($comid));
    header('location: comments.php')  ;

  }else {
    $theMsg= '<div class="container alert alert-danger mt-5" >This ID Is Not Exist</div>';
    redirectHome($theMsg);
  }
  }

include $tpl .'footer.php';

}else{

    header('location: index.php');
    
    exit();
}   

ob_end_flush();
?>