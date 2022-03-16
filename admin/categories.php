<?php

/*
================================================
== Category Page
================================================
*/

  session_start();

  $pageTitle = 'Categories';

  if (isset($_SESSION['Username'])) {
      include 'init.php';

      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

      if ($do == 'Manage') {
          $sort = 'ASC';
          $sort_array = array('ASC', 'DESC');

          if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
              $sort = $_GET['sort'];
          }
          $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
          $stmt2->execute();

          $cats = $stmt2->fetchAll(); ?>

<h1 class='text-center'>Manage Categories</h1>
<div class="container categories">
  <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-edit"></i> Manage Categories
      <div class="option pull-right">
        <i class="fa fa-sort"></i> Ordering: [
        <a class="<?php if ($sort == 'ASC') {
              echo 'active';
          } ?>" href="?sort=ASC">Asc</a> |
        <a class="<?php if ($sort == 'DESC') {
              echo 'active';
          } ?>" href="?sort=DESC"> Desc</a> ]
        <i class="fa fa-eye"></i> View: [
        <span class="active" data-view="full">Full</span> |
        <span data-view="classic">Classic</span> ]
      </div>
    </div>
    <div class="panel-body">
      <?php
        foreach ($cats as $cat) {
            echo "<div class='cat'>";
            echo '<div class="hidden-buttons">';
            echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
            echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
            echo '</div>';
            echo '<h3>' . $cat['Name'] . '</h3>';
            echo '<div class="full-view">';
            echo '<p>';
            if ($cat['Description'] == '') {
                echo 'This category has no description';
            } else {
                echo $cat['Description'];
            }
            echo '</p>';
            if ($cat['Visibility'] == 1) {
                echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>';
            };
            if ($cat['Allow_Comments'] == 1) {
                echo '<span class="commenting"><i class="fa fa-close"></i> Comments Disabled</span>';
            }
            if ($cat['Allow_Ads'] == 1) {
                echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disbaled</span>';
            }
            echo '</div>';
            echo '</div>';
            echo '<hr />';
        } ?>
    </div>
  </div>
  <a class='add-category btn btn-primary' href="categories.php?do=Add"><i class='fa fa-plus'></i> New Category</a>
</div>

