$(function () {

  'use strict';

  // Dashboard

  $('.toggle-info').click(function () {
    $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

    if ($(this).hasClass('selected')) {
      $(this).html('<i class="fa fa-minus fa-lg"></i>');
    } else {
      $(this).html('<i class="fa fa-plus fa-lg"></i>');
    }
  });

  // Add asterisk on required field

  $('input').each(function () {

    if ($(this).attr('required') === 'required') {
      $(this).after('<span class="asterisk">*</span>');
    }

  });

  // Confirmation message on button

  $('.confirm').click(function () {
    return confirm('Are you sure?');
  });

  // Category View Option

  $('.cat h3').click(function (){
    $(this).next('.full-view').fadeToggle(200);
  });

  $('.option span').click(function (){
    $(this).addClass('active').siblings('span').removeClass('active');

    if ($(this).data('view') === 'full') {
      $('.cat .full-view').fadeIn(200);
    } else {
      $('.cat .full-view').fadeOut(200);
    }
  });

});