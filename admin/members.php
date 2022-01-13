<?php

ob_start();
// mange members page 

session_start();
$pageTitle = 'Members';

if(isset($_SESSION['Username'])){
   

include 'init.php';


$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
// start manage page

if($do == 'Manage'){ 
  
  $query = '';
  if(isset($_GET['page']) && $_GET['page'] == 'Pending'){

    $query = 'AND RagStatus = 0';
  }
  // select all user 
  $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 2 $query ORDER BY Usersid DESC");
  // ececute the stmt
  $stmt->execute();

  // assign 

  $row = $stmt->fetchAll();
   
   if(! empty($row)){
  ?> 

    <!-- // Manage page -->
    <h1 class ="text-center my-5"><?php echo lang('MANAGE_MEMBER') ?></h1>
    <div class="container">
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td ><?php echo lang('#ID') ?></td>
            <td >image</td>
            <td><?php echo lang('USER_NAME') ?></td>
            <td><?php echo lang('EMAIL') ?></td>
            <td><?php echo lang('FULL_NAME') ?></td>
            <td><?php echo lang('REGISTERD_DATE') ?></td>
            <td>Account Type</td>
            <td><?php echo lang('CONTROL') ?></td>
            
          </tr>
          <?php
          
          foreach($row as $row){
            echo "<tr>";
              echo "<td>" . $row['Usersid'] . "</td>";
              echo "<td>";
              if(empty($row['image'])){
                      echo '<img src="./imgempty.jpg" style="width:50px" alt="">';
              }else {
                echo "<img style='width:50px;' src='uploads/img/" . $row['image'] . "' alt=''>";
              }
              
              echo"</td>";
              echo "<td>" . $row['Username'] . "</td>";
              echo "<td>" . $row['Email'] . "</td>";
              echo "<td>" . $row['Fullname'] . "</td>";
              echo "<td>" . $row['Date'] . "</td>";
              echo "<td>" . $row['GroupID'] . "</td>";
              echo "<td>
              <a href='members.php?do=Edit&userid=" .$row['Usersid'] ."' class='btn btn-success far fa-edit my-1'></a>
              <a href='members.php?do=Delete&userid=" .$row['Usersid'] ."' class='btn btn-danger far fa-trash-alt confirm'></a>";
              
              if($row['RagStatus'] == 0){
               echo " <a href='members.php?do=Activate&userid=" .$row['Usersid'] ."' class='btn btn-info far fa-check-square'></a>";

              }
              
              echo" </td>";

              echo"<?tr>";
          }
          ?>
        </table>
      </div>
    </div>

    <a class="text-center ahmed btn btn-info" href="members.php?do=Add"><i class=" fas fa-user-plus"></i>  </a>

  
<?php
}else {
  echo '<div class="container alert alert-danger mt-5">';
  echo ' No Data ';
  echo '</div>';
  echo '<div class="container mt-2">';
  echo '<a class=" mb-3 btn btn-dark" href="members.php?do=Add"><i class=" fas fa-user-plus"> </i> Add New member </a>';
  echo '</div>';
}


}elseif($do == 'Add'){?>

<!-- // add member page -->

<div class="container col-md-6 my-5">
     <h1 class ="text-center mb-5"><?php echo lang('ADD_NEW_MEMBER') ?></h1>
      <div class="card" >
           <div class="card-body">
              <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data" >
                   <div class="form-group">
                      <label><?php echo lang('USER_NAME') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control"   type="text" name="user" placeholder="<?php echo lang('USER_NAME') ?>" autocomplete="off" required="required"/>
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('PASSWORD') ?></label>  
                      <input style="background-color: #E5E5E5; " class="password form-control"  type="password" name="password" placeholder="<?php echo lang('PASSWORD') ?>" autocomplete="new-password" required="required">
                      <i class="show-pass far fa-eye" ></i>
                    </div>
                    <div class="form-group">
                      <label ><?php echo lang('EMAIL') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control"   type="email" name="mail" placeholder="<?php echo lang('EMAIL') ?>" autocomplete="off" required="required"/>
                    </div>
                    <div class="form-group">
                      <label><?php echo lang('FULL_NAME') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control"  type="text" name="full" placeholder="<?php echo lang('FULL_NAME') ?>" autocomplete="off" required="required"/>
                    </div>
                    <div class="form-group" >
                      <label> Admin</label>
                      <select class=" form-control" name="GroupID"  style="background-color: #E5E5E5; " id="" required="required"  > 
                          <option value="....">...</option> 
                          <option value="0">0</option>
                          <option value="1">1</option>
                      </select>  
                    </div>
                        <div class="form-group">
                          <label >img</label>
                          <input type="file" class="form-control" id="exampleFormControlFile1" name="image" >
                        </div>
                     

                    <input style="margin:20px 25% ;width:50%;" class="btn btn-info  " type="submit" value="<?php echo lang('ADD_MEMBER') ?>" />

                </form>
            </div>
      </div>
</div>
<?php

}elseif($do == 'Insert'){

  // insert member page
  

   if($_SERVER['REQUEST_METHOD'] == 'POST'){

  
      $imagename  = $_FILES['image']['name'];
      $imagesize  = $_FILES['image']['size'];
      $imagetmp   = $_FILES['image']['tmp_name'];
      $imagetype  = $_FILES['image']['type'];

      // lest of allow file uplode
      $imageAllowedExtension = array("jpeg" , "jpg" , "png" , "gif");
      
      // allowed extension
      
      $imageExtension = explode('.' ,$imagename);
          
  

    //    get variables from the form
    $user  = $_POST['user'];
    $pass = $_POST['password'];
    $email = $_POST['mail'];
    $name  = $_POST['full'];
    $hashpass = sha1($_POST['password']);
    $GroupID = $_POST['GroupID'];

         
    // validate the form
    $formerror = array();

    if(strlen($user) > 20 ) {

      $formerror[] ='Username Can`t Be More Than <strong> 20 Characters </strong>';
    }

    if(strlen($user) < 2 ) {

      $formerror[] ='Username Can`t Be Less Than <strong> 2 Characters </strong>';
    }
    
    if(empty($user)){
      $formerror[] ='Username  Can`t Be <strong> Empty </strong>';
    }

    if(empty($pass)){
      $formerror[] ='Password  Can`t Be <strong> Empty </strong>';
    }
    
    if(empty($name)){


      $formerror[] ='Full Name Can`t Be <strong> Empty </strong>';
    }
    if(empty($email)){

      $formerror[] ='Email Can`t Be <strong> Empty </strong>'; 
    }
    // if(! empty($imagename) && ! in_array($imageExtension,$imageAllowedExtension)){
    //   $formerror[] =' This Extension Is Not <strong> Allowed </strong>';
    // }
    // if(empty($imagename)){
    //   $formerror[] ='image Can`t Be  <strong> Empty </strong>';
    // }
    // if(empty($imagesize > 10000000)){
    //   $formerror[] ='image Size Is  <strong> over 4MB </strong>';
    // }


     foreach($formerror as $error){

      echo '<div class= "alert alert-danger">' . $error . '</div>' ;
     }

    //  cheak erorr proced Insert

    if(empty($formerror)){
      
      $image = rand(0 , 100000) . '_' .$imagename;

      move_uploaded_file($imagetmp , "uploads/img/" . $image);
      // check userinfo in database


      $check = checkItem("Username" , "users" ,$user);

      if($check == 1){
        
        echo "<div class='alert alert-danger my-5 container'>";

        $errorMsg=  'Sorry This User Is Exist';

        redirectAdd($errorMsg);

        echo "</div>";

      }else {
      

       // Insert data base

       $stmt = $con->prepare("INSERT INTO  
       users (Username , `Password` , Email  , Fullname ,RagStatus, `Date`,GroupID, `image`) 
        VALUE(:zuser , :zpass , :zmail , :zname ,1, now(),:GroupID, :zimg) ");
       $stmt->execute(array( 'zuser'  => $user, 
                            'zpass'   => $hashpass, 
                            'zmail'   => $email, 
                            'zname'   => $name ,
                            'zimg'    => $image,
                            'GroupID' => $GroupID
                           ));
       header('location: members.php')  ;
    
      }
   //   // echo success masseg
 
      // echo "<div class='alert alert-success'>" . $stmt->rowCount() .' '. 'Record Inserted </div>';
    
    
    }
  
   }else{
         echo "<div class='container alert alert-danger my-5'>";

       $theMsg= 'sorry you can`t browse this page directly';
       redirectHome($theMsg );
   }
   echo "</div>";

    
}elseif($do == 'Edit'){ // Edit page 
    // check if get request userid is nomeric & get the integer value of it

$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
// select all data depend on this id


$stmt = $con->prepare("SELECT * FROM users WHERE Usersid=? LIMIt 1 ");

  $stmt->execute(array($userid));
  $row = $stmt->fetch();
  $count = $stmt->rowCount();

  if($stmt->rowCount() >0) {?>
     

<div class="container col-md-6 my-5">
     <h1 class ="text-center mb-5"><?php echo lang('EDIT_MEMBER') ?></h1>
      <div class="card"  >
           <div class="card-body">
              <form class="form-horizontal" action="?do=Update" method="POST" >
              <input type="hidden" name="userid" value="<?php echo $userid ?>" >
                   <div class="form-group">
                      <label><?php echo lang('USER_NAME') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control" value="<?php echo $row['Username'] ?>"  type="text" name="user" placeholder="<?php echo lang('USER_NAME') ?>" autocomplete="off" required="required"/>
                    </div>
                    <div class="form-group">
                      <label> <?php echo lang('PASSWORD') ?></label>
                      <input style="background-color: #E5E5E5;" class="form-control"  type="hidden" name="oldpass" value="<?php echo $row['Password'] ?>">
                      <input style="background-color: #E5E5E5;" class="form-control"  type="password" name="newpass" placeholder="<?php echo lang('Leave_Blank_If_You_Don`t_Want_To_Change') ?>" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                      <label ><?php echo lang('EMAIL') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control" value="<?php echo $row['Email'] ?>"  type="email" name="mail" placeholder="<?php echo lang('EMAIL') ?>" autocomplete="off" required="required"/>
                    </div>
                    <div class="form-group">
                      <label><?php echo lang('FULL_NAME') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control" value="<?php echo $row['Fullname'] ?>"  type="text" name="full" placeholder="<?php echo lang('FULL_NAME') ?>" autocomplete="off" required="required"/>
                    </div>
                    <div class="form-group">
                          <label >img</label>
                          <input type="file" class="form-control" id="exampleFormControlFile1" value="<?php echo $row['image'] ?>" name="image" >
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
    $id    = $_POST['userid'];
    $user  = $_POST['user'];
    $imagename = $_POST['image'];
    $email = $_POST['mail'];
    $name  = $_POST['full'];

    // password trick

    $pass= empty($_POST['newpass']) ? $_POST['oldpass'] : sha1($_POST['newpass']);
     
    // validate the form
    $formerror = array();

    $image = rand(0 , 100000) . '_' .$imagename;

    move_uploaded_file($imagetmp , "uploads/img/" . $image);

    if(strlen($user) > 20 ) {

      $formerror[] ='Username Can`t Be More Than <strong> 20 Characters </strong>';
    }

    if(strlen($user) < 2 ) {

      $formerror[] ='Username Can`t Be Less Than <strong> 2 Characters </strong>';
    }
    
    if(empty($user)){
      $formerror[] ='Username  Can`t Be <strong> Empty </strong>';
    }
    if(empty($name)){


      $formerror[] ='Full Name Can`t Be <strong> Empty </strong>';
    }
    if(empty($email)){

      $formerror[] ='Email Can`t Be <strong> Empty </strong>'; 
    }

     foreach($formerror as $error){

      echo '<div class= "alert alert-danger">' . $error . '</div>' ;
     }

    //  cheak erorr proced update


    if(empty($formerror)){


       // update data base
       $stmt2 = $con->prepare("SELECT * FROM users WHERE Username =? AND Usersid != ?");
       
       $stmt2->execute(array($user , $id));
       
       $count = $stmt2->rowCount();

       if($count == 1){
        echo '<div class="container alert alert-danger mt-5">';
        $theMsg= ' Sorry This User Is Exist';
        redirectHome($theMsg , 'back');
        echo '</div>';
       }else{

    $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , Fullname = ?, `Password` = ? ,`image`= ? WHERE Usersid = ? ");
 
    $stmt->execute(array($user,$email,$name,$pass,$imagename, $id));
    
    header('location: members.php')  ;
       }
   
    }
    
   
   }else{
    echo "<div class='container alert alert-danger my-5'>";

    $theMsg= 'sorry you can`t browse this page directly';
    redirectHome($theMsg , 'back');
}
echo "</div>";

}elseif($do == 'Delete'){

//  Delete page

$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
// select all data depend on this id


$stmt = $con->prepare("SELECT * FROM users WHERE Usersid=? LIMIt 1 ");

  $stmt->execute(array($userid));
  
  $count = $stmt->rowCount();

  if($count >0) {
    
    $stmt =$con->prepare("DELETE FROM users WHERE Usersid = :zuser");

    $stmt->bindParam(":zuser" , $userid);

    header('location: members.php')  ;

    $stmt->execute();

  }else {
    $theMsg= '<div class="container alert alert-danger mt-5" >This ID Is Not Exist</div>';
    redirectHome($theMsg);
  }

}elseif($do == 'Activate'){

  
  //  Activate page

$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
// select all data depend on this id


  $check = checkItem('Usersid' , 'users' , $userid);

  if( $check > 0) {
    
    $stmt = $con->prepare("UPDATE users SET RagStatus = 1 WHERE Usersid = ?");

    $stmt->execute(array($userid));
    header('location: members.php?page=Pending')  ;

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