<!-- items template  -->

<?php
  ob_start();

  session_start();

  $pageTitle = 'Items';

  if(isset($_SESSION['Username'])){
    

include 'init.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


 if ($do == 'Manage'){
    
 
  // select all items
  $stmt = $con->prepare("SELECT items .* ,categories.name AS category_Name,users.Username FROM items
                         INNER JOIN categories ON categories.ID = items.Cat_ID 
                         INNER JOIN users ON users.Usersid = items.Member_ID
                         ORDER BY Item_ID DESC
                         ");
  // ececute the stmt
  $stmt->execute();

  // assign 

  $items = $stmt->fetchAll();
   

    if(! empty($items)){
  ?> 

    <!-- // Manage page -->
    <h1 class ="text-center my-5"><?php echo lang('MANAGE_ITEMS') ?></h1>
    <div class="container">
    <a class=" mb-3 btn btn-dark" href="items.php?do=Add"><i class=" fas fa-user-plus"></i>  </a>
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td ><?php echo lang('#ID') ?></td>
            <td colspan=3>images</td>
            <td><?php echo lang('NAME') ?></td>
            <td><?php echo lang('DESCRIPTION') ?></td>
            <td><?php echo lang('PRICE') ?></td>
            <td><?php echo lang('ADDING_DATE') ?></td>
            <td><?php echo lang('CATEGORY') ?></td>
            <td><?php echo lang('USER_NAME') ?></td>
            <td><?php echo lang('CONTROL') ?></td>
            
          </tr>
          <?php
          
          foreach($items as $item){
            echo "<tr>";
              echo "<td>" . $item['Item_ID'] . "</td>";
              echo "<td>";
              if(empty($item['image'])){
                       echo '<img src="./imgempty.jpg" style="width:50px" alt="">';
              }else {
                echo "<img style='width:50px;' src='./uploads/img/" . $item['image1'] . "' alt=''>";
              }             
              echo"</td>";
              echo "<td>";
              if(empty($item['image'])){
                       echo '<img src="./imgempty.jpg" style="width:50px" alt="">';
              }else {
                echo "<img style='width:50px;' src='./uploads/img/" . $item['image2'] . "' alt=''>";
              }
              echo"</td>";
              echo "<td>";
              if(empty($item['image'])){
                       echo '<img src="./imgempty.jpg" style="width:50px" alt="">';
              }else {
                echo "<img style='width:50px;' src='./uploads/img/" . $item['image3'] . "' alt=''>";
              }              
              echo"</td>";
              echo "<td>" . $item['Name'] . "</td>";
              echo "<td>" . $item['Description'] . "</td>";
              echo "<td>" . $item['Price'] . "</td>";
              echo "<td>" . $item['Add_Date'] . "</td>";
              echo "<td>" . $item['category_Name'] . "</td>";
              echo "<td>" . $item['Username'] . "</td>";
              echo "<td>
              <a href='items.php?do=Edit&itemid=" .$item['Item_ID'] ."' class='btn btn-success far fa-edit my-1'></a>
              <a href='items.php?do=Delete&itemid=" .$item['Item_ID'] ."' class='btn btn-danger far fa-trash-alt confirm'></a>";            
              if($item['Approve'] == 0){
                echo " <a href='items.php?do=Approve&itemid=" .$item['Item_ID'] ."' class='btn btn-info far fa-check-square Activate'></a>";
 
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
    echo ' No Data ';
    echo '</div>';
    echo '<div class="container mt-2">';
    echo '<a class=" mb-3 btn btn-dark" href="items.php?do=Add"><i class=" fas fa-user-plus"> </i> Add New Item </a>';
    echo '</div>';
  }

 }elseif ($do == 'Add'){?>

<div class="container col-md-6 my-5">
     <h1 class ="text-center mb-5"><?php echo lang('ADD_NEW_ITEMS') ?></h1>
      <div class="card" >
           <div class="card-body">
              <form class="form-horizontal" action="?do=Insert" method="POST" >
                   <div class="form-group">
                      <label><?php echo lang('ITEM_NAME') ?></label>
                      <input style="background-color: #E5E5E5;" class="form-control"   type="text" name="name" placeholder="<?php echo lang('ITEM_NAME') ?>" required="required" />
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('DESCRIPTION') ?></label>
                      <input style="background-color: #E5E5E5; " class=" form-control"  type="text" name="description" placeholder="<?php echo lang('DESCRIPTION') ?>" required="required" >  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('PRICE') ?></label>
                      <input style="background-color: #E5E5E5; " class=" form-control"  type="text" name="Price" placeholder="<?php echo lang('PRICE') ?>" required="required" >  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('COUNTRY_MADE') ?></label>
                      <input style="background-color: #E5E5E5; " class=" form-control"  type="text" name="country" placeholder="<?php echo lang('COUNTRY_MADE') ?>" required="required" >  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('STATUS') ?></label>
                      <select class=" form-control" name="status"  style="background-color: #E5E5E5; " id="" required="required"  > 
                          <option value="0">...</option> 
                          <option value="1"><?php echo lang('NEW') ?></option>
                          <option value="2"><?php echo lang('USED') ?></option>
                      </select>  
                    </div>
                   <div class="form-group" >
                      <label> <?php echo lang('MEMBER') ?></label>
                      <select class=" form-control" name="member"  style="background-color: #E5E5E5; " id="" required="required"  > 
                          <option value="0">...</option> 
                          <?php 
                          
                          $stmt = $con->prepare("SELECT * FROM users");
                          $stmt->execute();
                          $users = $stmt->fetchAll();
                          foreach ($users as $user){
                              echo "<option value='" . $user['Usersid'] ."'> " . $user['Username'] ." </option>";
                          }
                          ?>
                      </select>  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('CATEGORY') ?></label>
                      <select class=" form-control" name="category"  style="background-color: #E5E5E5; " id="" required="required"  > 
                          <option value="0">...</option> 
                          <?php 
                          $stmt2 = $con->prepare("SELECT * FROM categories WHERE Parent =0");
                          $stmt2->execute();
                          $cats = $stmt2->fetchAll();
                          foreach ($cats as $cat){
                              echo "<option value='" . $cat['ID'] ."'> " . $cat['name'] ." </option>";
                          }
                          ?>
                      </select>  
                    </div>
                    <div class="form-group">
                          <label >image1</label>
                          <input type="file" class="form-control" id="exampleFormControlFile1" value="<?php echo $row['image'] ?>" name="image1">
                        </div>
                        <div class="form-group">
                          <label >image2</label>
                          <input type="file" class="form-control" id="exampleFormControlFile1" value="<?php echo $row['image'] ?>" name="image2">
                        </div>
                        <div class="form-group">
                          <label >image3</label>
                          <input type="file" class="form-control" id="exampleFormControlFile1" value="<?php echo $row['image'] ?>" name="image3">
                        </div>
                    
  
                      </select>  
                    </div>
                    <input style="margin:20px 25% ;width:50%;" class="btn btn-info  " type="submit" value="<?php echo lang('ADD_ITEM') ?>" />

                </form>
            </div>
      </div>
</div>



<?php
 }elseif ($do == 'Insert'){

    // insert itmes  page


   if($_SERVER['REQUEST_METHOD'] == 'POST'){

    echo  "<h1 class ='text-center mb-5'> Insert itmes </h1>";
    echo "<div class='container'>";

    $itemimg1name  = $_FILES['image1']['name'];
    $itemimg1size  = $_FILES['image1']['size'];
    $itemimg1tmp   = $_FILES['image1']['tmp_name'];
    $itemimg1type  = $_FILES['image1']['type'];

    $itemimg2name  = $_FILES['image2']['name'];
    $itemimg2size  = $_FILES['image2']['size'];
    $itemimg2tmp   = $_FILES['image2']['tmp_name'];
    $itemimg2type  = $_FILES['image2']['type'];

    $itemimg3name  = $_FILES['image3']['name'];
    $itemimg3size  = $_FILES['image3']['size'];
    $itemimg3tmp   = $_FILES['image3']['tmp_name'];
    $itemimg3type  = $_FILES['image3']['type'];

    // lest of allow file uplode
    $imageAllowedExtension = array("jpeg" , "jpg" , "png" , "gif");
    
    // allowed extension
    
    $image1Extension = explode('.' ,$itemimg1name);
    $image2Extension = explode('.' ,$itemimg2name);
    $image3Extension = explode('.' ,$itemimg3name);

    //    get variables from the form
    $name       = $_POST['name'];
    $desc       = $_POST['description'];
    $Price      = $_POST['Price'];
    $country    = $_POST['country'];
    $status     = $_POST['status'];
    $category   = $_POST['category'];
    $member     = $_POST['member'];
    

         
    // validate the form
    $formerror = array();

    
    if(empty($name)){
      $formerror[] ='Name Can`t Be <strong> Empty </strong>';
    }

    if(empty($desc)){
      $formerror[] ='Description Can`t Be <strong> Empty </strong>';
    }
    
    if(empty($Price)){

      $formerror[] ='Price  Can`t Be <strong> Empty </strong>';
    }
    if(empty($country)){

      $formerror[] ='Country Can`t Be <strong> Empty </strong>'; 
    }
    if($status == 0){

      $formerror[] ='You Mast Choose <strong> Status </strong>'; 
    }
    if($member == 0){
        $formerror[] ='You Mast Choose <strong> Member </strong>';
    }
    if($category == 0){
        $formerror[] ='You Mast Choose <strong> Category </strong>';
    }
    

     foreach($formerror as $error){

      echo '<div class= "alert alert-danger">' . $error . '</div>' ;
     }

    //  cheak erorr proced Insert

    if(empty($formerror)){

      $image1 = rand(0 , 200000) . '_' .$itemimg1name;
      $image2 = rand(0 , 300000) . '_' .$itemimg2name;
      $image3 = rand(0 , 400000) . '_' .$itemimg3name;

      move_uploaded_file($itemimg1tmp , "./uploads/img/" . $image1);
      move_uploaded_file($itemimg2tmp , "./uploads/img/" . $image2);
      move_uploaded_file($itemimg3tmp , "./uploads/img/" . $image3);
      
       // Insert data base

       $stmt = $con->prepare("INSERT INTO
       items (`Name` , `Description` , Price  , Country_Made , image1, image2, image3 ,`Status` , Add_Date ,  Cat_ID, Member_ID	 ) 
       VALUE(:zname , :zdesc , :zprice , :zcountry, :img1 , :img2 , :img3 ,:zstatus, now() , :zcategory , :zmember )");
       $stmt->execute(array( 
           'zname'      => $name, 
           'zdesc'      => $desc, 
           'zprice'     => $Price, 
           'zcountry'   => $country,
           'img1'       => $image1,
           'img2'       => $image2,
           'img3'       => $image3,
           'zstatus'    => $status,
           'zcategory'  => $category,
           'zmember'    => $member
        ));

       header('location: items.php')  ;
    
    
    }
   
   }else{
         echo "<div class='container alert alert-danger my-5'>";

       $theMsg= 'sorry you can`t browse this page directly';
       redirectHome($theMsg);
   }
   echo "</div>";
   
  
}elseif($do == 'Edit'){

    //Edit page 
    // check if get request itemid is nomeric & get the integer value of it

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
// select all data depend on this id


$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID=?");

  $stmt->execute(array($itemid));
  $item = $stmt->fetch();
  $count = $stmt->rowCount();

  if($count > 0) {?>
     

     <div class="container col-md-6 my-5">
     <h1 class ="text-center mb-5"><?php echo lang('EDIT_ITEMS') ?></h1>
      <div class="card" >
           <div class="card-body">
              <form class="form-horizontal" action="?do=Update" method="POST" >
              <input type="hidden" name="itemid" value="<?php echo $itemid ?>" >    
              <div class="form-group">
                      <label><?php echo lang('ITEM_NAME') ?></label>
                      <input style="background-color: #E5E5E5;" class="form-control"   type="text" name="name" placeholder="<?php echo lang('ITEM_NAME') ?>" required="required"  value ="<?php echo $item['Name']?>"/>
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('DESCRIPTION') ?></label>  <i class="fas fa-asterisk fa-1px"></i>
                      <input style="background-color: #E5E5E5; " class=" form-control"  type="text" name="description" placeholder="<?php echo lang('DESCRIPTION') ?>" required="required"value ="<?php echo $item['Description']?>" >  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('PRICE') ?></label>  <i class="fas fa-asterisk fa-1px"></i>
                      <input style="background-color: #E5E5E5; " class=" form-control"  type="text" name="Price" placeholder="<?php echo lang('PRICE') ?>" required="required"value ="<?php echo $item['Price']?>" >  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('COUNTRY_MADE') ?></label>  <i class="fas fa-asterisk fa-1px"></i>
                      <input style="background-color: #E5E5E5; " class=" form-control"  type="text" name="country" placeholder="<?php echo lang('COUNTRY_MADE') ?>" required="required" value ="<?php echo $item['Country_Made']?>" >  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('STATUS') ?></label>  <i class="fas fa-asterisk fa-1px"></i>
                      <select class=" form-control" name="status"  style="background-color: #E5E5E5; " id="" required="required"  > 
                          <option value="0">...</option> 
                          <option value="1" <?php if($item['Status'] == 1){echo'selected';} ?>><?php echo lang('NEW') ?></option>
                          <option value="2" <?php if($item['Status'] == 2){echo'selected';} ?>><?php echo lang('USED') ?></option>
                      </select>  
                    </div>
                   <div class="form-group" >
                      <label> <?php echo lang('MEMBER') ?></label>  <i class="fas fa-asterisk fa-1px"></i>
                      <select class=" form-control" name="member"  style="background-color: #E5E5E5; " id="" required="required"  > 
                          <option value="0">...</option> 
                          <?php 
                          $stmt = $con->prepare("SELECT * FROM users");
                          $stmt->execute();
                          $users = $stmt->fetchAll();
                          foreach ($users as $user){
                              echo "<option value='" . $user['Usersid'] ."'";
                              if($item['Member_ID'] == $user['Usersid']){echo'selected'; } 
                              echo" > " . $user['Username'] ." </option>";
                          }
                          ?>
                      </select>  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('CATEGORY') ?></label>  <i class="fas fa-asterisk fa-1px"></i>
                      <select class=" form-control" name="category"  style="background-color: #E5E5E5; " id="" required="required"  > 
                          <option value="0">...</option> 
                          <?php 
                          $stmt2 = $con->prepare("SELECT * FROM categories");
                          $stmt2->execute();
                          $cats = $stmt2->fetchAll();
                          foreach ($cats as $cat){
                              echo "<option value='" . $cat['ID'] ."'";
                              if($item['Cat_ID'] == $cat['ID']){echo'selected'; } 
                              echo"> " . $cat['name'] ." </option>";
                          }
                          ?>
                      </select>  
                    </div>
                    <div class="form-group">
                          <label >img</label>
                          <input type="file" class="form-control" id="exampleFormControlFile1" name="image" >
                        </div>
                        <div class="form-group">
                          <label >img</label>
                          <input type="file" class="form-control" id="exampleFormControlFile1" name="image" >
                        </div>
                        <div class="form-group">
                          <label >img</label>
                          <input type="file" class="form-control" id="exampleFormControlFile1" name="image" >
                        </div>
                    <input style="margin:20px 25% ;width:50%;" class="btn btn-info  " type="submit" value="<?php echo lang('ADD_ITEM') ?>" />

                </form>
            </div>
      </div>
 <?php

$stmt = $con->prepare("SELECT comments .* ,users.Username FROM comments

INNER JOIN users ON users.Usersid = comments.	UserID
WHERE ItemID = ? ");

// ececute the stmt

$stmt->execute(array($itemid));

// assign 

$row = $stmt->fetchAll();

if(! empty($row)){

?> 

  <!-- // Manage page -->
  <h1 class ="text-center my-5">[<?php echo $item['Name']  ?>] <?php echo lang('MANAGE_COMMENTS') ?></h1>
  
    <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
        <tr>
          <td><?php echo lang('COMMENT') ?></td>
          <td><?php echo lang('USER_NAME') ?></td>
          <td><?php echo lang('ADDING_DATE') ?></td>
          <td><?php echo lang('CONTROL') ?></td>
        </tr>
        <?php
        
        foreach($row as $row){
          echo "<tr>";
            echo "<td>" . $row['Comment'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['Comment_Date'] . "</td>";
            echo "<td>
            <a href='comments.php?do=Edit&comid=" .$row['C_ID'] ."' class='btn btn-success far fa-edit my-1'></a>
            <a href='comments.php?do=Delete&comid=" .$row['C_ID'] ."' class='btn btn-danger far fa-trash-alt confirm'></a>";
            
            if($row['Status'] == 0){
             echo " <a href='comments.php?do=Approve&comid=" .$row['C_ID'] ."' class='btn btn-info far fa-check-square'></a>";

            }
            
            echo" </td>";
            echo"<?tr>";
        }
        ?>
      </table>
    </div>
<?php }?>
</div>

  

<?php 
   }else {
    echo "<div class='container alert alert-danger my-5'>";

    $theMsg= 'Theres No Such ID !!!!!!!!';
    redirectHome($theMsg , 'back' ,10);

    echo "</div>";
}

  
  }elseif($do == 'Update') {

   

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //    get variables from the form
    $id        = $_POST['itemid'];
    $name      = $_POST['name'];
    $desc      = $_POST['description'];
    $Price     = $_POST['Price'];
    $country   = $_POST['country'];
    $status    = $_POST['status'];
    $category  = $_POST['category'];
    $member    = $_POST['member'];
 
    // validate the form
    $formerror = array();

    
    if(empty($name)){
      $formerror[] ='Name Can`t Be <strong> Empty </strong>';
    }

    if(empty($desc)){
      $formerror[] ='Description Can`t Be <strong> Empty </strong>';
    }
    
    if(empty($Price)){

      $formerror[] ='Price  Can`t Be <strong> Empty </strong>';
    }
    if(empty($country)){

      $formerror[] ='Country Can`t Be <strong> Empty </strong>'; 
    }
    if($status == 0){

      $formerror[] ='You Mast Choose <strong> Status </strong>'; 
    }
    if($member == 0){
        $formerror[] ='You Mast Choose <strong> Member </strong>';
    }
    if($category == 0){
        $formerror[] ='You Mast Choose <strong> Category </strong>';
    }
    

     foreach($formerror as $error){

      echo '<div class= "alert alert-danger">' . $error . '</div>' ;
     }
    //  cheak erorr proced update

    if(empty($formerror)){
       // update data base

    $stmt = $con->prepare("UPDATE
                              items 
                            SET 
                              `Name` = ? , 
                              `Description` = ? , 
                               Price = ?, 
                               Country_Made = ? ,
                              `Status` = ? ,
                               Cat_ID = ? ,
                               Member_ID = ? 
                            WHERE 
                            Item_ID = ? ");
 
    $stmt->execute(array($name,$desc,$Price,$country,$status,$category,$member,$id));
    
    header('location: items.php')  ;
        
    }
    
   
   }else{
    echo "<div class='container alert alert-danger my-5'>";

    $theMsg= 'sorry you can`t browse this page directly';
    redirectHome($theMsg , 'back');
}
echo "</div>";


  }elseif($do == 'Delete') {
    
    //  Delete page

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
// select all data depend on this id


 $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID=? LIMIt 1 ");

  $stmt->execute(array($itemid));
  
  $count = $stmt->rowCount();

  if($count >0) {
    
    $stmt =$con->prepare("DELETE FROM items WHERE Item_ID = :zID");

    $stmt->bindParam(":zID" , $itemid);

    header('location: items.php')  ;

    $stmt->execute();

  }else {
    $theMsg= '<div class="container alert alert-danger mt-5" >This ID Is Not Exist</div>';
    redirectHome($theMsg);
  }

}elseif($do == 'Approve') {
    
    //  Approve page

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
// select all data depend on this id


  $check = checkItem('Item_ID' , 'items' , $itemid);

  if( $check > 0) {
    
    $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

    $stmt->execute(array($itemid));

    header('location: items.php?page=Pending')  ;

   
  }else {
    $theMsg= '<div class="container alert alert-danger mt-5" >This ID Is Not Exist</div>';
    redirectHome($theMsg);
  }}
  
  include $tpl .'footer.php';
  
  }else{
  
      header('location: index.php');
      
      exit();
  } 

  ob_end_flush();

?>