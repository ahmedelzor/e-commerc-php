<?php  

function lang($phrase){

    static $lang = array(
        'massag' => 'مرحبا',
        'admin' => 'المدير'

    );
    return $lang[$phrase];
}
?>

