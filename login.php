<?php include 'init.php'; ?>
<div class="container login-page">
  <h1 class="text-center"><span class="selected" data-class="login">Login</span> | <span
      data-class="signup">Signup</span>
  </h1>
  <form class="login" action="">
    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username" />
    <input class="form-control" type="password" name="password" autocomplete="new-password"
      placeholder="Type your password" />
    <input class="btn btn-primary btn-block" type="submit" value="Log in" />
  </form>
  <form class="signup" action="">
    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username" />
    <input class="form-control" type="password" name="password" autocomplete="new-password"
      placeholder="Type your password" />
    <input class="form-control" type="email" name="email" placeholder="Type a valid email" />
    <input class="btn btn-success btn-block" type="submit" value="Sign up" />
  </form>
</div>
<?php include $tpl . 'footer.php';
