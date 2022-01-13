$(function() {
'use strict';
//   switch login by sign up

$('.login-page h1 span').click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    $('.login-page form').hide();
    $('.' + $(this).data('class')).fadeIn(100);

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

// coustem preview


$('.live-name').keyup(function(){
  $('.live-preview .caption h5').text($(this).val());
});


$('.live-desc').keyup(function(){
    $('.live-preview .caption p').text($(this).val());
  });

  $('.live-price').keyup(function(){
    $('.live-preview span').text(' $' + $(this).val());
  });

});


