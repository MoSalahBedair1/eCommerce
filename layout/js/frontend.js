$(function () {
  "use strict";

  // Switch Between Login & Signup

  $(".login-page h1 span").click(function () {
    $(this).addClass("selected").siblings().removeClass("selected");

    $(".login-page form").hide();

    $("." + $(this).data("class")).fadeIn(100);
  });

  // Add Asterisk On Required Field

  $("input").each(function () {
    if ($(this).attr("required") === "required") {
      $(this).after('<span class="asterisk">*</span>');
    }
  });

  // Confirmation Message On Button

  $(".confirm").click(function () {
    return confirm("Are You Sure?");
  });

  // Live preview for the item before posting it

  $(".live").keyup(function () {
    $($(this).data("class")).text($(this).val());
  });
});
