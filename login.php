<?php
//Login checks is the email exisits in the database and has a matching password

//Protect SQL injections
$username = $mysqli->escape_string($_POST['username']);
$result1 = $mysqli->query("SELECT * FROM people WHERE Email='$username'");

if ( $result1->num_rows == 0 ){ // Email doesn't exist
    $_SESSION['message'] = "User with that email/username doesn't exist!";
    header("location: error.php");
}
else { // Email exists
    $result2 = $mysqli->query("SELECT * FROM accounts, people WHERE accounts.Person_ID = people.Person_ID AND people.Email = '$username'");
    $user = $result2->fetch_assoc();

    if ( password_verify($_POST['password'], $user['Password']) ) {

        $_SESSION['first_name'] = $user['Name_First'];
        $_SESSION['last_name'] = $user['Name_Last'];

	  switch($user['Role']){

            case 'Observer':
                $_SESSION['logged_in'] = true;
				        $_SESSION['Observer'] = true;
				        header("location: stats_observer.php");
                exit();

            case 'User':
                $_SESSION['logged_in'] = true;
				        $_SESSION['User'] = true;
				        header("location: stats_user.php");
                exit();

            case 'Manager':
                $_SESSION['logged_in'] = true;
				        $_SESSION['Manager'] = true;
				        header("location: stats_manager.php");
                exit();
	  }

    }
    else {
        $_SESSION['message'] = "You have entered wrong password, try again!";
        header("location: error.php");
    }
}
