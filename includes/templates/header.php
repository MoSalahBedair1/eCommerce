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
  <link rel="stylesheet" href="<?php echo $css ?>backend.css">
</head>

<body>
  <div class="upper-bar">
    upper bar
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