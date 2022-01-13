<?php 
session_start();
$pageTitle = ' Create New Item ';

include "init.php";

if(isset($_SESSION['user'])){


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $formErrors = array();

        $title    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc     = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price    = filter_var($_POST['Price'], FILTER_SANITIZE_NUMBER_INT);
        $country  = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $status   = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
      

        if(strlen($title) < 4){
            $formErrors = 'Item Title Must Be At Least 4 Characters';
        }
         
        if(strlen($desc) < 10){
            $formErrors = 'Item Title Must Be At Least 10 Characters';
        }
        
        if(strlen($country) < 2){
            $formErrors = 'Item Title Must Be At Least 2 Characters';
        }
        if(empty($price)){
            $formErrors = 'Item Price Must Be Not Empty';
        }
        if(empty($status)){
            $formErrors = 'Item status Must Be Not Empty';
        }
        if(empty($category)){
            $formErrors = 'Item category Must Be Not Empty';
        }
// check errors
        if(empty($formerror)){
      
            // Insert data base
     
            $stmt = $con->prepare("INSERT INTO
            items (`Name` , `Description` , Price  , Country_Made ,`Status` , Add_Date ,  Cat_ID, Member_ID	 ) 
            VALUE(:zname , :zdesc , :zprice , :zcountry ,:zstatus, now() , :zcategory , :zmember )");
            $stmt->execute(array( 
                'zname'      => $title, 
                'zdesc'      => $desc, 
                'zprice'     => $price, 
                'zcountry'   => $country,
                'zstatus'    => $status,
                'zcategory'  => $category,
                'zmember'    => $_SESSION['uid']
             ));

              if($stmt){
                  $succesMasg = 'Iteme Added';
              }
     
            // header('location: items.php')  ;
         
         
         }
    }


?>

        <h1 class="text-center"><?php echo $pageTitle ?></h1>
       <div class="creat-ad my-5 block">
            <div class="container">
             <div class="col-sm-12 mb-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-tag"> </i> <?php echo $pageTitle ?>
                    </div>
                    <div class="panel-body">
                         <div class="row">
                             <!-- start form -->
                             <div class="col-lg-8" >
                             <div class="card-body col-sm-12  " >
              <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctyp="multipart/from-data" >
                   <div class="form-group">
                      <label><?php echo lang('ITEM_NAME') ?></label>
                      <input pattern=".{4,}" title="This Filed Require At Least 4 Characters"  style="background-color: #E5E5E5;" class="form-control live-name"   type="text" name="name" placeholder="<?php echo lang('ITEM_NAME') ?>" required="required" />
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('DESCRIPTION') ?></label>
                      <input pattern=".{10,}" title="This Filed Require At Least 10 Characters" style="background-color: #E5E5E5; " class=" form-control live-desc"  type="text" name="description" placeholder="<?php echo lang('DESCRIPTION') ?>" required="required" >  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('PRICE') ?></label>
                      <input style="background-color: #E5E5E5; " class=" form-control live-price"  type="text" name="Price" placeholder="<?php echo lang('PRICE') ?>" required="required" >  
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('COUNTRY_MADE') ?></label>
                      <input style="background-color: #E5E5E5; " class=" form-control "  type="text" name="country" placeholder="<?php echo lang('COUNTRY_MADE') ?>" required="required" >  
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
                      <label> <?php echo lang('CATEGORY') ?></label>
                      <select class=" form-control" name="category"  style="background-color: #E5E5E5; " id="" required="required"  > 
                          <option value="0">...</option> 
                          
                          <?php 
                           $cats= getAllFrom('*','categories' ,'', '','ID','ASC' );
                          foreach ($cats as $cat){
                              echo "<option value='" . $cat['ID'] ."'> " . $cat['name'] ." </option>";
                          }
                          ?>
                      </select>  
                    </div>
                    <div class="form-group">
                          <label >Image</label>
                          <input type="file" class="form-control" style="background-color: #E5E5E5;" id="exampleFormControlFile1" value="<?php echo $row['image'] ?>" name="image">
                        </div>
                        <div class="form-group">
                          <label >Image</label>
                          <input type="file" class="form-control" style="background-color: #E5E5E5;" id="exampleFormControlFile1" value="<?php echo $row['image'] ?>" name="image">
                        </div>
                        <div class="form-group">
                          <label >Image</label>
                          <input type="file" class="form-control" style="background-color: #E5E5E5;" id="exampleFormControlFile1" value="<?php echo $row['image'] ?>" name="image">
                        </div>
                    <input style="margin:20px 25% ;width:50%;" class="btn btn-info  " type="submit" value="<?php echo lang('ADD_ITEM') ?>" />

                </form>
            </div>

            <!-- end form -->
                             </div>
                             <div class="col-md-4 my-5">
                             <h5 class="text-center">Preview Ads</h5>
                                <div class="card my-3  live-preview"  >
                                    <span class="Price-tag ">0</span>
                                    <img src="./imgman.jpg" class="card-img-top" alt="" >
                                    <div class="card-body caption">
                                        <h5 class="card-title"> title</h5>
                                        <p class="card-text">des </p>
                                    </div>
                                </div>   
                             </div>
                         </div>
                         <?php  
                             if(! empty($formErrors)){
                                 foreach($formErrors as $error) {

                                    echo '<div class=" alert alert-danger">' . $error . '</div>';
                                 }
                             }
                             if (isset($succesMasg)) {
                                echo '<div class=" alert alert-success">' . $succesMasg . '</div>';
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