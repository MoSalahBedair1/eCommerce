<?php

/*
 ** Title function that echo the page title in case the page
 **  has the variable $pageTitle and echo default title for other pages
 */


  function getTitle()
  {
      global $pageTitle;
      if (isset($pageTitle)) {
          echo $pageTitle;
      } else {
          echo 'Default';
      }
  }


/*
 ** Home redirect function [this function accept parameters]
 ** $erroMsg = Echo the error message
 ** $seconds = seconds before redirecting
 */

  function redirectHome($errorMsg, $seconds = 3)
  {
      echo '<div class="alert alert-danger">' . $errorMsg . '</div>';
      echo '<div class="alert alert-info">You will be redirected to homepage after ' . $seconds . ' seconds.</div>';
      header('refresh:' . $seconds . ';url=index.php');
      exit();
  }
