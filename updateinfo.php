<?php

require_once('teamname.php');
require_once('game.php');
require_once('address.php');
/* Displays user information and some useful messages */
session_start();

/* Check your role */
if (isset($_SESSION['Observer'])) {
	$_SESSION['message'] = "404 Not Found!";
    header("location: error.php");
}

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");
}
  include 'css/css.html';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Update Info</title>
  </head>
  <body>

    <?php
      /* Check your role and generate the appropriate html tabs*/
      if(isset($_SESSION['User'])){
        echo "<ul class=\"tab-group\">";
        echo "<li class=\"tab\"><a style=\"width:100%\" href=\"stats_user.php\">Basketball Team Statistics</a></li>";
        echo "</ul>";

        echo "<ul class=\"tab-group\">";
        echo "<li class=\"tab\"><a style=\"width:33.33%\" href=\"addplayer.php\">Add New Player</a></li>";
        echo "<li class=\"tab\"><a style=\"width:33.33%\" href=\"addcoach.php\">Add New Coach</a></li>";
        echo "<li class=\"tab active\"><a style=\"width:33.33%\" href=\"updateinfo.php\">Update Information</a></li>";
        echo "</ul>";
      }

      else if(isset($_SESSION['Manager'])) {
        echo "<ul class=\"tab-group\">";
        echo "<li class=\"tab\"><a style=\"width:100%\" href=\"stats_manager.php\">Basketball Team Statistics</a></li>";
        echo "</ul>";

        echo "<ul class=\"tab-group\">";
        echo "<li class=\"tab\"><a style=\"width:25%\" href=\"addplayer.php\">Add New Player</a></li>";
        echo "<li class=\"tab\"><a style=\"width:25%\" href=\"addcoach.php\">Add New Coach</a></li>";
        echo "<li class=\"tab active\"><a style=\"width:25%\" href=\"updateinfo.php\">Update Information</a></li>";
        echo "<li class=\"tab\"><a style=\"width:25%\" href=\"updaterole.php\">Update User Role</a></li>";
        echo "</ul>";
      }

    //Get players for drop down menu
    @$db = new mysqli('localhost', 'db_admin', 'password123', 'cpsc431_final');
      if (mysqli_connect_errno()) {
        echo "<p>Error: Could not connect to database.<br/>
            Please try again later.</p>";
        exit;
      }
    //get Person information if their ID is in players table
      $query = "SELECT people.Person_ID, people.Name_First, people.Name_Last FROM people CROSS JOIN players WHERE people.Person_ID = players.Player_ID";
      $playerq = $db->prepare($query);
      $playerq->execute();
      $playerq->store_result();
      $playerq->bind_result(
      $Person_ID,
      $Name_First,
      $Name_Last
      );
    ?>

    <?php
    //Get teams for drop down menu
      $query = "SELECT Team_ID, Team_Name FROM `teams`";
      $teamq = $db->prepare($query);
      $teamq->execute();
      $teamq->store_result();
      $teamq->bind_result(
      $Team_ID,
      $Team_Name
      );
    ?>

    <?php
    //get games for drop down menu
      $query = "SELECT Game_ID, Date_Played FROM games";
      $game = $db->prepare($query);
      $game->execute();
      $game->store_result();
      $game->bind_result(
      $Game_ID,
      $Date_Played
      );
    ?>


    <table style="width: 100%; border:0px solid white; border-collapse:collapse;">
      <tr>
        <th style="">Update Player</th>
        <th style="">Add Game</th>
        <th style="">Add Team</th>
      </tr>
        <td style="vertical-align:top; border:1px solid black;">
          <!-- FORM to enter game statistics for a particular player -->
          <form action="processStatistics.php" method="post">
            <table style="margin: 0px auto; border: 0px; border-collapse:separate;">

              <tr>
                <td style="background: darkblue;">Name (Last, First)</td>
                <td><select name="name_ID" required>
                  <option value="" selected disabled hidden>Choose Person's name here</option>

                  <?php
                    $playerq->data_seek(0);
                    while( $playerq->fetch() )
                    {
                      $player = new Address([$Name_First, $Name_Last]);
                      echo "<option value=\"$Person_ID\">".$player->name()."</option>\n";
                    }

                    ?>

                </select></td>
              </tr>

              <tr>
                <td style="background: darkblue;">Game (Date Played)</td>
                <td><select name="game_ID" required>
                  <option value="" selected disabled hidden>Choose Game here</option>

                  <?php
                    $game->data_seek(0);
                    while( $game->fetch() )
                    {
                      echo "<option value=\"$Game_ID\">".strftime('%Y-%m-%d', strtotime($Date_Played))."</option>\n";
                    }

                   ?>

                </select></td>
              </tr>

              <tr>
                <td style="background: darkblue;">Playing Time (min:sec)</td>
               <td><input type="text" name="time" value="" size="5" maxlength="5"/></td>
              </tr>

              <tr>
                <td style="background: darkblue;">Points Scored</td>
               <td><input type="text" name="points" value="" size="3" maxlength="3"/></td>
              </tr>

              <tr>
                <td style="background: darkblue;">Assists</td>
                <td><input type="text" name="assists" value="" size="2" maxlength="2"/></td>
              </tr>

              <tr>
                <td style="background: darkblue;">Rebounds</td>
                <td><input type="text" name="rebounds" value="" size="2" maxlength="2"/></td>
              </tr>

              <tr>
               <td colspan="2" style="text-align: center;"><input type="submit" value="Add Player Statistic" /></td>
              </tr>
            </table>
          </form>
        </td>

        <td style="vertical-align:top; border:1px solid black;">
          <!-- FORM to enter a new Game -->
          <form action="processGame.php" method="post">
            <table style="margin: 0px auto; border: 0px; border-collapse:separate;">

              <tr>
                <td style="background: darkblue;">Team One</td>
                <td><select name="name_ID1" required>
                  <option value="" selected disabled hidden required>Choose Team</option>

                  <?php
                    $teamq->data_seek(0);
                    while( $teamq->fetch() )
                    {
                      $team = new Team($Team_Name);
                      echo "<option value=\"$Team_ID\">".$team->teamName()."</option>\n";
                    }

                   ?>

                </select></td>
              </tr>

              <tr>
                <td style="background: darkblue;">Team Two</td>
                <td><select name="name_ID2" required>
                  <option value="" selected disabled hidden required>Choose Team</option>

                  <?php
                    $teamq->data_seek(0);
                    while( $teamq->fetch() )
                    {
                      $team = new Team($Team_Name);
                      echo "<option value=\"$Team_ID\">".$team->teamName()."</option>\n";
                    }

                   ?>

                </select></td>
              </tr>

              <tr>
                <td style="background: darkblue;">Date Played</td>
                <td><input type="date" name="dateplayed" value="" required/></td>
              </tr>

              <tr>
               <td colspan="2" style="text-align: center;"><input type="submit" value="Add Game" /></td>
              </tr>
            </table>
          </form>
        </td>

        <td style="vertical-align:top; border:1px solid black;">
          <!-- FORM to enter Team Name -->
          <form action="processTeamName.php" method="post">
            <table style="margin: 0px auto; border: 0px; border-collapse:separate;">

              <tr>
                <td style="text-align: center; background: darkblue">Team Name</td>
                <td><input type="text" name="teamName" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
               <td colspan="2" style="text-align: center;"><input type="submit" value="Add New Team" /></td>
              </tr>

            </table>
          </form>
        </td>

      </table>


    <div style="text-align:center" class="form">
            <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>
    </div>

  </body>
</html>
