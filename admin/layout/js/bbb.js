$(function() {
'use strict';

// dashboard

$('.toggle-info').click(function (){

    $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
    
    if($(this).hasClass('selected')) {

        $(this).html('<i class="fa fa-plus"></i>');
    }else{

        $(this).html('<i class="fa fa-minus"></i>');
    }

});


// placeholder

$('[placeholder]').focus(function () {

    $(this).attr('data-text', $(this).attr('placeholder'));

    $(this).attr('placeholder','');

}).blur(function (){

    $(this).attr('placeholder', $(this).attr('data-text'));
});

// add asterisk on requred 

$('input').each(function () {
    if ($(this).attr('required') === 'required'){

        $(this).after('<i class="asterisk">*</i>');
    }
});

// show password

var passField = $('.password');

$('.show-pass').hover(function (){
 
    passField.attr('type' , 'text');
},function(){
    
    passField.attr('type' , 'password');

});

// confirmtion messege 

$('.confirm').click(function (){

    return confirm('Are You Sure?');
});



// categories show option

$('.cat h3').click(function(){
    $(this).next('.full-view').fadeToggle(200);
});


$('.option span').click(function(){
    $(this).addClass('Active').siblings('span').removeClass('Active');

    if($(this).data('view') === 'full'){
        $('.cat .full-view').fadeIn(200);
    }else{
        $('.cat .full-view').fadeOut(200);
    }
});



});


