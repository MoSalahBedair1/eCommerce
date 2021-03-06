<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title><?php getTitle() ?>
  </title>
  <link rel="stylesheet"
    href="<?php echo $css ?>bootstrap.min.css" />
  <link rel="stylesheet"
    href="<?php echo $css ?>font-awesome.min.css" />
  <link rel="stylesheet" href="<?php echo $css ?>frontend.css" />
</head>

<body>
  <div class="upper-bar">
    <div class="container">
      <?php
                if (isset($_SESSION['user'])) { ?>

      <img class="my-image img-thumbnail img-circle" src="img.png" alt="" />
      <div class="btn-group my-info">
        <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          <?php echo $sessionUser ?>
          <span class="caret"></span>
        </span>
        <ul class="dropdown-menu">
          <li><a href="profile.php">My Profile</a></li>
          <li><a href="newad.php">New Item</a></li>
          <li><a href="profile.php#my-ads">My Items</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>

      <?php

                } else {
                    ?>
      <div class="pull-right">
        <a href="login.php"><span class="btn btn-sm btn-default">Login / Sign up</span></a>
      </div>
      <div class="pull-left">
        <a href="index.php"><span class="brand-name">eCommerce Website</span></a>
      </div>
      <?php
                } ?>
    </div>
  </div>
  <nav class="navbar navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav"
          aria-expanded="false">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Homepage</a>
      </div>
      <div class="collapse navbar-collapse" id="app-nav">
        <ul class="nav navbar-nav navbar-right">
          <?php
              $allCats = getAllFrom("*", "categories", "ID", "where parent = 0", "", "ASC");
            foreach ($allCats as $cat) {
                echo
                '<li>
					<a href="categories.php?pageid=' . $cat['ID'] . '">
						' . $cat['Name'] . '
					</a>
				</li>';
            }
          ?>
        </ul>
      </div>
    </div>
  </nav>