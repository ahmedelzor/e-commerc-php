<?php 
ob_start();
session_start();
$pageTitle = 'Login';
if(isset($_SESSION['user'])){

    header('location: index.php');
  }


include "init.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['login'])){

    $user = $_POST['username'];
    $pass = $_POST['password'];

    $hashedpass = sha1($pass);
  
    $stmt = $con->prepare("SELECT Usersid, Username,`Password` FROM users WHERE Username = ?  AND Password = ?  ");
  
    $stmt->execute(array($user,$hashedpass));

    $get = $stmt->fetch();

    $count = $stmt->rowCount();
    
  
    if($count > 0){
  
      $_SESSION['user'] = $user;
      $_SESSION['uid'] = $get['Usersid']; 
      header('location: index.php');
      exit();
    }
  
  }else {
      $formErrors = array();
      
    
      
    

      $username = $_POST['user'];
      $password = $_POST['pass'];
      $email    = $_POST['mail'];
      $password2= $_POST['pass2'];
      $name     = $_POST['full'];

    //   filter security
      if(isset($username)){

          $filterdUser = filter_var($username,FILTER_SANITIZE_STRING);

          if(strlen($filterdUser)< 2){
              $formErrors[] = 'user more than 2 chracters';
          }
      }
      if(isset($password) && isset($password2)) {

        if (empty(sha1($password))) {
            $formErrors[] = 'Sorry Password Is Empty ';
        }
          

        if (sha1($password) !== sha1($password2)) {
            $formErrors[] = 'Sorry Password Is Not Match';
        }
       
    }
    if(isset($email)){
    $filterdEmail = filter_var($email,FILTER_SANITIZE_EMAIL);

    if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {
        
        $formErrors[] = 'This Email Is Not Valid';

    }
   }
   if(empty($formerror)){

    

   
    // check userinfo in database proced user add


    $check = checkItem("Username" , "users" ,$username);

    if($check == 1){
      
        $formErrors[] =  'Sorry This User Is Exist';

    }else {
    

     // Insert data base

     $stmt = $con->prepare("INSERT INTO
                              users (Username , `Password` , Email  , Fullname ,RagStatus, `Date` )  
                              VALUES(:zuser , :zpass , :zmail , :zname ,0, now())");
     $stmt->execute(array( 'zuser' => $username, 'zpass' => sha1($password), 'zmail' => $email, 'zname' => $name ,  ));
     
     $succesMsg = 'Congrats You Are Now Registerd User';

    //  header('location: login.php')  ;
  
    }
  
  }
 

   }
  
}


?>



<div class="container my-5 login-page ">
     <h1 class ="text-center my-3">
         <span data-class="login" class=" selected">Sign In </span>  | <span data-class="signup">Sign Up</span>
        </h1>
<!--   start login form -->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="card" style="width:100%" >
                 <div class="card-body">
                    <form>
                         <div class="form-group">
                            <label><?php echo lang('USER_NAME') ?></label>
                            <input style="background-color: #E5E5E5;" class="form-control"  type="text" name="username" placeholder="<?php echo lang('USER_NAME') ?>" autocomplete="off" required="required">
                        </div>
                        <div class="form-group">
                            <label> <?php echo lang('PASSWORD') ?></label>
                            <input style="background-color: #E5E5E5;" class="password form-control"  type="password" name="password" placeholder="<?php echo lang('PASSWORD') ?>" autocomplete="new-password" required="required">
                            <i class="show-pass far fa-eye" ></i>
                        </div>
                            <input style="margin:20px 25% ;width:50%;" class="btn btn-primary " name="login" type="submit" value="<?php echo lang('LOGIN') ?>" />
                   </form>
                 </div>
             </div>
        </form>
        <!--   start sign up form -->
                <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="card" style="width:100%" >
                        <div class="card-body">
                            <form >
                                <div class="form-group">
                                        <label><?php echo lang('USER_NAME') ?></label>
                                        <input pattern=".{2,}" title="Username Must Be Than 2 Chars" style="background-color: #E5E5E5;" class="form-control"  type="text" name="user" placeholder="<?php echo lang('USER_NAME') ?>" autocomplete="off" required="required">
                                </div>
                                <div class="form-group">
                                        <label> <?php echo lang('PASSWORD') ?></label>
                                        <input minlength="6"  style="background-color: #E5E5E5;" class="password form-control"  type="password" name="pass" placeholder="<?php echo lang('PASSWORD') ?>" autocomplete="off" required="required">
                                        <i class="show-pass far fa-eye" ></i>
                                </div>
                                <div class="form-group">
                                        <label> Check Password</label>
                                        <input minlength="6" style="background-color: #E5E5E5;" class=" form-control"  type="password" name="pass2" placeholder="Check Password" autocomplete="off" required="required">
                                </div>
                                <div class="form-group">
                                        <label >EMAIL</label>
                                        <input style="background-color: #E5E5E5;" class="form-control"  type="email" name="mail" placeholder="Email" required="required">
                                </div>
                                <div class="form-group">
                                        <label>FULL NAME</label>
                                        <input style="background-color: #E5E5E5;" class="form-control"  type="text" name="full" placeholder="Full name" autocomplete="off" required="required" >
                                </div>

                                <div class="form-group">
                                    <label >Image</label>
                                    <input type="file" class="form-control" style="background-color: #E5E5E5;" id="exampleFormControlFile1" value="<?php echo $row['image'] ?>" name="image">
                                </div>
                                        <input style="margin:20px 25% ;width:50%;" class="btn btn-success" name="signup" type="submit" value=SginUp />
                            </form>
                       </div>
                   </div>
               </form>   
               <div class="the-errors text-center">
               <?php 
               if(! empty($formErrors)){
                   foreach($formErrors as $error){
                       echo '<div class="the-errors text-center alert alert-danger " style="border-radius: 20px;">';
                       echo $error . '<br>';
                       echo'</div>';
                   }
               }
               if (isset($succesMsg)) {
                   echo '<div class="text-center alert alert-succses" style="border-radius: 20px;"> ' . $succesMsg . '</div>';
               }
               ?>
               </div>
         </div>



<?php
 include $tpl .'footer.php'; 
 ob_end_flush();
 ?>