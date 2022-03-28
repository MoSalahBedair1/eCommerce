<?php
  session_start();
  $pageTitle = 'Login';
  
  if (isset($_SESSION['user'])) {
      header('Location:index.php');
      echo 'Hello2';
  }
  
  include 'init.php';
  // Check if user coming from HTTP post request

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = $_POST['username'];
      $pass = $_POST['password'];
      $hashedPass = sha1($pass);

      // Check if the user exists in database

      $stmt = $con->prepare('SELECT Username, Password FROM users WHERE Username = ? AND Password = ?');
      $stmt->execute(array($user, $hashedPass));
      $count = $stmt->rowCount();
      echo $count;


      // If count > 0 this means that database cotains record about this username

      if ($count > 0) {
          $_SESSION['user'] = $user; // Register session name
          print_r($_SESSION);
          header('Location: profile.php'); // Redirect to dashboard page
          exit();
      } else {
          echo 'Error';
      }
  }

  ?>


<div class="container login-page">
  <h1 class="text-center"><span class="selected" data-class="login">Login</span> | <span
      data-class="signup">Signup</span>
  </h1>
  <!-- Start Login Form -->
  <form class='login'
    action='<?php echo $_SERVER['PHP_SELF'] ?>'
    method='POST'>
    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username" />
    <input class="form-control" type="password" name="password" autocomplete="new-password"
      placeholder="Type your password" />
    <input class="btn btn-primary btn-block" type="submit" value="Log in" />
  </form>
  <!-- End Login Form -->
  <!-- Start Signup Form -->
  <form class="signup" action="">
    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username" />
    <input class="form-control" type="password" name="password" autocomplete="new-password"
      placeholder="Type your password" />
    <input class="form-control" type="email" name="email" placeholder="Type a valid email" />
    <input class="btn btn-success btn-block" type="submit" value="Sign up" />
  </form>
  <!-- End Signup Form -->
</div>
<?php include $tpl . 'footer.php';
