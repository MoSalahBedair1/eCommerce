<?php
session_start();
  if (isset($_SESSION['Username'])) {
      $pageTitle = 'Dashboard';
      include 'init.php';

      /* Start Dashboard Page */
      $latestUsersNum = 5;
      $latestUsers = getLatest('*', 'users', 'UserID', $latestUsersNum);
      $latestItemsNum = 6;
      $latestItems = getLatest('*', 'items', 'Item_ID', $latestItemsNum) ?>

<div class="home-stats">
  <div class="container text-center">
    <h1>Dashboard</h1>
    <div class="row">
      <div class="col-md-3">
        <div class="stat st-members">
          <i class="fa fa-users"></i>
          <div class="info">
            Total Members<span><a href="members.php"><?php echo countItems('UserID', 'users'); ?></a></span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-pending">
          <i class="fa fa-user-plus"></i>
          <div class="info">
            Pending Members<span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0); ?></a></span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-items"><i class="fa fa-tag"></i>
          <div class="info">
            Total Items<span><a href="items.php"><?php echo countItems('Item_ID', 'items'); ?></a></span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-comments"><i class="fa fa-comments"></i>
          <div class="info">Total Comments<span><a href="comments.php"><?php echo countItems('c_id', 'comments'); ?></a></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="latest">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-users"></i> Latest <?php echo $latestUsersNum ?> Registerd Users
            <span class="toggle-info pull-right">
              <i class="fa fa-plus fa-lg"></i>
            </span>
          </div>
          <div class="panel-body">
            <ul class="list-unstyled latest-users">
              <?php
              if (!empty($latestItems)) {
                  foreach ($latestUsers as $user) {
                      echo '<li>' . $user['Username'] . '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '"><span class="btn btn-success pull-right"><i class="fa fa-edit"></i> Edit';
                      if ($user['RegStatus'] == 0) {
                          echo '<a href="members.php?do=Activate&userid=' . $user['UserID'] . '" class="btn btn-info activate pull-right"><i class="fa fa-check"></i> Activate</a>';
                      }
                      echo '</span></a></li>';
                  }
              } else {
                  echo 'There\'s no record to show';
              } ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-users"></i> Latest <?php echo $latestItemsNum ?> Items
            <span class="toggle-info pull-right">
              <i class="fa fa-plus fa-lg"></i>
            </span>
          </div>
          <div class="panel-body">
            <ul class="list-unstyled latest-users">
              <?php
      foreach ($latestItems as $item) {
          echo '<li>' . $item['Name'] . '<a href="members.php?do=Edit&itemid=' . $item['Item_ID'] . '"><span class="btn btn-success pull-right"><i class="fa fa-edit"></i> Edit';
          if ($item['Approve'] == 0) {
              echo '<a href="members.php?do=Activate&itemid=' . $item['Item_ID'] . '" class="btn btn-info activate pull-right"><i class="fa fa-check"></i> Activate</a>';
          }
          echo '</span></a></li>';
      } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Start Latest Comments -->
    <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-comments-o"></i> Latest Comments
            <span class="toggle-info pull-right">
              <i class="fa fa-plus fa-lg"></i>
            </span>
          </div>
          <div class="panel-body">
            <?php
      $stmt = $con->prepare("SELECT comments.*, users.Username AS Member FROM comments INNER JOIN users ON users.UserID = comments.user_id");
      $stmt->execute();
      $comments = $stmt->fetchAll();
      
      foreach ($comments as $comment) {
          echo '<div class="comment-box">';
          echo '<span class="member-n">' . $comment['Member'] . '</span>';
          echo '<p class="member-c">' . $comment['comment'] . '</p>';
          echo '</div>';
      } ?>
          </div>
        </div>
      </div>
    </div>
    <!-- End Latest Comments -->
  </div>
</div>

<?php

      /* End Dashboard Page */

      include $tpl . 'footer.php';
  } else {
      header('Location: index.php');
      exit();
  }
