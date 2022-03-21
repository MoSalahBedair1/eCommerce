<?php

/*
================================================
== Manage Comments Page
== You Can Add | Edit | Delete | Approve Comments From Here
================================================
*/

session_start();
$pageTitle = 'Comments';
  if (isset($_SESSION['Username'])) {
      include 'init.php';

      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

      // Start Manage Page
      if ($do == 'Manage') { // Manage Members Page

          // Select All users except Amdin
          $stmt = $con->prepare("SELECT comments.*, items.Name AS Item_Name, users.Username AS Member FROM comments INNER JOIN items ON items.Item_ID = comments.item_id INNER JOIN users ON users.UserID = comments.user_id");
          // Execute the statement
          $stmt->execute();
          // Assign to variable
          $rows = $stmt->fetchAll(); ?>
<h1 class="text-center">Manage Comments</h1>
<div class="container">
  <div class='table-responsive'>
    <table class='main-table text-center table table-bordered'>
      <tr>
        <td>ID</td>
        <td>Comment</td>
        <td>Item Name</td>
        <td>User Name</td>
        <td>Added Date</td>
        <td>Control</td>
      </tr>

      <?php

        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>' . $row['c_id'] . '</td>';
            echo '<td>' . $row['comment'] . '</td>';
            echo '<td>' . $row['Item_Name'] . '</td>';
            echo '<td>' . $row['Member'] . '</td>';
            echo '<td>' . $row['comment_date'] . '</td>';
            echo '<td>
            <a href="comments.php?do=Edit&comid=' . $row['c_id'] . '" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
            <a href="comments.php?do=Delete&comid=' . $row['c_id'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
            if ($row['status'] == 0) {
                echo '<a href="comments.php?do=Approve&comid=' . $row['c_id'] . '" class="btn btn-info activate"><i class="fa fa-check"></i> Approve</a>';
            }
            echo '</td>';
        } ?>
    </table>
  </div>
</div>
<?php
      } elseif ($do == 'Edit') { // Edit Page

          // Check if get reqest userid is numeric & get the interger value of of it

          $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

          // Select all data depend on this id

          $stmt = $con->prepare('SELECT * FROM users WHERE UserID = ? LIMIT 1');

          // Execute query

          $stmt->execute(array($userid));

          // Fetch the data

          $row = $stmt->fetch();

          // The row count

          $count = $stmt->rowCount();

          // If there's such ID Show the form

          if ($count > 0) { ?>

<h1 class="text-center">Edit Member</h1>
<div class="cotainer">
  <form class="form-horizontal" action="?do=Update" method="POST">
    <input type="hidden" name="userid" value='<?php echo $userid ?>'>
    <!-- Start username field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Username</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="username"
          value='<?php echo $row['Username'] ?>'
          class="form-control" autocomplete="off" required='required'>
      </div>
    </div>
    <!-- End username field -->
    <!-- Start Password field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10 col-md-4">
        <input type="hidden" name="oldpassword"
          value='<?php echo $row['Password'] ?>'>
        <input type="password" name="newpassword" class="form-control" autocomplete="new-password">
      </div>
    </div>
    <!-- End Password field -->
    <!-- Start Email field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10 col-md-4">
        <input type="email" name="email"
          value='<?php echo $row['Email'] ?>'
          class="form-control" required='required'>
      </div>
    </div>
    <!-- End Email field -->
    <!-- Start Full Name field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Full Name</label>
      <div class="col-sm-10 col-md-4">
        <input type="text" name="full"
          value='<?php echo $row['FullName'] ?>'
          class="form-control" required='required'>
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

<?php
      } else { // If there's no such ID show error message
          echo "<div class='container'>";
          $theMsg = '<div class="alert alert-danger">There\'s No Such ID</div>';
          redirect($theMsg);
          echo "</div>";
      }
      } elseif ($do == 'Update') { // Update Page
          echo '<h1 class="text-center">Update Member</h1>';
          echo '<div class="container">';

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              // Get variables from the form

              $id    = $_POST['userid'];
              $user  = $_POST['username'];
              $email = $_POST['email'];
              $name  = $_POST['full'];

              // Password Trick

              $pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);

              // Validate The Form

              $formErrors = array();

              if (empty($user)) {
                  $formErrors[] = '<div class="alert alert-danger">Username can\'t be <strong>empty</strong></div>';
              }
              if (empty($name)) {
                  $formErrors[] = '<div class="alert alert-danger">Full name can\'t be <strong>empty</strong></div>';
              }
              if (empty($email)) {
                  $formErrors[] = '<div class="alert alert-danger">Email can\'t be <strong>empty</strong></div>';
              }

              // loop into error array and echo it

              foreach ($formErrors as $error) {
                  echo $error;
              }

              // Check if there's no error procceed the update operation

              if (empty($formErrors)) {
                  // Update the database with this info
                  $stmt = $con->prepare('UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?');
                  $stmt->execute(array($user, $email, $name, $pass, $id));
                  // Echo Success Message
                  echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated' . '</div>';
              }
          } else {
              echo 'Sorry You can\'t browser this page directly';
          }
          echo '</div>';
      } elseif ($do == 'Delete') {
          // Delete Member Page

          echo '<h1 class="text-center">Delete Member</h1>';
          echo '<div class="container">';

          // Check if get reqest userid is numeric & get the interger value of of it

          $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

          // Select all data depend on this id
          
          $check = checkItem('userid', 'users', $userid);

          // If there's such ID Show the form
          
          if ($check > 0) {
              $stmt = $con->prepare('DELETE FROM users WHERE UserID = :zuser');
              $stmt->bindParam(':zuser', $userid);
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
