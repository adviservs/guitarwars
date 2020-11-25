<?php
	require_once('authorize.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Guitar Wars - Approved a High Score</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h2>Guitar Wars - Approved a High Score</h2>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  if (isset($_GET['id']) && isset($_GET['date']) && isset($_GET['name']) && isset($_GET['score']) && isset($_GET['screenshot'])) {
    // Grab the score data from the GET
    $id = $_GET['id'];
    $date = $_GET['date'];
    $name = $_GET['name'];
    $score = $_GET['score'];
    $screenshot = $_GET['screenshot'];
  }
  else if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['score'])) {
    // Grab the score data from the POST
    $id = $_POST['id'];
    $name = $_POST['name'];
    $score = $_POST['score'];
		//$screenshot = $_POST['screenshot'];
  }
  else {
    echo '<p class="error">Sorry, no high score was specified for approval.</p>';
  }

  if (isset($_POST['submit'])) {
    if ($_POST['confirm'] == 'Yes') {
      // Delete the screen shot image file from the server
      //@unlink(GW_UPLOADPATH . $screenshot);

      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Delete the score data from the database
      $query = "UPDATE guitarwars SET approved = 1 WHERE id = $id";
      mysqli_query($dbc, $query);
      mysqli_close($dbc);

      // Confirm success with the user
      echo '<p>The high score of ' . $score . ' for ' . $name . ' was successfully approved.</p>';
			//echo '<p>' . $screenshot . '</p>';
			 
    }
    else {
      echo '<p class="error">Sorry, there was a problem approving the high score.</p>';
    }
  }
  else if (isset($id) && isset($name) && isset($date) && isset($score)) {
    echo '<p>Are you sure you want to approve the following high score?</p>';
    echo '<p><strong>Name: </strong>' . $name . '<br /><strong>Date: </strong>' . $date .
      '<br /><strong>Score: </strong>' . $score . '</p>';
    echo '<form method="post" action="approvescore.php">';
		echo '<img src="' . GW_UPLOADPATH . $screenshot . '" width="160" alt="Score image" /><br />';
    echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
    echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
    echo '<input type="submit" value="Submit" name="submit" />';
    echo '<input type="hidden" name="id" value="' . $id . '" />';
    echo '<input type="hidden" name="name" value="' . $name . '" />';
    echo '<input type="hidden" name="score" value="' . $score . '" />';
		//echo '<input type="hidden" name="screenshot" value="' . $screenshot . '" />';
    echo '</form>';
  }

  echo '<p><a href="admin.php">&lt;&lt; Back to admin page</a></p>';
?>

</body> 
</html>
