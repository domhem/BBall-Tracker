<?php

// create short variable names
$name_ID    = (int) $_POST['name_ID'];
$game_ID    = (int) $_POST['game_ID'];
$time       = preg_replace("/\t|\R/",' ',$_POST['time']);
$points     = (int) $_POST['points'];
$assists    = (int) $_POST['assists'];
$rebounds   = (int) $_POST['rebounds'];

require('playerstatistics.php');

$newStat = new PlayerStatistic($name_ID, $game_ID, $time, $points, $assists, $rebounds);

//create the variables for $stmt->bind_param
$name_ID = $newStat->name_ID();
$game_ID = $newStat->game_ID();
$time = explode(":", $newStat->playingTime());
//create new $min and $sec variables using the string values from $time
$min = (int) $time[0];
$sec = (int) $time[1];
$points = $newStat->pointsScored();
$assists = $newStat->assists();
$rebounds = $newStat->rebounds();

if( ! empty($name_ID) )
{
	//connect to database
  @$db = new mysqli('localhost', 'db_admin', 'password123', 'cpsc431_final');
    if (mysqli_connect_errno()) {
       echo "<p>Error: Could not connect to database.<br/>
             Please try again later.</p>";
       exit;
    }
    //Update the statistics table
	  $query = "INSERT INTO statistics(Player_ID, Game_ID, Points, Assists, Rebounds, PlayingTimeMin, PlayingTimeSec) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('iiiiiii', $name_ID, $game_ID, $points, $assists, $rebounds, $min, $sec);
    $stmt->execute();

    //Get team ID of player
    $query2 = "SELECT Team_ID from players WHERE Player_ID = $name_ID";
    $stmt2 = $db->prepare($query2);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result(
    $teamid
    );
    $stmt2->data_seek(0);
    while( $stmt2->fetch() )
    {
    }

    //Update the scores table to reflect changes in the team's score
    $query3 = "UPDATE scores
               SET Score = Score + $points
               WHERE Game_ID = '$game_ID' AND Team_ID = '$teamid'";
    $stmt3 = $db->prepare($query3);
    $stmt3->execute();

    $db->close();
}

require('updateinfo.php');
?>
