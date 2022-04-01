<?php

  session_start();

  $pageTitle = 'Show Item';

  include 'init.php';

  // Check if get request item is numeric & get the interger value of of it
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

  // Select all data depend on this id
  $stmt = $con->prepare('SELECT * FROM items WHERE Item_ID = ?');

  // Execute query
  $stmt->execute(array($itemid));

  // Fetch the data
  $item = $stmt->fetch();

?>

<h1 class="text-center"><?php echo $item['Name'] ?>
</h1>

<?php


  include $tpl . 'footer.php';
