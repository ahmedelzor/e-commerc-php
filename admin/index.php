<?php 
session_start();
$nonavbar = '';
$pageTitle = 'Login';

if(isset($_SESSION['Username'])){
  header('location: dashboard.php');
}
include "init.php";


if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $username = $_POST['user'];
  $pas = $_POST['pass'];
  $hashedpass = sha1($pas);

  $stmt = $con->prepare("SELECT Usersid , Username,Password FROM users WHERE Username = ?  AND Password = ? AND GroupID = 1 LIMIt 1 ");

  $stmt->execute(array($username,$hashedpass));
  $row = $stmt->fetch();
  $count = $stmt->rowCount();
  

  if($count > 0){

    $_SESSION['Username'] = $username;
    $_SESSION['ID'] = $row['Usersid'];
    header('location: dashboard.php');
    exit();
  }

}


?>

  <div class="container col-md-6 my-5">
     <h1 class ="text-center">LOGIN</h1>
      <div class="card" >
           <div class="card-body">
              <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
                   <div class="form-group">
                      <label><?php echo lang('USER_NAME') ?></label>
                      <input style="background-color: #E5E5E5;" class="form-control"  type="text" name="user" placeholder="<?php echo lang('USER_NAME') ?>" autocomplete="off" required="required">
                    </div>
                    <div class="form-group">
                      <label> <?php echo lang('PASSWORD') ?></label>
                      <input style="background-color: #E5E5E5;" class="password form-control"  type="password" name="pass" placeholder="<?php echo lang('PASSWORD') ?>" autocomplete="off" required="required">
                      <i class="show-pass far fa-eye" ></i>
                    </div>
                    <input style="margin:20px 25% ;width:50%;" class="btn btn-info  " type="submit" value="<?php echo lang('LOGIN') ?>" />

                </form>
            </div>
      </div>
</div>




<?php include $tpl .'footer.php'; ?>