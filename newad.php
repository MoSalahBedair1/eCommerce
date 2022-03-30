<?php

  session_start();

  $pageTitle = 'Create New Ad';

  include 'init.php';
  
  if (isset($_SESSION['user'])) { ?>

<h1 class="text-center">Create New Ad</h1>

<div class="create-ad block">
  <div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading">Create New Ad</div>
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
