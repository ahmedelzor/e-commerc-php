<?php 


session_start();
$pageTitle = ' Order';

include "init.php";
if(isset($_SESSION['user'])){

    
    ?>

    

<!-- <div id="my-Ads" class="my-Ads my-5 block">
        <div class="container">
             <div class="col-sm-12 mb-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-tag"> </i> Latest Items
                    </div>
                    <div class="panel-body">
                    <li><strong> name item </strong> :</li>
                    <li><strong> Price    </strong> :</li>
                       <li></li>
                    </div>
                </div>
             </div>
        </div>
</div> -->
    
                     
      
<?php
}else{
        header('location: index.php');
        exit();
    }


     include $tpl .'footer.php';
     ob_end_flush();
    ?>
