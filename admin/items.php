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
          $stmt = $con->prepare("SELECT items.*, categories.Name AS category_name, users.Username FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID");
          // Execute the statement
          $stmt->execute();
          // Assign to variable
          $items = $stmt->fetchAll(); ?>
<h1 class="text-center">Manage Members</h1>
<div class="container">
  <div class='table-responsive'>
    <table class='main-table text-center table table-bordered'>
      <tr>
        <td>#ID</td>
        <td>Name</td>
        <td>Description</td>
        <td>Price</td>
        <td>Adding Date</td>
        <td>Category</td>
        <td>Username</td>
        <td>Control</td>
      </tr>

      <?php

        foreach ($items as $item) {
            echo '<tr>';
            echo '<td>' . $item['Item_ID'] . '</td>';
            echo '<td>' . $item['Name'] . '</td>';
            echo '<td>' . $item['Description'] . '</td>';
            echo '<td>' . $item['Price'] . '</td>';
            echo '<td>' . $item['Add_Date'] . '</td>';
            echo '<td>' . $item['category_name'] . '</td>';
            echo '<td>' . $item['Username'] . '</td>';
            echo '<td>
            <a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
            <a href="items.php?do=Delete&itemsid=' . $item['Item_ID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
            echo '</td>';
        } ?>
    </table>
  </div>
  <a href="itmes.php?do=Add" class='btn btn-primary'><i class='fa fa-plus'></i> New Items</a>
</div>
<?php
      } elseif ($do == 'Add') { // Add Members Page?>
<h1 class="text-center">Add New Member</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Insert" method="POST">
    <!-- Start username field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Username</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="username" class="form-control" autocomplete="off" required='required'>
      </div>
    </div>
    <!-- End username field -->
    <!-- Start Password field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10 col-md-4">
        <input type="password" name="password" class="form-control" autocomplete="new-password" required='required'>
      </div>
    </div>
    <!-- End Password field -->
    <!-- Start Email field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10 col-md-4">
        <input type="email" name="email" class="form-control" required='required'>
      </div>
    </div>
    <!-- End Email field -->
    <!-- Start Full Name field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Full Name</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="full" class="form-control" required='required'>
      </div>
    </div>
    <!-- End Full Name field -->
    <!-- Start submit field -->
    <div class="form-group form-group-lg">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="Save" class="btn btn-primary btn-lg">
      </div>
    </div>
    <!-- End submit field -->
  </form>
</div>
<?php } elseif ($do == 'Add') { ?>
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
        <input type="text" name="country" class="form-control" required='required'>
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
    <!-- End Member field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Member</label>
      <div class="col-sm-10 col-md-4">
        <select class="form-control" name="member">
          <option value="0">...</option>
          <?php
          $stmt = $con->prepare("SELECT * FROM users");
          $stmt->execute();
          $users = $stmt->fetchAll();
          foreach ($users as $user) {
              echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
          } ?>
        </select>
      </div>
    </div>
    <!-- End Member field -->
    <!-- Start Category field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Category</label>
      <div class="col-sm-10 col-md-4">
        <select class="form-control" name="category">
          <option value="0">...</option>
          <?php
          $stmt2 = $con->prepare("SELECT * FROM categories");
          $stmt2->execute();
          $cats = $stmt2->fetchAll();
          foreach ($cats as $cat) {
              echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
          } ?>
        </select>
      </div>
    </div>
    <!-- End Category field -->
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
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              echo '<h1 class="text-center">Update Member</h1>';
              echo '<div class="container">';

              // Get variables from the form

              $name     = $_POST['name'];
              $desc     = $_POST['description'];
              $price    = $_POST['price'];
              $country  = $_POST['country'];
              $status   = $_POST['status'];
              $member   = $_POST['member'];
              $cat      = $_POST['category'];

              // Validate The Form

              $formErrors = array();

              if (empty($name)) {
                  $formErrors[] = '<div class="alert alert-danger">name can\'t be <strong>empty</strong></div>';
              }
              if (empty($desc)) {
                  $formErrors[] = '<div class="alert alert-danger">Description can\'t be <strong>empty</strong></div>';
              }
              if (empty($price)) {
                  $formErrors[] = '<div class="alert alert-danger">Price can\'t be <strong>empty</strong></div>';
              }
              if (empty($country)) {
                  $formErrors[] = '<div class="alert alert-danger">Country can\'t be <strong>empty</strong></div>';
              }
              if ($status == 0) {
                  $formErrors[] = '<div class="alert alert-danger">You must choose the <strong>Status</strong></div>';
              }
              if ($member == 0) {
                  $formErrors[] = '<div class="alert alert-danger">You must choose the <strong>Member</strong></div>';
              }
              if ($cat == 0) {
                  $formErrors[] = '<div class="alert alert-danger">You must choose the <strong>Category</strong></div>';
              }

              // loop into error array and echo it

              foreach ($formErrors as $error) {
                  echo $error;
              }

              // Check if there's no error procceed the insert operation

              if (empty($formErrors)) {
                  // Insert userinfo in database
                  $stmt = $con->prepare("INSERT INTO  items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID) VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now()), :zcat, zmember");
                  $stmt->execute(array(
                'zname'    => $name,
                'zdesc'    => $desc,
                'zprice'   => $price,
                'zcountry' => $country,
                'zstatus'  => $status,
                'zcat'     => $cat,
                'zmember'  => $member
              ));
                  // Echo Success Message
                  echo '<div class="container">';
                  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted' . '</div>';
                  redirect($theMsg, 'back');
                  echo '</div>';
              }
          } else {
              $erroMsg = 'Sorry You can\'t browser this page directly';
              redirectHome($erroMsg, 6);
          }
          echo '</div>';
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
