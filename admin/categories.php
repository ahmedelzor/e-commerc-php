<!-- Categories Page template  -->

<?php
  ob_start();

  session_start();

  $pageTitle = 'Categories';

  if(isset($_SESSION['Username'])){
    

include 'init.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


 if ($do == 'Manage'){
   $sort = 'ASC';
   $sort_array = array('ASC' , 'DESC');
   if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array) ){
     $sort = $_GET['sort'];
   }

  $stmt2 = $con->prepare("SELECT * FROM categories WHERE Parent=0 ORDER BY Ordering $sort");
  // ececute the stmt
  $stmt2->execute();

  // assign 

  $cats = $stmt2->fetchAll();

  if(! empty($cats)){

  ?> 
  <h1 class="text-center mt-5"> <?php echo lang('MANAGE_CATEGORIES') ?></h1>

   <div class="container  ">
   <a class=" mb-3 btn btn-dark" href="categories.php?do=Add"><i class=" fas fa-user-plus"></i>  </a>

                <div class="panel panel-default categories">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i>  <?php echo lang('MANAGE_CATEGORIES') ?>
                        <div class="option ">
                          <?php echo lang('ORDERING_:') ?>
                           [<a class="mr-2 <?php if($sort =='ASC') {echo 'Active';}?>" href="?sort=ASC"><i class="fas fa-sort-alpha-down"></i></a>
                            ||
                           <a class="ml-2 <?php if($sort =='DESC') {echo 'Active';}?> " href="?sort=DESC"><i class="fas fa-sort-alpha-down-alt"></i></a>
                          ]
                           <?php echo lang(' VIEW_:') ?> 
                          [ <span class="Active" data-view="full"> <?php echo lang('FULL') ?> </span>
                           ||
                           <span data-view="classic"> <?php echo lang('CLASSIC') ?> </span>
                           ]
                          </div>
                    </div>
                    <div class="panel-body">
                        <?php 
                            foreach($cats as $cat){
                              echo "<div class='cat'>";
                               echo "<div class='hidden-btn'>";
                               echo "<a href='categories.php?do=Edit&catid=". $cat['ID'] . "' class='btn btn-xs btn-primary mr-2'><i class='fa fa-edit'></i></a>";
                               echo "<a href='categories.php?do=Delete&catid=". $cat['ID'] . "' class= ' confirm btn btn-xs btn-danger'><i class='far fa-trash-alt'></i></a>";
                               echo "</div>";
                              echo "<h3>". $cat['name'] . '</h3>';
                              echo "<div class='full-view'>";
                              echo "<p>";if($cat['description'] == ''){ echo 'Desc Is Empty';} else {
                                echo $cat['description'];
                              }  echo '</p>';
                                  if($cat['Visibility'] == 1){ echo '<span class="vis"><i class="fa fa-eye"></i> Hidden</span>'; }
                                  if($cat['AllowComment'] == 1){ echo '<span class="com"><i class="fas fa-times"></i> Comment Disabled</span>'; } 
                                  if($cat['AllowAds'] == 1){ echo '<span class="ads"><i class="fas fa-times"></i> Ads Disabled</span>'; } 
                                echo "</div>";
                                $childCats = getAllFrom("*" , "categories" , "where Parent = {$cat['ID']}" , "" , "ID" , "ASC");
                                if(! empty($childCats)){
                                  echo '<h4 style="color:#BBB" >Child Categories</h4>';
                                  echo '<ul class= "list-unstyled">';
                                  foreach($childCats as $c){
                                   echo "<li><a href='categories.php?do=Edit&catid=". $c['ID'] . "'></i>" .  $c['name'] ."</a>
                                   <a href='categories.php?do=Delete&catid=". $c['ID'] . "' class= ' confirm '><i class='far fa-trash-alt'></i></a>
                                   </li>";
                                    }
                                   echo '</ul>';
                                  
                                
                                }
                               echo "</div>";
                             
                   
                             echo '<hr>';

                            }
                        
                        ?>
                    </div>
                </div>
        </div>

    </div>
 
   
<?php

}else {
  echo '<div class="container alert alert-danger mt-5">';
  echo ' No Data ';
  echo '</div>';
  echo '<div class="container mt-2">';
  echo '<a class=" mb-3 btn btn-dark" href="categories.php?do=Add"><i class=" fas fa-user-plus"> </i> Add New Category </a>';
  echo '</div>';
}
 }elseif ($do == 'Add'){?>
   
   <div class="container col-md-6 my-5">
     <h1 class ="text-center mb-5"><?php echo lang('ADD_NEW_CATEGORIES') ?></h1>
      <div class="card" >
           <div class="card-body">
              <form class="form-horizontal" action="?do=Insert" method="POST" >
                   <div class="form-group">
                      <label><?php echo lang('CATEGORIES_NAME') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control"   type="text" name="name" placeholder="<?php echo lang('CATEGORIES_NAME') ?>"  required="required"/>
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('DESCRIPTION') ?></label>
                      <input style="background-color: #E5E5E5; " class=" form-control"  type="text" name="Description" placeholder="<?php echo lang('DESCRIPTION') ?>" >
                      
                    </div>
                    <div class="form-group">
                      <label ><?php echo lang('ORDERING') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control"   type="text" name="Ordering" placeholder="<?php echo lang('ORDERING') ?>" />
                    </div>
                    <div class="form-group">
                      <label >Category Parent</label> 
                      <select class=" form-control"   style="background-color: #E5E5E5; "  required="required" name="parent" id="">
                        <option value="0"> None</option>
                        <?php
                            $allCats = getAllFrom("*" , "categories" , "where parent = 0" , "" , "ID" ,"ASC");
                            foreach($allCats as $cat){

                              echo "<option value='" . $cat['ID'] . "'>" . $cat['name'] . "</option>";
                            }
                        
                        ?>
                      </select>
                    </div>
                    <div class="form-group koko">
                        <div class="col-md-6">
                            <label><?php echo lang('VISIBILITY') ?></label> 
                           <div>
                               <input id="vis-yes" type="radio" name=Visible value= "0" checked > <label for="vis-yes"><?php echo lang('YES') ?></label>
                               <input id="vis-no" type="radio" name=Visible value= "1"  > <label for="vis-no"><?php echo lang('NO') ?></label>
                           </div>
                        </div> 
                    </div>
                    <div class="form-group koko">
                        <div class="col-md-6">
                            <label><?php echo lang('ALLOW_COMMENTING') ?></label> 
                           <div>
                               <input id="com-yes" type="radio" name=commenting value= "0" checked > <label for="com-yes"><?php echo lang('YES') ?></label>
                               <input id="com-no" type="radio" name=commenting value= "1"  > <label for="com-no"><?php echo lang('NO') ?></label>
                           </div>
                        </div> 
                    </div>
                    <div class="form-group koko">
                        <div class="col-md-6">
                            <label><?php echo lang('ALLOW_ADS') ?></label> 
                           <div>
                               <input id="ads-yes" type="radio" name=Ads value= "0" checked > <label for="ads-yes"><?php echo lang('YES') ?></label>
                               <input id="ads-no" type="radio" name=Ads value= "1"  > <label for="ads-no"><?php echo lang('NO') ?></label>
                           </div>
                        </div> 
                    </div>

                    <input style="margin:20px 25% ;width:50%;" class="btn btn-info  " type="submit" value="<?php echo lang('ADD_CATEGORIES') ?>" />

                </form>
            </div>
      </div>
</div>

 <?php
 }elseif ($do == 'Insert'){

  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // echo  "<h1 class ='text-center mb-5'> Insert Member</h1>";
    // echo "<div class='container'>";

    //    get variables from the form
    $name     = $_POST['name'];
    $desc     = $_POST['Description'];
    $parent   = $_POST['parent'];
    $order    = $_POST['Ordering'];
    $visible  = $_POST['Visible'];
    $comment  = $_POST['commenting'];
    $Ads      = $_POST['Ads'];
  
      
      // check category in database


      $check = checkItem("name" , "categories	" ,$name);

      if($check == 1){
        
        echo "<div class='alert alert-danger my-5 container'>";

        $errordata=  'Sorry This categories Is Exist';

        categoriesAdd($errordata);

        echo "</div>";

      }else {
      

       // Insert categories base

       $stmt = $con->prepare("INSERT INTO  categories (`name` , `description` , Parent, Ordering  , Visibility , AllowComment , 	AllowAds ) 
       VALUES(:zname, :zdesc, :zParent , :zorder, :zvisible, :zcomment, :zads)");
       
       $stmt->execute(array( 
        'zname'    => $name ,
        'zdesc'    => $desc ,
        'zParent'  => $parent,
        'zorder'   => $order ,
        'zvisible' => $visible , 
        'zcomment' => $comment , 
        'zads'     => $Ads
      ));
      
       header('location: Categories.php');
    
    
    
       }
   
   }else{
         echo "<div class='container alert alert-danger my-5'>";

       $theMsg= 'sorry you can`t browse this page directly';
       redirectHome($theMsg , 'back');
   }
   echo "</div>";

  
  }elseif($do == 'Edit'){// Edit page 
    // check if get request catid is nomeric & get the integer value of it

$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

// select all data depend on this id

$stmt = $con->prepare("SELECT * FROM categories WHERE ID=? ");

  $stmt->execute(array($catid));

  $cat = $stmt->fetch();

  $count = $stmt->rowCount();

  if($count > 0) {?>
     
    <div class="container col-md-6 my-5">
     <h1 class ="text-center mb-5"><?php echo lang('EDIT_CATEGORIES') ?></h1>
      <div class="card" >
           <div class="card-body">
              <form class="form-horizontal" action="?do=Update" method="POST" >
              <input type="hidden" name="catid" value="<?php echo $catid ?>" >
                   <div class="form-group">
                      <label><?php echo lang('CATEGORIES_NAME') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control"   type="text" name="name" placeholder="<?php echo lang('CATEGORIES_NAME') ?>"  required="required" value="<?php echo $cat['name'] ?>"/>
                    </div>
                    <div class="form-group" >
                      <label> <?php echo lang('DESCRIPTION') ?></label>
                      <input style="background-color: #E5E5E5; " class=" form-control"  type="text" name="Description" placeholder="<?php echo lang('DESCRIPTION') ?>" value="<?php echo $cat['description'] ?>" >
                      
                    </div>
                    <div class="form-group">
                      <label ><?php echo lang('ORDERING') ?></label> 
                      <input style="background-color: #E5E5E5;" class="form-control"   type="text" name="Ordering" placeholder="<?php echo lang('ORDERING') ?>" value="<?php echo $cat['Ordering'] ?>"/>
                    </div>
                    <div class="form-group">
                      <label >Category Parent</label> 
                      <select class=" form-control"   style="background-color: #E5E5E5; "  required="required" name="parent" id="">
                        <option value="0"> None</option>
                        <?php
                            $allCats = getAllFrom("*" , "categories" , "where parent = 0" , "" , "ID" ,"ASC");
                            foreach($allCats as $c){

                              echo "<option value='" . $c['ID'] . "'";
                              if ($cat['Parent'] == $c['ID']) { echo 'selected' ; }
                              echo ">" . $c['name'] . "</option>";
                            }
                        
                        ?>
                      </select>
                    </div>
                    <div class="form-group koko">
                        <div class="col-md-6">
                            <label><?php echo lang('VISIBILITY') ?></label> 
                           <div>
                               <input id="vis-yes" type="radio" name=Visible value= "0" <?php  if($cat['Visibility'] == 0){echo 'checked';}?> > <label for="vis-yes"><?php echo lang('YES') ?></label>
                               <input id="vis-no" type="radio" name=Visible value= "1" <?php  if($cat['Visibility'] == 1){echo 'checked';}?>  > <label for="vis-no"><?php echo lang('NO') ?></label>
                           </div>
                        </div> 
                    </div>
                    <div class="form-group koko">
                        <div class="col-md-6">
                            <label><?php echo lang('ALLOW_COMMENTING') ?></label> 
                           <div>
                               <input id="com-yes" type="radio" name=commenting value= "0" <?php  if($cat['AllowComment'] == 0){echo 'checked';}?> > <label for="com-yes"><?php echo lang('YES') ?></label>
                               <input id="com-no" type="radio" name=commenting value= "1" <?php  if($cat['AllowComment'] == 1){echo 'checked';}?>  > <label for="com-no"><?php echo lang('NO') ?></label>
                           </div>
                        </div> 
                    </div>
                    <div class="form-group koko">
                        <div class="col-md-6">
                            <label><?php echo lang('ALLOW_ADS') ?></label> 
                           <div>
                               <input id="ads-yes" type="radio" name=Ads value= "0" <?php  if($cat['AllowAds'] == 0){echo 'checked';}?> > <label for="ads-yes"><?php echo lang('YES') ?></label>
                               <input id="ads-no" type="radio" name=Ads value= "1" <?php  if($cat['AllowAds'] == 1){echo 'checked';}?> > <label for="ads-no"><?php echo lang('NO') ?></label>
                           </div>
                        </div> 
                    </div>

                    <input style="margin:20px 25% ;width:50%;" class="btn btn-info  " type="submit" value="<?php echo lang('UPDATE_CATEGORIES') ?>" />

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


  }elseif($do == 'Update') {
   
     // echo  "<h1 class ='text-center mb-5'> Update Member</h1>";
  // echo "<div class='container'>";

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //    get variables from the form
    $id       = $_POST['catid'];
    $name     = $_POST['name'];
    $desc     = $_POST['Description'];
    $order    = $_POST['Ordering'];
    $parent   = $_POST['parent'];
    $visible  = $_POST['Visible'];
    $comment  = $_POST['commenting'];
    $Ads  = $_POST['Ads'];

    //  cheak erorr proced update

    $stmt = $con->prepare("UPDATE
                              categories
                           SET
                             `name`         = ? ,
                             `description`  = ? , 
                              Ordering      = ?,
                              Parent       = ?,
                              Visibility    = ?,
                              AllowComment  = ?,
                              AllowAds      = ?
                            WHERE 
                               ID = ? ");
 
   $stmt->execute(array($name , $desc , $order , $parent , $visible , $comment , $Ads ,$id));
    
    header('location: categories.php')  ;
   
   }else{
    echo "<div class='container alert alert-danger my-5'>";

    $theMsg= 'sorry you can`t browse this page directly';
    redirectHome($theMsg , 'back');
}
echo "</div>";


  }elseif($do == 'Delete') {
   
    // /  Delete page

$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
// select all data depend on this id


$stmt = $con->prepare("SELECT * FROM categories WHERE ID=? LIMIt 1 ");

  $stmt->execute(array($catid));
  
  $count = $stmt->rowCount();

  if($count >0) {
    
    $stmt =$con->prepare("DELETE FROM categories WHERE ID = :zid");

    $stmt->bindParam(":zid" , $catid);

    header('location: categories.php')  ;

    $stmt->execute();

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