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

  $(".live-name").keyup(function () {
    $(".live-preview .caption h3").text($(this).val());
  });

  $(".live-desc").keyup(function () {
    $(".live-preview .caption p").text($(this).val());
  });

  $(".live-price").keyup(function () {
    $(".live-preview .price-tag").text($(this).val());
  });
});
