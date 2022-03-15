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
          $stmt2 = $con->prepare("SELECT * FROM categories");
          $stmt2->execute();

          $cats = $stmt2->fetchAll(); ?>

<h1 class='text-center'>Manage Categories</h1>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">Manage Categories</div>
    <div class="panel-body">
      Test
    </div>
  </div>
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
      } elseif ($do == 'Update') {
      } elseif ($do == 'Delete') {
      }

      include $tpl . 'footer.php';
  } else {
      header('Location: index.php');
      exit();
  }
