<?php
/* Displays user information and some useful messages */
session_start();

/* Check your role */
if (!(isset($_SESSION['Manager']))) {
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
    <title>Update Role</title>
  </head>
  <body>
    <ul class="tab-group">
      <li class="tab"><a style="width:100%" href="stats_manager.php">Basketball Team Statistics</a></li>
    </ul>

    <ul class="tab-group">
      <li class="tab"><a style="width:25%" href="addplayer.php">Add New Player</a></li>
      <li class="tab"><a style="width:25%" href="addcoach.php">Add New Coach</a></li>
      <li class="tab"><a style="width:25%" href="updateinfo.php">Update Information</a></li>
      <li class="tab active"><a style="width:25%" href="updaterole.php">Update User Role</a></li>
    </ul>

    <?php
    //get id and email of registered users
          $db = new mysqli('localhost','db_admin','password123','cpsc431_final');
          $query = "SELECT people.Person_ID, Email FROM people,accounts WHERE accounts.Person_ID = people.Person_ID";
            // Prepare, execute, store results, and bind results to local variables
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($Person_ID,
                               $Email
                              );
      ?>

    <td style="vertical-align:top; border:1px solid black;">
      <form action="processRole.php" method="post">
        <table style="margin: 0px auto; border: 0px; border-collapse:separate;">
          <tr>
            <td style="background: darkblue;">User Email</td>
            <td><select name="userID" required>
              <option value="" selected disabled hidden>Choose User here</option>

              <?php
                $stmt->data_seek(0);
                while( $stmt->fetch() )
                {
                  echo "<option value=\"$Person_ID\">".$Email."</option>\n";
                }

                ?>

            </select></td>
          </tr>

          <tr>
            <td style="background: darkblue;">Role</td>
            <td><select name="role" required>
              <option value="" selected disabled hidden>Choose Role</option>
              <option value="Observer">Observer</option>
              <option value="User">User</option>
              <option value="Manager">Manager</option>
            </select></td>
          </tr>
          <tr>
           <td colspan="2" style="text-align: center;"><input type="submit" value="Update Role" /></td>
          </tr>
        </table>
      </form>
    </td>

    <div style="text-align:center" class="form">
            <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>
    </div>

  </body>
</html>
