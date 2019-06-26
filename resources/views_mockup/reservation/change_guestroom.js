require('../layout/base');
require('lightbox2');
require('slick-carousel/slick/slick.min');

$(function () {
    $('.slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });

    // lightbox
    // lightbox.option({
    //     'resizeDuration': 100,
    //     'wrapAround': true,
    //     'wrapAround': true
    // });

    $('.select_room').change(function () {
       var val = $('.select_room option:selected').val();

       if(val == 1) {
           $('.select_form_2').css('display', 'none');
           $('.select_form_3').css('display', 'none');
       } else if(val == 2) {
           $('.select_form_2').css('display', 'block');
           $('.select_form_3').css('display', 'none');
       } else if(val == 3) {
           $('.select_form_2').css('display', 'block');
           $('.select_form_3').css('display', 'block');
       }
    });


});


