$(function () {
  "use strict";

  // Swtich between login and signup

  $(".login-page h1 span").click(function () {
    $(this).addClass("selected").siblings().removeClass("selected");
    $(".login-page form").hide();
    $("." + $(this).data("class")).fadeIn(100);
  });

  // Confirmation message on button

  $(".confirm").click(function () {
    return confirm("Are You Sure?");
  });
});
