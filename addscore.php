<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Guitar Wars - Add Your High Score</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<h2>Guitar Wars - Add Your High Score</h2>
		
		<?php
			require_once('appvars.php');
			require_once('connectvars.php');
			//define ('GW_UPLOADPATH', 'images/');
			
			if (isset($_POST['submit'])) {
				// Connect to the database
				$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

				// Grab the score data from the POST
				$name = mysqli_real_escape_string($dbc, trim($_POST['name']));
				$score = mysqli_real_escape_string($dbc, trim($_POST['score']));
				$screenshot = mysqli_real_escape_string($dbc, trim($_FILES['screenshot']['name']));
				$screenshot_type = $_FILES['screenshot']['type'];
				$screenshot_size = $_FILES['screenshot']['size'];

				if (!empty($name) && is_numeric($score) && !empty($screenshot)) {
					if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png'))
						&& ($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE)) {
						if ($_FILES['screenshot']['error'] == 0) {
							$target = GW_UPLOADPATH . $screenshot;
							if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {


								// Write the data to the database
								$query = "INSERT INTO guitarwars (date, name, score, screenshot) VALUES (NOW(), '$name', '$score', '$screenshot')";
								mysqli_query($dbc, $query);

								// Confirm success with the user
								echo '<p>Thanks for adding your new high score!</p>';
								echo '<p><strong>Name:</strong> ' . $name . '<br />';
								echo '<strong>Score:</strong> ' . $score . '</p>';
								echo '<img src="' . GW_UPLOADPATH . $screenshot . '" alt="" /><br />';
								echo '<p><a href="index.php">&lt;&lt; Back to high scores</a></p>';

								// Clear the score data to clear the form
								$name = "";
								$score = "";
								$screenshot = "";

								mysqli_close($dbc);
							}
							else {
								echo '<p class="error">Извините, возникла ошибка при загрузке файла изображения.</p>';
							}
						}
					}
					else {
						echo '<p class="error">Файл, подтверждающий рейтинг, должен' .
							'быть файлом изображения в форматах GIF, JPEG или PNG' .
							' и его размер не должен превышать ' . (GW_MAXFILESIZE / 1024) . ' Кб.</p>';
					}
					// Try to delete the temporary screen shot image file
					//@unlink($_FILES['screenshot']['tmp_name']);
				}
				else {
					echo '<p class="error">Введите, пожалуйста, всю информацию для добавления вашего рейтинга</p>';
				}
			}
		?>
		
		<hr />
		<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" name="MAX_FILE_SIZE" value="32768" />
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>" /><br />
			<label for="score">Score:</label>
			<input type="text" id="score" name="score" value="<?php if (!empty($score)) echo $score; ?>" /><br />
			<label for="screenshot">Файл изображения:</label>
      <input type="file" id="screenshot" name="screenshot" /><br/>
			<hr />
			<input type="submit" value="Add" name="submit" />
		</form>
	</body> 
</html>