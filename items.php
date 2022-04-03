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
    <div class="col-md-9 item-info">
      <h2><?php echo $item['Name']; ?>
      </h2>
      <p><?php echo $item['Description']; ?>
      </p>
      <ul class="list-unstyled">
        <li>
          <i class="fa fa-caledar fa-fw"></i>
          <span>Added Date</span><?php echo $item['Add_Date']; ?>
        </li>
        <li>
          <i class="fa fa-money fa-fw"></i>
          <span>Price</span> : <?php echo $item['Price']; ?>
        </li>
        <li>
          <i class="fa fa-building fa-fw"></i>
          <span>Made In</span> : <?php echo $item['Country_Made']; ?>
        </li>
        <li>
          <i class="fa fa-tags fa-fw"></i>
          <span>Category</span> : <a
            href="categories.php?<?php echo $item['Cat_ID'] ?>"><?php echo $item['category_name']; ?></a>
        </li>
        <li>
          <i class="fa fa-user fa-fw"></i>
          <span>Added By</span> : <a href=""><?php echo $item['Username']; ?></a>
        </li>
      </ul>
    </div>
  </div>
  <hr class="custom-hr">
  <div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-9">

    </div>
  </div>
</div>

<?php
  } else {
      echo 'There\'s no such ID';
  }

  include $tpl . 'footer.php';
