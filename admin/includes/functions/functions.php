<?php

/*
 ** Title function v1.0
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
 ** Home redirect function v1.0
 ** This function accept parameters
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

/*
** Check items function v1.0
** Function to check item in database [ function accept parameters ]
** $select = The item to select [ Example: user, item, category ]
** $from = The table to select from [ Example: users, items, categories ]
** $value = The value of select [ Example: Osama, Box, Electronics ]
*/

function checkItem($select, $from, $value)
{
    global $con;

    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();

    return $count;
}
