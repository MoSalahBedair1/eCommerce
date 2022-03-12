<?php

  include 'connect.php';

  // Routes

  $tpl  = 'includes/templates/'; // Templates Directory
  $lang = 'includes/languages/'; // Language Directory
  $func = 'includes/functions/'; // Functions Directory
  $css = 'layout/css/'; // css Directory
  $js = 'layout/js/'; // js Directory

  // Include the important files

  include $func . 'functions.php';
  include $lang . 'english.php';
  include $tpl . 'header.php';

  // Include the navbar on all pages except the one with $noNavbar variable

  if (!isset($noNavbar)) {
      include $tpl . 'navbar.php';
  }
