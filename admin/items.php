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
<h1 class="text-center">Manage Items</h1>
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
            <a href="items.php?do=Delete&itemid=' . $item['Item_ID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
            if ($item['Approve'] == 0) {
                echo '<a href="items.php?do=Approve&itemid=' . $item['Item_ID'] . '" class="btn btn-info activate"><i class="fa fa-check"></i> Approve</a>';
            }
            echo '</td>';
        } ?>
    </table>
  </div>
  <a href="items.php?do=Add" class='btn btn-primary'><i class='fa fa-plus'></i> New Items</a>
</div>
<?php
      } elseif ($do == 'Add') { ?>
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
              echo '<h1 class="text-center">Add New Item</h1>';
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
                  $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID) VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
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
          // Check if get request item is numeric & get the interger value of of it

          $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

          // Select all data depend on this id

          $stmt = $con->prepare('SELECT * FROM items WHERE Item_ID = ?');

          // Execute query

          $stmt->execute(array($itemid));

          // Fetch the data

          $item = $stmt->fetch();

          // The row count

          $count = $stmt->rowCount();

          // If there's such ID Show the form

          if ($count > 0) { ?>
<h1 class="text-center">Edit Item</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Update" method="POST">
    <input type="hidden" name="itemid" value='<?php echo $itemid ?>'>
    <!-- Start name field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="name" class="form-control" required='required'
          value="<?php echo $item['Name'] ?>">
      </div>
    </div>
    <!-- End Description field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="description" class="form-control" required='required'
          value="<?php echo $item['Description'] ?>">
      </div>
    </div>
    <!-- End Description field -->
    <!-- End Price field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Price</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="price" class="form-control" required='required'
          value="<?php echo $item['Price'] ?>">
      </div>
    </div>
    <!-- End Price field -->
    <!-- End Country field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Country</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="country" class="form-control" required='required'
          value="<?php echo $item['Country_Made'] ?>">
      </div>
    </div>
    <!-- End Country field -->
    <!-- End Status field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Status</label>
      <div class="col-sm-10 col-md-4">
        <select class="form-control" name="status">
          <option value="1" <?php if ($item['Status'] == 1) {
              echo 'selected';
          } ?>>New
          </option>
          <option value="2" <?php if ($item['Status'] == 2) {
              echo 'selected';
          } ?>>Like New
          </option>
          <option value="3" <?php if ($item['Status'] == 3) {
              echo 'selected';
          } ?>>Used
          </option>
          <option value="4" <?php if ($item['Status'] == 4) {
              echo 'selected';
          } ?>>Very Old
          </option>
        </select>
      </div>
    </div>
    <!-- End Status field -->
    <!-- End Member field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Member</label>
      <div class="col-sm-10 col-md-4">
        <select class="form-control" name="member">
          <?php
          $stmt = $con->prepare("SELECT * FROM users");
          $stmt->execute();
          $users = $stmt->fetchAll();
          foreach ($users as $user) {
              echo "<option value='" . $user['UserID'] . "'";
              if ($item['Member_ID'] == $user['UserID']) {
                  echo 'selected';
              }
              echo ">" . $user['Username'] . "</option>";
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
          <?php
          $stmt2 = $con->prepare("SELECT * FROM categories");
          $stmt2->execute();
          $cats = $stmt2->fetchAll();
          foreach ($cats as $cat) {
              echo "<option value='" . $cat['ID'] . "'";
              if ($item['Cat_ID'] == $cat['ID']) {
                  echo 'selected';
              }
              echo ">" . $cat['Name'] . "</option>";
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

<?php } else { // If there's no such ID show error message
              echo "<div class='container'>";
              $theMsg = '<div class="alert alert-danger">There\'s No Such ID</div>';
              redirect($theMsg);
              echo "</div>";
          }
      } elseif ($do == 'Update') {
          echo '<h1 class="text-center">Update Item</h1>';
          echo '<div class="container">';

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              // Get variables from the form

              $id      = $_POST['itemid'];
              $name    = $_POST['name'];
              $desc    = $_POST['description'];
              $price   = $_POST['price'];
              $country = $_POST['country'];
              $status  = $_POST['status'];
              $cat     = $_POST['category'];
              $member  = $_POST['member'];

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

              // Check if there's no error procceed the update operation

              if (empty($formErrors)) {
                  // Update the database with this info
                  $stmt = $con->prepare('UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, Member_ID = ? WHERE Item_ID = ?');
                  $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member ,$id));
                  // Echo Success Message
                  echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated' . '</div>';
              }
          } else {
              echo 'Sorry You can\'t browser this page directly';
          }
          echo '</div>';
      } elseif ($do == 'Delete') {
          echo '<h1 class="text-center">Delete Item</h1>';
          echo '<div class="container">';

          // Check if get reqest itemid is numeric & get the interger value of of it

          $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

          // Select all data depend on this id
        
          $check = checkItem('Item_ID', 'items', $itemid);

          // If there's such ID Show the form
        
          if ($check > 0) {
              $stmt = $con->prepare('DELETE FROM items WHERE Item_ID = :zid');
              $stmt->bindParam(':zid', $itemid);
              $stmt->execute();
              echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted' . '</div>';
          } else {
              echo 'This ID is Not Exist';
          }
          echo '</div>';
      } elseif ($do == 'Approve') {
          echo '<h1 class="text-center">Approve Item</h1>';
          echo '<div class="container">';

          // Check if get reqest userid is numeric & get the interger value of of it

          $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

          // Select all data depend on this id
        
          $check = checkItem('Item_ID', 'items', $itemid);

          // If there's such ID Show the form
        
          if ($check > 0) {
              $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
              $stmt->execute(array($itemid));
              echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated' . '</div>';
          } else {
              echo 'This ID is Not Exist';
          }
          echo '</div>';
      }

      include $tpl . 'footer.php';
  } else {
      header('Location: index.php');
      exit();
  }
