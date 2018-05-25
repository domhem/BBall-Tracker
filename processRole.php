<?php

// create short variable names
$userID    = (int) $_POST['userID'];
$role      = preg_replace("/\t|\R/",' ',$_POST['role']);

if( ! empty($userID) )
{
	//connect to database
  @$db = new mysqli('localhost', 'db_admin', 'password123', 'cpsc431_final');
    if (mysqli_connect_errno()) {
       echo "<p>Error: Could not connect to database.<br/>
             Please try again later.</p>";
       exit;
    }
    $query ="UPDATE accounts SET Role = '$role' WHERE Account_ID = $userID";
    $stmt = $db->prepare($query);
    $stmt->execute();

	$db->close();
}

require('updaterole.php');
?>
