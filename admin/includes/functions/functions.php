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

// get letest records function v1.0
// function to get latest item from database
// $table = the table th choose from
// $select = filed to select
// $limit = number of record



function getlatest($select , $table ,$order, $limit = 5) {

    global $con;

    $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $getstmt->execute();
    $row = $getstmt->fetchAll();

    return $row;
}

