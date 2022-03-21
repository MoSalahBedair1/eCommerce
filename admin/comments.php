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

          // Check if get reqest comid is numeric & get the interger value of of it

          $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

          // Select all data depend on this id

          $stmt = $con->prepare('SELECT * FROM comments WHERE c_id = ?');

          // Execute query

          $stmt->execute(array($comid));

          // Fetch the data

          $row = $stmt->fetch();

          // The row count

          $count = $stmt->rowCount();

          // If there's such ID Show the form

          if ($count > 0) { ?>

<h1 class="text-center">Edit Comment</h1>
<div class="cotainer">
  <form class="form-horizontal" action="?do=Update" method="POST">
    <input type="hidden" name="comid" value='<?php echo $comid ?>'>
    <!-- Start Comment field -->
    <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Comment</label>
      <div class="col-sm-10 col-md-4">
        <textarea class='form-control'
          name='comment'><?php echo $row['comment'] ?></textarea>
      </div>
    </div>
    <!-- End Comment field -->
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
          echo '<h1 class="text-center">Update Comment</h1>';
          echo '<div class="container">';

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              // Get variables from the form

              $comid    = $_POST['comid'];
              $comment  = $_POST['comment'];

              // Update the database with this info
              $stmt = $con->prepare('UPDATE comments SET comment = ? WHERE c_id = ?');
              $stmt->execute(array($comment, $comid));
              // Echo Success Message
              echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated' . '</div>';
          } else {
              echo 'Sorry You can\'t browser this page directly';
          }
          echo '</div>';
      } elseif ($do == 'Delete') {
          // Delete Page

          echo '<h1 class="text-center">Delete Comment</h1>';
          echo '<div class="container">';

          // Check if get reqest comid is numeric & get the interger value of of it

          $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

          // Select all data depend on this id
          
          $check = checkItem('c_id', 'comments', $comid);

          // If there's such ID Show the form
          
          if ($check > 0) {
              $stmt = $con->prepare('DELETE FROM comments WHERE c_id = :zid');
              $stmt->bindParam(':zid', $comid);
              $stmt->execute();
              echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted' . '</div>';
          } else {
              echo 'This ID is Not Exist';
          }
          echo '</div>';
      } elseif ($do == 'Approve') {
          echo '<h1 class="text-center">Approve Comment</h1>';
          echo '<div class="container">';

          // Check if get reqest comid is numeric & get the interger value of of it

          $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

          // Select all data depend on this id
        
          $check = checkItem('c_id', 'comments', $comid);

          // If there's such ID Show the form
        
          if ($check > 0) {
              $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");
              $stmt->execute(array($comid));
              echo  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Approved' . '</div>';
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
