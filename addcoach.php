<?php
require_once('teamname.php');
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
    <title>Add Coach</title>
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
        echo "<li class=\"tab active\"><a style=\"width:33.33%\" href=\"addcoach.php\">Add New Coach</a></li>";
        echo "<li class=\"tab\"><a style=\"width:33.33%\" href=\"updateinfo.php\">Update Information</a></li>";
        echo "</ul>";
      }

      else if(isset($_SESSION['Manager'])) {
        echo "<ul class=\"tab-group\">";
        echo "<li class=\"tab\"><a style=\"width:100%\" href=\"stats_manager.php\">Basketball Team Statistics</a></li>";
        echo "</ul>";

        echo "<ul class=\"tab-group\">";
        echo "<li class=\"tab\"><a style=\"width:25%\" href=\"addplayer.php\">Add New Player</a></li>";
        echo "<li class=\"tab active\"><a style=\"width:25%\" href=\"addcoach.php\">Add New Coach</a></li>";
        echo "<li class=\"tab\"><a style=\"width:25%\" href=\"updateinfo.php\">Update Information</a></li>";
        echo "<li class=\"tab\"><a style=\"width:25%\" href=\"updaterole.php\">Update User Role</a></li>";
        echo "</ul>";
      }

    //Get teams for drop down menu
    @$db = new mysqli('localhost', 'db_admin', 'password123', 'cpsc431_final');
      if (mysqli_connect_errno()) {
        echo "<p>Error: Could not connect to database.<br/>
            Please try again later.</p>";
        exit;
      }

      $query = "SELECT Team_ID, Team_Name FROM `teams`";
      $teamq = $db->prepare($query);
      $teamq->execute();
      $teamq->store_result();
      $teamq->bind_result(
      $Team_ID,
      $Team_Name
      );
    ?>

        <td style="vertical-align:top; border:1px solid black;">
          <!-- FORM to enter Name and Address -->
          <form action="processCoach.php" method="post">
            <table style="margin: 0px auto; border: 0px; border-collapse:separate;">

              <tr>
                <td style="background: darkblue;">Team</td>
                <td><select name="team_ID" required>
                  <option value="" selected disabled hidden>Choose Team here</option>

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
                <td style="text-align: center; background: #000080">First Name</td>
                <td><input type="text" name="firstName" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: center; background: darkblue;">Last Name</td>
               <td><input type="text" name="lastName" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: center; background: darkblue;">Street</td>
               <td><input type="text" name="street" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: center; background: darkblue;">City</td>
                <td><input type="text" name="city" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: center; background: darkblue;">State</td>
                <td><input type="text" name="state" value="" size="35" maxlength="100"/></td>
              </tr>

              <tr>
                <td style="text-align: center; background: darkblue;">Country</td>
                <td><input type="text" name="country" value="" size="20" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: center; background: darkblue;">Zip</td>
                <td><input type="text" name="zipCode" value="" size="10" maxlength="10"/></td>
              </tr>

              <tr>
               <td colspan="2" style="text-align: center;"><input type="submit" value="Add Coach Name and Address" /></td>
              </tr>
            </table>
          </form>
        </td>


    <div style="text-align:center" class="form">
            <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>
    </div>

  </body>
</html>
