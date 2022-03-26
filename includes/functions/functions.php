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
 ** Redirect function v2.0
 ** This function accepts parameters
 ** $theMsg = Echo the message [ error | success | warning ]
 ** $url = The link you want to redirect to
 ** $seconds = seconds before redirecting
 */

  function redirect($theMsg, $url = null, $seconds = 3)
  {
      if ($url === null) {
          $url = 'index.php';
      } else {
          if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
              $url = $_SERVER['HTTP_REFERER'];
              $link = 'Previous page';
          } else {
              $url = 'index.php';
              $link = 'Homepage';
          }
      }

      echo $theMsg;
      echo "<div class='alert alert-info'>You will be redirected to $link after $seconds  seconds.</div>";
      header("refresh:$seconds;url=$url");
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

/*
** Count number of items function v1.0
** function to count number of items rows
** $item = the item to count
** $table = the table to choose from
*/

function countItems($item, $table)
{
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

/*
** Get latest records function v1.0
** Function to get latest items from database [Users, Items, Comments]
** $select = Field To Select
** $table = The table to choose from
** $order = the desc ordering
** $limit = Number of records to get
*/

function getLatest($select, $table, $order, $limit = 5)
{
    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
}
