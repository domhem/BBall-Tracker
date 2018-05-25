<?php
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $email = $mysqli->escape_string($_POST['email']);
	$result = $mysqli->query("SELECT * FROM accounts, people WHERE accounts.Person_ID = people.Person_ID AND people.Email = '$email'");

    if ( $result->num_rows == 0 ) // Email doesn't exist
    {
        $_SESSION['message'] = "User with that email doesn't exist!";
        header("location: error.php");
    }
    else { 

        $user = $result->fetch_assoc(); // $user becomes array with user data

        $email = $user['Email'];
        $hash = $user['Hash'];
        $first_name = $user['Name_First'];

        // Session message to display on success.php
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
        . " for a confirmation link to complete your password reset!</p>";

        // Send registration confirmation link (reset.php)
        $to      = $email;
        $subject = 'Password Reset Link';
        $message_body = '
        Hello '.$first_name.',

        You have requested password reset!

        Please click this link to reset your password:

        http://localhost/BBall-Tracker/reset.php?email='.$email.'&hash='.$hash;

        mail($to, $subject, $message_body);

        header("location: success.php");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <?php include 'css/css.html'; ?>
</head>

<body>

  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
      </label>
      <input type="email"required autocomplete="off" name="email" placeholder="Email Address"/>
    </div>
    <button class="button button-block"/>Reset</button>
    </form>
  </div>

</body>

</html>
