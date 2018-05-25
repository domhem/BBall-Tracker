<?php

// Set session variables to be used on stats page (Welcome firstname Lastname)
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);

$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );

// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM people WHERE Email='$email'") or die($mysqli->error());

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {

    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");

}

// Check if password meets requirements of length 8 with 1 number and 1 letter.
if (!(
  (strlen($_POST['password']) >= 8) &&
   preg_match('/[A-Za-z]/', $_POST['password']) &&
   preg_match('/\d/', $_POST['password'])))
  {
	$_SESSION['message'] = 'Password must contain at least 8 characters with 1 number and 1 letter.';
    header("location: error.php");
  }

else { // Email doesn't already exist in a database, proceed...

    $sql1 = "INSERT INTO people (Name_First, Name_Last, Email) " . "VALUES ('$first_name', '$last_name', '$email' )";
    $mysqli->query($sql1);

    //get Person ID
    $sql2 = "SELECT Person_ID FROM people WHERE Email = '$email'";
    $result = $mysqli->query($sql2);
    $personID = $result->fetch_object();

    //For testing
    //Determine if it is the first person to register
    //$sql3 = "SELECT Person_ID FROM people";
    //$result2 = $mysqli->query($sql3);

    //If it is the first person added to the db, role will be manager. Else role will be observer
    //if($result2->num_rows == 1){
    //  $sql = "INSERT INTO accounts (Person_ID, Password, Hash, Role) " . "VALUES ('$personID->Person_ID', '$password', '$hash', 'Manager' )";
    //}
    //else{
    $sql = "INSERT INTO accounts (Person_ID, Password, Hash, Role) " . "VALUES ('$personID->Person_ID', '$password', '$hash', 'Observer' )";
    //}

    // Add user to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['Observer'] = true;
        header("location: stats_observer.php");
    }

    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }

}
