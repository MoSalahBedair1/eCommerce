<?php

 // Error Reporting

  ini_set('display_erros', 'On');
  error_reporting(E_ALL);

  include 'admin/connect.php';

  $sessionUser = '';

  if (isset($_SESSION['user'])) {
      $sessionUser = $_SESSION['user'];
  }

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
