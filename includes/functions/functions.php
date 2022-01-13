<?php


// get let all  records function v2.0
// function to get categoreis item from database
// $table = the table th choose from
// $select = filed to select
// $limit = number of record


function getAllFrom($filed , $teble ,$where = null , $And = null , $orderfiled , $ordering = "DESC") {

    global $con;

    $getAll = $con->prepare("SELECT $filed FROM $teble  $where $And ORDER BY $orderfiled $ordering");

    $getAll->execute();
    
    $all = $getAll->fetchAll();

    return $all;
}

// get let categories  records function v1.0
// function to get categoreis item from database
// $table = the table th choose from
// $select = filed to select
// $limit = number of record


function getCat() {

    global $con;

    $getCat = $con->prepare("SELECT * FROM categories WHERE Parent = 0 ORDER BY ID ASC ");

    $getCat->execute();
    $cats = $getCat->fetchAll();

    return $cats;
}

  // get let items  records function v2.0
// function to get items item from database
// $table = the table th choose from
// $select = filed to select
// $limit = number of record


function getItems($where , $value ,$approve = null) {

    global $con;

    $sql = $approve == null ? 'AND Approve = 1' : '';

    $getItems = $con->prepare("SELECT * FROM items WHERE $where =? $sql ORDER BY Item_ID DESC ");

    $getItems->execute(array($value));
    $items = $getItems->fetchAll();

    return $items;
}


// check user is not active
// func to check ragstatus of user


function checkUserStatus($user){

       global $con;

    $stmtx = $con->prepare("SELECT 
                               Username, RagStatus 
                            FROM users 
                            WHERE Username = ?  AND RagStatus = 0 ");
  
    $stmtx->execute(array($user));

    $status = $stmtx->rowCount();

    return $status;
    
}


//title function

function getTitle(){
    global $pageTitle;

    if(isset($pageTitle)){

        echo $pageTitle;
    }else{
        echo 'Default';
    }
}

// Redirect Function [this Function accpt Parameter]; v2.0


function redirectHome($theMsg ,$url = null, $seconds = 3){
    if($url === null){
        $url = 'index.php';
        $link = 'Homepage';
    }else {
        
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='' ){
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
        }else {
            $url = 'index.php';
            $link = 'Homepage';
        }
    }
    echo $theMsg;
    echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";
    header("refresh:$seconds ;url=$url ");
    exit();
}


//  function to chack user v1.0

function redirectAdd($errorMsg , $seconds = 3){

    echo "<div class='alert alert-danger'>$errorMsg</div>";
    echo "<div class='alert alert-info'>You Will Be Redirected to Homepage After $seconds Seconds.</div>";
    header("refresh:$seconds ;url=members.php?do=Add ");
    exit();
}

// /  function to chack user v1.0

function categoriesAdd($errordata , $seconds = 3){

    echo "<div class='alert alert-danger'>$errordata</div>";
    echo "<div class='alert alert-info'>You Will Be Redirected to Homepage After $seconds Seconds.</div>";
    header("refresh:$seconds ;url=categories.php?do=Add ");
    exit();
}

// function to cheak in database[function accpt parmetrs]

function checkItem($select , $form ,$value){

    global $con;
    
    $statement = $con->prepare("SELECT $select FROM $form WHERE $select = ?");

    $statement->execute(array($value));

    $count = $statement->rowCount();

    return $count;


}

// count number of items 

function countItems($item , $table){
    
    global $con;

    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table ");
    $stmt2->execute();

     return $stmt2->fetchColumn();

}



