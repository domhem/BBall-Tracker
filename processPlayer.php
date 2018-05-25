<?php

// create short variable names
$teamID        = (int) $_POST['team_ID'];

$fullname      = array(preg_replace("/\t|\R/",' ',$_POST['lastName']), preg_replace("/\t|\R/",' ',$_POST['firstName']));
$name		       = implode(",", $fullname);
$street        = preg_replace("/\t|\R/",' ',$_POST['street']);
$city          = preg_replace("/\t|\R/",' ',$_POST['city']);
$state         = preg_replace("/\t|\R/",' ',$_POST['state']);
$country	     = preg_replace("/\t|\R/",' ',$_POST['country']);
$zipCode       = (string) $_POST['zipCode'];

require('game.php');
require('address.php');

$newTeam = new Game($teamID);
$teamID  = $newTeam->name_ID1();

$newAdd = new Address($name, $street, $city, $state, $country, $zipCode);
//create the variables for $stmt->bind_param
$name = explode(",", $newAdd->name());
$fname = null;
if(isset($name[1])){
	//trim to get rid of whitespace
	$fname = trim($name[1]);
}
$lname   = trim($name[0]);
$street  = $newAdd->street();
$city    = $newAdd->city();
$state   = $newAdd->state();
$country = $newAdd->country();
$zipCode = $newAdd->zipCode();
//Players dont store their email
$email = NULL;

if( ! empty($name) )
{
	//connect to database
  @$db = new mysqli('localhost', 'db_admin', 'password123', 'cpsc431_final');
    if (mysqli_connect_errno()) {
       echo "<p>Error: Could not connect to database.<br/>
             Please try again later.</p>";
       exit;
    }
    //Add Person Info to database
	$query = "INSERT INTO people(Name_First, Name_Last, Email, Street, City, State, Country, ZipCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ssssssss', $fname, $lname, $email, $street, $city, $state, $country, $zipCode);
    $stmt->execute();

    //Add that person to the player table
  $query2 = "INSERT INTO players
             SELECT people.Person_ID, $teamID FROM people
             WHERE people.Name_First = '$fname' AND people.Name_Last = '$lname'";
  $stmt2 = $db->prepare($query2);
  $stmt2->execute();

	$db->close();
}

require('addplayer.php');
?>