<?php
      } elseif ($do == 'Add') { ?>
<h1 class="text-center">Add New Category</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Insert" method="POST">
    <!-- Start name field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="name" class="form-control" autocomplete="off" required='required'>
      </div>
    </div>
    <!-- End name field -->
    <!-- Start Description field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="description" class="form-control" autocomplete="new-password" required='required'>
      </div>
    </div>
    <!-- End Description field -->
    <!-- Start ordering field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Ordering</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="ordering" class="form-control">
      </div>
    </div>
    <!-- End ordering field -->
    <!-- Start Visibility field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Visibility</label>
      <div class="col-sm-10 col-md-4">
        <div>
          <input id='vis-yes' type="radio" name="visibility" value='0' checked>
          <label for="vis-yes">Yes</label>
        </div>
        <div>
          <input id='vis-no' type="radio" name="visibility" value='1'>
          <label for="vis-no">No</label>
        </div>
      </div>
    </div>
    <!-- End Visibility field -->
    <!-- Start Commenting field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Allow Commenting</label>
      <div class="col-sm-10 col-md-4">
        <div>
          <input id='com-yes' type="radio" name="commenting" value='0' checked>
          <label for="com-yes">Yes</label>
        </div>
        <div>
          <input id='com-no' type="radio" name="commenting" value='1'>
          <label for="com-no">No</label>
        </div>
      </div>
    </div>
    <!-- End Commenting field -->
    <!-- Start Ads field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Allow Ads</label>
      <div class="col-sm-10 col-md-4">
        <div>
          <input id='ads-yes' type="radio" name="ads" value='0' checked>
          <label for="ads-yes">Yes</label>
        </div>
        <div>
          <input id='ads-no' type="radio" name="ads" value='1'>
          <label for="ads-no">No</label>
        </div>
      </div>
    </div>
    <!-- End Ads field -->
    <!-- Start submit field -->
    <div class="form-group form-group-lg">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="Add Category" class="btn btn-primary
      btn-lg">
      </div>
    </div>
    <!-- End submit field -->
  </form>
</div>
<?php
      } elseif ($do == 'Insert') {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              echo '<h1 class="text-center">Insert Category</h1>';
              echo '<div class="container">';
        
              // Get variables from the form
        
              $name    = $_POST['name'];
              $desc    = $_POST['description'];
              $order   = $_POST['ordering'];
              $visible = $_POST['visibility'];
              $comment = $_POST['commenting'];
              $ads     = $_POST['ads'];

              // Check if category exist in database

              $check = checkItem('Name', 'categories', $name);

              if ($check == 1) {
                  $theMsg = '<div class="alert alert-danger">Sorry this category exist</div>';
                  redirect($theMsg, 'back');
              } else {
                  // Insert category in database
                  $stmt = $con->prepare("INSERT INTO  categories(Name, Description, Ordering, Visibility, Allow_Comments, Allow_Ads) VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads)");
                  $stmt->execute(array(
                'zname'     => $name,
                'zdesc'     => $desc,
                'zorder'    => $order,
                'zvisible'  => $visible,
                'zcomment'  => $comment,
                'zads'      => $ads
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
          // Check if get reqest catID is numeric & get the interger value of of it

          $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

          // Select all data depend on this id

          $stmt = $con->prepare('SELECT * FROM categories WHERE ID = ?');

          // Execute query

          $stmt->execute(array($catid));

          // Fetch the data

          $cat = $stmt->fetch();

          // The row count

          $count = $stmt->rowCount();

          // If there's such ID Show the form

          if ($count > 0) { ?>

<h1 class="text-center">Edit Category</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Update" method="POST">
    <input type="hidden" name="catid" value="<?php echo $catid ?>">
    <!-- Start name field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="name" class="form-control" required='required'
          value='<?php echo $cat['Name']; ?>'>
      </div>
    </div>
    <!-- End name field -->
    <!-- Start Description field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="description" class="form-control" autocomplete="new-password" required='required'
          value='<?php echo $cat['Description']; ?>'>
      </div>
    </div>
    <!-- End Description field -->
    <!-- Start ordering field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Ordering</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="ordering" class="form-control"
          value='<?php echo $cat['Ordering']; ?>'>
      </div>
    </div>
    <!-- End ordering field -->
    <!-- Start Visibility field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Visibility</label>
      <div class="col-sm-10 col-md-4">
        <div>
          <input id='vis-yes' type="radio" name="visibility" value='0' <?php if ($cat['Visibility'] == 0) {
              echo 'checked';
          } ?>>
          <label for="vis-yes">Yes</label>
        </div>
        <div>
          <input id='vis-no' type="radio" name="visibility" value='1' <?php if ($cat['Visibility'] == 1) {
              echo 'checked';
          } ?>>
          <label for="vis-no">No</label>
        </div>
      </div>
    </div>
    <!-- End Visibility field -->
    <!-- Start Commenting field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Allow Commenting</label>
      <div class="col-sm-10 col-md-4">
        <div>
          <input id='com-yes' type="radio" name="commenting" value='0' <?php if ($cat['Allow_Comments'] == 0) {
              echo 'checked';
          } ?>>
          <label for="com-yes">Yes</label>
        </div>
        <div>
          <input id='com-no' type="radio" name="commenting" value='1' <?php if ($cat['Allow_Comments'] == 1) {
              echo 'checked';
          } ?>>
          <label for="com-no">No</label>
        </div>
      </div>
    </div>
    <!-- End Commenting field -->
    <!-- Start Ads field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Allow Ads</label>
      <div class="col-sm-10 col-md-4">
        <div>
          <input id='ads-yes' type="radio" name="ads" value='0' <?php if ($cat['Allow_Ads'] == 0) {
              echo 'checked';
          } ?>>
          <label for="ads-yes">Yes</label>
        </div>
        <div>
          <input id='ads-no' type="radio" name="ads" value='1' <?php if ($cat['Allow_Ads'] == 0) {
              echo 'checked';
          } ?>>
          <label for="ads-no">No</label>
        </div>
      </div>
    </div>
    <!-- End Ads field -->
    <!-- Start submit field -->
    <div class="form-group form-group-lg">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="Save Category" class="btn btn-primary
      btn-lg">
      </div>
    </div>
    <!-- End submit field -->
  </form>
</div>

<?php
    } else { // If there's no such ID show error message
        echo "<div class='container'>";
        $theMsg = '<div class="alert alert-danger">There\'s No Such ID</div>';
        redirect($theMsg);
        echo "</div>";
    }
      } elseif ($do == 'Update') {
          echo '<h1 class="text-center">Update Category</h1>';
          echo '<div class="container">';

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              // Get variables from the form

              $id      = $_POST['catid'];
              $name    = $_POST['name'];
              $desc    = $_POST['description'];
              $order   = $_POST['ordering'];

              $visible = $_POST['visibility'];
              $comment = $_POST['commenting'];
              $ads     = $_POST['ads'];

              $stmt = $con->prepare('UPDATE categories SET Name = ?, Description = ?, Ordering = ?, Visibility = ?, Allow_Comments = ?, Allow_Ads = ? WHERE ID = ?');
              $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads, $id));
              // Echo Success Message
              echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated' . '</div>';
          } else {
              echo 'Sorry You can\'t browser this page directly';
          }
          echo '</div>';
      } elseif ($do == 'Delete') {
          echo '<h1 class="text-center">Delete Category</h1>';
          echo '<div class="container">';

          // Check if get reqest catid is numeric & get the interger value of of it

          $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

          // Select all data depend on this id
        
          $check = checkItem('ID', 'categories', $catid);

          // If there's such ID Show the form
        
          if ($check > 0) {
              $stmt = $con->prepare('DELETE FROM categories WHERE ID = :zid');
              $stmt->bindParam(':zid', $catid);
              $stmt->execute();
              echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted' . '</div>';
          } else {
              echo 'This ID is Not Exist';
          }
          echo '</div>';
      } elseif ($do == 'Activate') {
          echo '<h1 class="text-center">Activate Member</h1>';
          echo '<div class="container">';

          // Check if get reqest userid is numeric & get the interger value of of it

          $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

          // Select all data depend on this id
      
          $check = checkItem('userid', 'users', $userid);

          // If there's such ID Show the form
      
          if ($check > 0) {
              $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
              $stmt->execute(array($userid));
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
