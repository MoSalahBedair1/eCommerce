<?php

/*
================================================
== Items Page
================================================
*/

  session_start();

  $pageTitle = '';

  if (isset($_SESSION['Username'])) {
      include 'init.php';

      if ($do == 'Manage') {
      } elseif ($do == 'Add') {
      } elseif ($do == 'Insert') {
      } elseif ($do == 'Edit') {
      } elseif ($do == 'Update') {
      } elseif ($do == 'Delete') {
      }

      include $tpl . 'footer.php';
  } else {
      header('Location: index.php');
      exit();
  }
