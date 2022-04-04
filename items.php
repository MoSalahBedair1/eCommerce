<?php

  session_start();

  $pageTitle = 'Show Item';

  include 'init.php';

  // Check if get request item is numeric & get the interger value of of it
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

  // Select all data depend on this id
  $stmt = $con->prepare('SELECT items.*, categories.Name AS category_name, users.Username FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID WHERE Item_ID = ? AND Approve = 1');

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
  <?php if (isset($_SESSION['user'])) { ?>
  <div class="row">
    <div class="col-md-offset-3">
      <div class="add-comment">
        <h3>Add Your Comment</h3>
        <form
          action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']?>"
          method="POST">
          <textarea name="comment"></textarea>
          <input class="btn btn-primary" type="submit" value="Add Comment">
        </form>
        <?php
        if ($_SERVER["REQUSET_METHOD"] == 'POST') {
            $comment = filter_var($_POST['comment'], FILTER_UNSAFE_RAW);
            $itemid = $item['Item_ID'];
            $userid = $_SESSION['uid'];

            if (!empty($comment)) {
                $stmt = $con->prepare("INSERT INTO comments(comment, status, comment_date, item_id, user_id) VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid");
            }

            $stmt->execute(array(
            'zcomment' => $comment,
            'zitemid' => $itemid,
            'zuserid' => $userid
          ));

            if ($stmt) {
                echo '<div class="alert alert-success">Comment Added</div>';
            }
        }
        ?>
      </div>
    </div>
  </div>
  <?php } else {
            echo '<a href="login.php">Login</a> or Register To Add Comment';
        } ?>
  <hr class="custom-hr">
  <?php
      // Select All users except Amdin
      $stmt = $con->prepare("SELECT comments.*, users.Username AS Member FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = ? AND status = 1 ORDER BY c_id DESC");
      // Execute the statement
      $stmt->execute();
      // Assign to variable
      $rows = $stmt->fetchAll(); ?>

  <div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-9"> <?php
    foreach ($comments as $comment) {
        echo '<div class="comment-box">';
        echo '<div class="row">';
        echo '<div class="col-sm-2 text-center"><img class="img-responsive img-thumbnail img-circle center-block">' . $comment['Member'] . '</div>';
        echo '<div class="col-sm-10">' . $comment['comment'] . '</div>';
        echo '</div>';
        echo '</div>';
        echo '<hr class="custom-hr">';
    } ?>
    </div>
  </div>
</div>

<?php
  } else {
      echo 'There\'s no such ID or this item is waiting approval';
  }

  include $tpl . 'footer.php';
