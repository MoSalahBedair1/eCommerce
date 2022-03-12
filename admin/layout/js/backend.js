$(function () {

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

});