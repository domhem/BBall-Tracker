<?php
//Login form
require 'db.php';
session_start();
?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Sign-Up/Login Form</title>
    <?php include 'css/css.html'; ?>
  </head>

  <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login'])) { //user logging in
        require 'login.php';
    }
    elseif (isset($_POST['register'])) { //user registering
        require 'register.php';
    }
}
?>
    <body>
      <div class="form">
        <ul class="tab-group">
          <li class="tab"><a href="signup.php" style="width:50%">Sign Up</a></li>
          <li class="tab active"><a href="index.php" style="width:50%">Log In</a></li>
        </ul>
          <div id="login">
            <h1>Welcome to BBall Tracker!</h1>
            <form action="index.php" method="post" autocomplete="off">
              <div class="field-wrap">
                <input type="username" required autocomplete="off" name="username" placeholder="Username*"/>
              </div>
              <div class="field-wrap">
                <input type="password" required autocomplete="off" name="password" placeholder="Password*"/>
              </div>
              <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>
              <button class="button button-block" name="login" />Log In</button>
            </form>
          </div>
      </div>

 </body>
</html>
