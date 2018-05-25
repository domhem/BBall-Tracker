<?php

// create short variable names
$name_ID1    = (int) $_POST['name_ID1'];
$name_ID2    = (int) $_POST['name_ID2'];
$dateplayed  = $_POST['dateplayed'];

require('game.php');

$newGame = new Game($name_ID1, $name_ID2, $dateplayed);

//create the variables for $stmt->bind_param
$teamone  = $newGame->name_ID1();
$teamtwo  = $newGame->name_ID2();
$gamedate = $newGame->date_played();
$score = 0;

if( ! empty($gamedate) )
{
	//connect to database
  @$db = new mysqli('localhost', 'db_admin', 'password123', 'cpsc431_final');
    if (mysqli_connect_errno()) {
       echo "<p>Error: Could not connect to database.<br/>
             Please try again later.</p>";
       exit;
    }
    //Update the game table
	$query = "INSERT INTO games(Date_Played, Team_One, Team_Two) VALUES (?,?,?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $gamedate, $teamone, $teamtwo);
    $stmt->execute();

    //Update the score table for each team in the game
    $query2 = "INSERT INTO scores
               SELECT games.Game_ID, games.Team_One, $score FROM games
               WHERE games.Team_One = '$teamone' AND games.Date_Played = '$gamedate'";
    $stmt2 = $db->prepare($query2);
    $stmt2->execute();

    $query3 = "INSERT INTO scores
               SELECT games.Game_ID, games.Team_Two, $score FROM games
               WHERE games.Team_Two = '$teamtwo' AND games.Date_Played = '$gamedate'";
    $stmt3 = $db->prepare($query3);
    $stmt3->execute();

	$db->close();
}

require('updateinfo.php');
?>
