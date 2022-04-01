<?php

  session_start();

  $pageTitle = 'Show Item';

  include 'init.php';

  // Check if get request item is numeric & get the interger value of of it
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

  // Select all data depend on this id
  $stmt = $con->prepare('SELECT items.*, categories.Name AS category_name, users.Username FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID WHERE Item_ID = ?');

  // Execute query
  $stmt->execute(array($itemid));

  $count = $stmt->rowCount();

  if ($count > 0) {


  // Fetch the data
      $item = $stmt->fetch(); ?>

<h1 class="text-center"><?php echo $item['Name']; ?>
</h1>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <img src="img.png" alt="" class="img-responsive img-thumbnail center-block">
    </div>
    <div class="col-md-9">
      <h2><?php echo $item['Name']; ?>
      </h2>
      <p><?php echo $item['Description']; ?>
      </p>
      <span><?php echo $item['Add_Date']; ?>
      </span>
      <div>Price: <?php echo $item['Price']; ?>
      </div>
      <div>Made In: <?php echo $item['Country_Made']; ?>
      </div>
      <div>Category: <?php echo $item['category_name']; ?>
      </div>
      <div>Added By: <?php echo $item['Username']; ?>
      </div>
    </div>
  </div>
</div>

<?php
  } else {
      echo 'There\'s no such ID';
  }

  include $tpl . 'footer.php';
