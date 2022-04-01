<?php

  session_start();

  $pageTitle = 'Create New Item';

  include 'init.php';
  
  if (isset($_SESSION['user'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $formErrors = array();

          $name = filter_var($_POST['name'], FILTER_UNSAFE_RAW);
          $desc = filter_var($_POST['description'], FILTER_UNSAFE_RAW);
          $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
          $country = filter_var($_POST['country'], FILTER_UNSAFE_RAW);
          $status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
          $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

          if (strlen($name) < 4) {
              $formErrors[] = 'Item title must be at least 4 characters';
          }
          if (strlen($desc) < 10) {
              $formErrors[] = 'Item description must be at least 10 characters';
          }
          if (empty($price)) {
              $formErrors[] = ' Item price must be not empty';
          }
          if (empty($status)) {
              $formErrors[] = ' Item status must be not empty';
          }
          if (empty($category)) {
              $formErrors[] = ' Item category must be not empty';
          }
          if (empty($formErrors)) {
              // Insert userinfo in database
              $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID) VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
              $stmt->execute(array(
          'zname'    => $name,
          'zdesc'    => $desc,
          'zprice'   => $price,
          'zcountry' => $country,
          'zstatus'  => $status,
          'zcat'     => $category,
          'zmember'  => $_SESSION['uid']
        ));
              if ($stmt) {
                  echo 'Item Added';
              }
          } else {
              $erroMsg = 'Sorry You can\'t browser this page directly';
          }
      } ?>

<h1 class="text-center"><?php echo $pageTitle; ?>
</h1>

<div class="create-ad block">
  <div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading"><?php echo $pageTitle; ?>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-8">
            <form class="form-horizontal"
              action="<?php echo $_SERVER['PHP_SELF']; ?>"
              method="POST">
              <!-- Start name field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-4">
                  <input type="text" name="name" class="form-control live-name" required='required'>
                </div>
              </div>
              <!-- End Description field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-4">
                  <input type="text" name="description" class="form-control live-desc" required='required'>
                </div>
              </div>
              <!-- End Description field -->
              <!-- End Price field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10 col-md-4">
                  <input type="text" name="price" class="form-control live-price" required='required'>
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
                  <input type="submit" value="Add Item" class="btn btn-primary btn-sm">
                </div>
              </div>
              <!-- End submit field -->
            </form>
          </div>
          <div class="col-md-4">
            <div class="thumbnail item-box live-preview">
              <span class="price-tag">0</span>
              <img class="img-responsive" src="img.png" alt="" />
              <div class="caption">
                <h3>Title</h3>
                <p>Description</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Start looping throught errors -->
        <?php
        if (!empty($formErrors)) {
            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
        } ?>
        <!-- End looping throught errors -->
      </div>
    </div>
  </div>
</div>

<?php
  } else {
      header('Location: login.php');
      exit();
  }

  include $tpl . 'footer.php';
