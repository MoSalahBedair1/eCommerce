<?php

  session_start();

  $pageTitle = '';

  if (isset($_SESSION['Username'])) {
      include 'init.php';

      include $tpl . 'footer.php';
  } else {
      header('Location: index.php');
      exit();
  }