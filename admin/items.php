<?php

/*
================================================
== Items Page
================================================
*/

  session_start();

  $pageTitle = 'Items';

  if (isset($_SESSION['Username'])) {
      include 'init.php';

      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

      if ($do == 'Manage') {
          echo 'Welcome To Items Page';
      } elseif ($do == 'Add') {
          ?>
<h1 class="text-center">Add New Items</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Insert" method="POST">
    <!-- Start name field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="name" class="form-control" required='required'>
      </div>
    </div>
    <!-- End Description field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="description" class="form-control" required='required'>
      </div>
    </div>
    <!-- End Description field -->
    <!-- End Price field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Price</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="price" class="form-control" required='required'>
      </div>
    </div>
    <!-- End Price field -->
    <!-- End Country field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Country</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="price" class="form-control" required='required'>
      </div>
    </div>
    <!-- End Country field -->
    <!-- End Status field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Status</label>
      <div class="col-sm-10 col-md-4">
        <select class="form-control" name="status">
          <option value="0">...</option>
          <option value="1">New</option>
          <option value="2">Like New</option>
          <option value="3">Used</option>
          <option value="4">Very Old</option>
        </select>
      </div>
    </div>
    <!-- End Status field -->
    <!-- Start submit field -->
    <div class="form-group form-group-lg">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="Add Item" class="btn btn-primary
      btn-sm">
      </div>
    </div>
    <!-- End submit field -->
  </form>
</div>
<?php
      } elseif ($do == 'Insert') {
      } elseif ($do == 'Edit') {
      } elseif ($do == 'Update') {
      } elseif ($do == 'Delete') {
      } elseif ($do == 'Approve') {
      }

      include $tpl . 'footer.php';
  } else {
      header('Location: index.php');
      exit();
  }
