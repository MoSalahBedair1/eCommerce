<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo getTitle(); ?>
  </title>
  <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
  <link rel="stylesheet"
    href="<?php echo $css ?>font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo $css ?>frontend.css">
</head>

<body>
  <div class="upper-bar">
    <div class="container">
      <?php
        if (isset($_SESSION['user'])) { ?>

      <img class="my-image img-thumbnail img-circle" src="img.png" alt="">
      <div class="btn-group my-info">
        <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          <?php echo $sessionUser ?>
          <span class="caret"></span>
          <ul class="dropdown-menu">
            <li><a href="profile.php"></a>My Profile</li>
            <li><a href="newad.php"></a>New Item</li>
            <li><a href="profile.php#my-items"></a>My Items</li>
            <li><a href="logout.php"></a>Logout</li>
          </ul>
        </span>
      </div>

      <?php
      } else { ?>
      <a href="login.php">
        <span class="pull-right">Login/Signup</span>
      </a>
      <?php } ?>
    </div>
  </div>
  <nav class="navbar navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav"
          aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="dashboard.php">Homepage</a>
      </div>

      <div class="collapse navbar-collapse" id="app-nav">
        <ul class="nav navbar-nav navbar-right">
          <?php
          foreach (getCat() as $cat) {
              echo '<li><a href="categories.php?pageid=' . $cat['ID'] . '&pagename=' . str_replace(' ', '-', $cat['Name']) . '">' . $cat['Name'] . '</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>