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
      if (isset($_POST['login'])) {
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
      } else {
          $formErrors = array();

          if (isset($_POST['username'])) {
              $filteredUser = filter_var($_POST['username'], FILTER_UNSAFE_RAW);
              
              if (strlen($filteredUser) < 4) {
                  $formErrors[] = 'Username must be larger than 4 characters';
              }
          }

          if (isset($_POST['email'])) {
              $filteredEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
              
              if (filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != true) {
                  $formErrors[] = 'This Email Is Not Valid';
              }
          }
          if (empty($formErrors)) {

            // Check if user exist in database
      
              $check = checkItem('Username', 'users', $_POST['username']);
      
              if ($check == 1) {
                  $formErrors[] = 'Sorry this user exists';
              } else {
                  // Insert userinfo in database
                  $stmt = $con->prepare("INSERT INTO  users(Username, Password, Email, RegStatus, Date) VALUES(:zuser, :zpass, :zmail, 0, now())");
                  $stmt->execute(array(
                'zuser' => $_POST['username'],
                'zpass' => sha1($_POST['password']),
                'zmail' => $_POST['email']
              ));
                  // Echo Success Message
                  $successMsg = 'Congrats you are now registered user';
              }
          } else {
              $erroMsg = 'Sorry You can\'t browser this page directly';
              redirectHome($erroMsg, 6);
          }
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
    <input class="btn btn-primary btn-block" name='login' type="submit" value="Log in" />
  </form>
  <!-- End Login Form -->
  <!-- Start Signup Form -->
  <form class="signup"
    action='<?php echo $_SERVER['PHP_SELF'] ?>'
    method='POST'>
    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username" />
    <input class="form-control" type="password" name="password" autocomplete="new-password"
      placeholder="Type your password" />
    <input class="form-control" type="email" name="email" placeholder="Type a valid email" />
    <input class="btn btn-success btn-block" name='signup' type="submit" value="Sign up" />
  </form>
  <!-- End Signup Form -->
  <div class="the-errors text-center">
    <?php
    if (!empty($formErrors)) {
        foreach ($formErrors as $error) {
            echo $error . '<br />';
        }
    }
    if (isset($successMsg)) {
        echo '<div class="msg success">' . $successMsg . '</div>';
    }
    ?>
  </div>
</div>
<?php include $tpl . 'footer.php';
