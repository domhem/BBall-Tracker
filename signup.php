<?php
/* Main page with two forms: sign up and log in */
require 'db.php';
session_start();
?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Sign-Up</title>
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
          <li class="tab active"><a href="signup.php" style="width:50%">Sign Up</a></li>
          <li class="tab"><a href="index.php" style="width:50%">Log In</a></li>
        </ul>
          <div id="signup">
            <h1>Sign Up for Free</h1>
            <form action="index.php" method="post" autocomplete="off">
              <div class="top-row">
                <div class="field-wrap">
                  <input type="text" required autocomplete="off" name='firstname' placeholder="First Name*" />
                </div>
                <div class="field-wrap">
                  <input type="text" required autocomplete="off" name='lastname' placeholder="Last Name*" />
                </div>
              </div>
              <div class="field-wrap">
                <input type="email" required autocomplete="off" name='email' placeholder="Email Address*" />
              </div>
              <div class="field-wrap">
                <input type="password" required autocomplete="off" name='password' placeholder="Password*" />
                <a>Password must be at least 8 characters containing 1 number and 1 letter</a>
              </div>
              <button type="submit" class="button button-block" name="register" />Register</button>
            </form>
          </div>
        </div>
      </div>

 </body>
</html>
