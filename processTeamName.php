<?php

// create short variable names
$teamName = preg_replace("/\t|\R/",' ',$_POST['teamName']);

require('teamname.php');

$newTeam = new Team($teamName);

//create the variables for $stmt->bind_param
$teamName  = $newTeam->teamName();

if( ! empty($teamName) )
{
	//connect to database
  @$db = new mysqli('localhost', 'db_admin', 'password123', 'cpsc431_final');
    if (mysqli_connect_errno()) {
       echo "<p>Error: Could not connect to database.<br/>
             Please try again later.</p>";
       exit;
    }
	  $query = "INSERT INTO teams(Team_Name) VALUES (?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $teamName);
    $stmt->execute();

	$db->close();
}

require('updateinfo.php');
?>
