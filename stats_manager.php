<?php
/* Displays user information and some useful messages */
require_once('address.php');
session_start();

/* Check your role */
if ($_SESSION['Manager'] != 1) {
	$_SESSION['message'] = "404 Not Found!";
    header("location: error.php");
}

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");
}
else {
    //To use for Welcome message
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
}
  include 'css/css.html';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>CPSC 431 Final</title>
  </head>
  <body>
    <ul class="tab-group">
      <li class="tab active"><a style="width:100%" href="stats_manager.php">Basketball Team Statistics</a></li>
    </ul>

    <ul class="tab-group">
      <li class="tab"><a style="width:25%" href="addplayer.php">Add New Player</a></li>
      <li class="tab"><a style="width:25%" href="addcoach.php">Add New Coach</a></li>
      <li class="tab"><a style="width:25%" href="updateinfo.php">Update Information</a></li>
      <li class="tab"><a style="width:25%" href="updaterole.php">Update User Role</a></li>
    </ul>

    <h1>Welcome<?php echo ' '.$first_name.' '.$last_name; ?></h1>


    <?php
    //get all players info ( full name, address, team)
          $db = new mysqli('localhost','db_admin','password123','cpsc431_final');
          $query = "SELECT
				            P.Person_ID,
                    P.Name_First,
				            P.Name_Last,
				            P.Street,
				            P.City,
				            P.State,
				            P.ZipCode,
				            P.Country,
                    T.Team_Name
			              FROM
				            people as P CROSS JOIN players as X CROSS JOIN teams as T
                    WHERE
            	      P.Person_ID = X.Player_ID AND T.Team_ID = X.Team_ID
			              GROUP BY
				            P.Name_First,
				            P.Name_Last
			              ORDER BY
				            P.Name_Last,
				            P.Name_First";

            // Prepare, execute, store results, and bind results to local variables
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($Player_ID,
                               $Name_First,
                               $Name_Last,
                               $Street,
                               $City,
                               $State,
                               $ZipCode,
                               $Country,
                               $Team_Name
                              );

        //get all coaches info (full name, address, team)
              $query2 = "SELECT
    				            P.Person_ID,
                        P.Name_First,
    				            P.Name_Last,
    				            P.Street,
    				            P.City,
    				            P.State,
    				            P.ZipCode,
    				            P.Country,
                        T.Team_Name
    			              FROM
    				            people as P CROSS JOIN coaches as X CROSS JOIN teams as T
                        WHERE
                	      P.Person_ID = X.Coach_ID AND T.Team_ID = X.Team_ID
    			              GROUP BY
    				            P.Name_First,
    				            P.Name_Last
    			              ORDER BY
    				            P.Name_Last,
    				            P.Name_First";

                // Prepare, execute, store results, and bind results to local variables
                $stmt2 = $db->prepare($query2);
                $stmt2->execute();
                $stmt2->store_result();
                $stmt2->bind_result($Coach_ID,
                                   $Name_First,
                                   $Name_Last,
                                   $Street,
                                   $City,
                                   $State,
                                   $ZipCode,
                                   $Country,
                                   $Team_Name
                                  );

          //get all game info (date played, team one name, team one score, team two name, team two score)
                $query3 = "SELECT
	                          g.Game_ID,
	                          g.Date_Played,
	                          t1.Team_Name,
                            s1.Score,
                            t2.Team_Name,
                            s2.Score
                            FROM
                            games g
                            JOIN
                            scores s1 ON s1.Team_ID = g.Team_One
                            JOIN
                            scores s2 ON s2.Team_ID = g.Team_Two
                            JOIN
                            teams t1 ON s1.Team_ID = t1.Team_ID
                            JOIN
                            teams t2 ON s2.Team_ID = t2.Team_ID
                            WHERE
                            s1.Game_ID = g.Game_ID
                            AND
                            s2.Game_ID = g.Game_ID
                            GROUP BY
                            g.Game_ID
                            ORDER BY
                            g.Date_Played";


                  // Prepare, execute, store results, and bind results to local variables
                  $stmt3 = $db->prepare($query3);
                  $stmt3->execute();
                  $stmt3->store_result();
                  $stmt3->bind_result($Game_ID,
                                     $Date_Played,
                                     $Team_Name1,
                                     $Score1,
                                     $Team_Name2,
                                     $Score2
                                    );
        ?>

    <h2 style="text-align:center">Player Information</h2>

    <table align="center" style="border:1px solid black; border-collapse:collapse;">
      <tr>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Full Name</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Address</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Team</th>
      </tr>

    <?php
      $fmt_style = 'style="vertical-align:top; border:1px solid black; color:black;"';
      $stmt->data_seek(0);

      while( $stmt->fetch() )
        {
          // construct Address objects supplying as constructor parameters the retrieved database columns
          $player = new Address([$Name_First, $Name_Last], $Street, $City, $State, $Country, $ZipCode);

          // Emit table row data using appropriate getters from the Address objects
          echo "      <tr>\n";
          echo "        <td  $fmt_style>".$player->name()."</td>\n";
          echo "        <td  $fmt_style>".$player->street()."<br/>"
                                         .$player->city().', '.$player->state().' '.$player->zipCode().'<br/>'
                                         .$player->country()."</td>\n";
          echo "        <td  $fmt_style>".$Team_Name."</td>\n";
        }

     ?>
     </table>

	   <br></br>

    <h2 style="text-align:center">Coach Information</h2>

    <table align="center" style="border:1px solid black; border-collapse:collapse;">
      <tr>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Full Name</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Address</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Team</th>
      </tr>

      <?php
        $fmt_style = 'style="vertical-align:top; border:1px solid black; color:black;"';
        $stmt2->data_seek(0);

        while( $stmt2->fetch() )
          {
            // construct Address objects supplying as constructor parameters the retrieved database columns
            $coach = new Address([$Name_First, $Name_Last], $Street, $City, $State, $Country, $ZipCode);

            // Emit table row data using appropriate getters from the Address objects
            echo "      <tr>\n";
            echo "        <td  $fmt_style>".$coach->name()."</td>\n";
            echo "        <td  $fmt_style>".$coach->street()."<br/>"
                                           .$coach->city().', '.$coach->state().' '.$coach->zipCode().'<br/>'
                                           .$coach->country()."</td>\n";
            echo "        <td  $fmt_style>".$Team_Name."</td>\n";
          }

       ?>
       </table>

			 <br></br>

    <h2 style="text-align:center">Games Information</h2>

    <table align="center" style="border:1px solid black; border-collapse:collapse;">
      <tr>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Date Played</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Team One</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Team One Score</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Team Two</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Team Two Score</th>
      </tr>

      <?php
        $fmt_style = 'style="vertical-align:top; border:1px solid black; color:black;"';
        $stmt3->data_seek(0);

        while( $stmt3->fetch() )
          {
            echo "      <tr>\n";
            echo "        <td  $fmt_style>".$Date_Played."</td>";
            echo "        <td  $fmt_style>".$Team_Name1."</td>";
            echo "        <td  $fmt_style>".$Score1."</td>";
            echo "        <td  $fmt_style>".$Team_Name2."</td>";
            echo "        <td  $fmt_style>".$Score2."</td>";
          }

       ?>

    </table>

		<br></br>

    <h2 style="text-align:center">Player Statistics</h2>

    <table align="center" style="border:1px solid black; border-collapse:collapse;">
      <tr>
        <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Date of Game</th>
      </tr>

    <form action="" method="post">
      <td><select name="game_ID" onChange="this.form.submit()">
        <option value="" selected disabled hidden>Choose Game here</option>

        <?php
          $stmt3->data_seek(0);
          while( $stmt3->fetch() )
          {
            echo "<option value=\"$Game_ID\">".strftime('%Y-%m-%d', strtotime($Date_Played))."</option>\n";
          }

          ?>

      </select></td>
    </form>

    <tr>
      <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Player Name</th>
      <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Team</th>
      <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Total Points</th>
      <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Total Assists</th>
      <th style="vertical-align:top; border:1px solid black; background: lightgrey;">Total Rebounds</th>
    <tr>

      <?php
          if (isset($_POST['game_ID'])){
                  $game_ID = $_POST['game_ID'];
            //Get statistics of Game (Player name, team, points, assists, rebounds)
                  $query4 = "SELECT
                              people.Name_First,
                              people.Name_Last,
                              teams.Team_Name,
                              ROUND(SUM(statistics.Points),0) AS 'Total Points',
                              ROUND(SUM(statistics.Assists),0) AS 'Total Assists',
                              ROUND(SUM(statistics.Rebounds),0) AS 'Total Rebounds'
                              FROM
                              people cross join teams cross join statistics cross join players
                              WHERE
                              people.Person_ID = players.Player_ID
                              AND
                              statistics.Game_ID = $game_ID
                              AND
                              statistics.Player_ID = players.Player_ID
                              AND
                              teams.Team_ID = players.Team_ID
                              GROUP BY
                              people.Name_First,
                              people.Name_Last";


                    // Prepare, execute, store results, and bind results to local variables
                    $stmt4 = $db->prepare($query4);
                    $stmt4->execute();
                    $stmt4->store_result();
                    $stmt4->bind_result($Name_First,
                                       $Name_Last,
                                       $Team_Name,
                                       $Points,
                                       $Assists,
                                       $Rebounds
                                      );

                    //Make table
                    $fmt_style = 'style="vertical-align:top; border:1px solid black; color:black;"';
                    $stmt4->data_seek(0);

                    while( $stmt4->fetch() )
                      {
                        $pstat = new Address([$Name_First, $Name_Last]);
                        echo "        <tr>\n";
                        echo "        <td  $fmt_style>".$pstat->name()."</td>";
                        echo "        <td  $fmt_style>".$Team_Name."</td>";
                        echo "        <td  $fmt_style>".$Points."</td>";
                        echo "        <td  $fmt_style>".$Assists."</td>";
                        echo "        <td  $fmt_style>".$Rebounds."</td>";
                      }
          }

      ?>

    </table>


    <div style="text-align:center" class="form">
            <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>
    </div>

  </body>
</html>
