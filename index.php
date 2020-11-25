<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Guitar Wars - High Scores</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<h2>Guitar Wars - High Scores</h2>
		<p>Welcome, Guitar Warrior, do you have what it takes to crack the high score list? If so, just 
			<a href="addscore.php">add your own score</a>.
		</p>
		<hr />

		<?php
			require_once('appvars.php');
			require_once('connectvars.php');
			//define ('GW_UPLOADPATH', 'images/');
			// Connect to the database 
			//$dbc = mysqli_connect('localhost', 'root', 'root', 'gwdb');
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
				or die('Ошибка соединения с MySQL-сервером');

			// Retrieve the score data from MySQL
			$query = "SELECT * FROM guitarwars WHERE approved = 1 ORDER BY score DESC, date ASC";
			// "SELECT * FROM guitarwars ORDER BY name ASC";
			$data = mysqli_query($dbc, $query)
				or die('Ошибка при выполнении запроса к базе данных.');

			// Loop through the array of score data, formatting it as HTML 
			echo '<table>';
			$i = 0;
			while ($row = mysqli_fetch_array($data)) {
				if ($i == 0) {
					echo '<tr><td colspan="2" class="topscoreheader">Наивысший рейтинг: ' . $row['score'] . '</td></tr>';
				}
				// Display the score data
				echo '<tr><td class="scoreinfo">';
				echo '<span class="score">' . $row['score'] . '</span><br />';
				echo '<strong>Name:</strong> ' . $row['name'] . '<br />';
				echo '<strong>Date:</strong> ' . $row['date'] . '</td>';
				if (is_file (GW_UPLOADPATH . $row['screenshot']) && filesize (GW_UPLOADPATH . $row['screenshot']) > 0) {
					echo '<td><img src="' . GW_UPLOADPATH . $row['screenshot'] . '" alt="Подтверждено" /></td></tr>';
				}
				else {
					echo '<td><img src="' . GW_UPLOADPATH . 'unverified.gif" alt="Не подтверждено" /></td></tr>';
				}
				$i++;
			}
			echo '</table>';

			mysqli_close($dbc);
		?>

	</body> 
</html>
