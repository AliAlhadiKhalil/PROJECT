<?php
	// Connect to the database
	require 'config.php';
	if (!isset($_SESSION['user_email'])) {
		header('Location: index.php');
		exit();
	}
	
	// Check if the form has been submitted
	if (isset($_POST["submit"]) && isset($_POST['answer'])) {
		// Retrieve the submitted answers
		$submitted_answers = $_POST['answer'];
		$score = 0;
		$incorrect = array();
		
		// Calculate the score
		foreach ($submitted_answers as $question_id => $answer) {
			// Retrieve the correct answer for the question
			$query = "SELECT correct_answer FROM questions WHERE question_id={$question_id}";
			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			$correct_answer = $row['correct_answer'];
			
			if ($answer == $correct_answer) {
				// Increment the score for correct answers
				++$score;
			} else {
				$incorrect[] = $question_id;
			}
		}
		
		// Calculate the percentage score
		$percent = $score* 10;
		
		$id = $_SESSION['user_id'];
		// Insert the score into the database
		$sql = "INSERT INTO scores (`user_id`, `quiz_id`, `score`, `date_completed`) VALUES ($id, $quiz_id, $percent, NOW())";
		$query = "UPDATE scores SET score=$percent, date_completed=NOW() WHERE user_id=$id AND quiz_id=$quiz_id";
		if ($conn->query($sql)) {
			// Insert successful
			$_SESSION['score'] = $percent;
			 $_SESSION['incorrect'] = $incorrect;
			$conn->close(); 
			header('location: showResult.php');
			exit();
		} else {
			$check_top_score = $conn->query("select * from scores where user_id = $id and quiz_id=$quiz_id");
			if($check_top_score && $check_top_score->num_rows >0 && ($row = $check_top_score->fetch_assoc() )){
				$checked_score = $row['score'];
				$_SESSION['score'] = $percent;
				$_SESSION['incorrect'] = $incorrect;
				if($checked_score < (int)$percent){
					$conn->query($query);
					$conn->close(); 
					header('location: showResult.php');
					exit();
				}else{
					echo "<script>
						alert('your previous score:$checked_score is higher than your current score:$percent');
						location.href='showResult.php';
						</script>";
				}
			}else{
				echo "<script>alert('error during reading from database')</script>";
			}
			// Insert failed, try update instead
		}
	}
	
	// Retrieve the questions from the database
	$query = "SELECT * FROM questions WHERE quiz_id=$quiz_id ORDER BY RAND() LIMIT 10";
	$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Quiz Form-<?php $quiz_title ?></title>
	<link rel="stylesheet" href="./css/question.css">
</head>
<body>
	<?php
		// Display the questions
		echo '<form method="post">';
		while ($row = $result->fetch_assoc()) {
			// Retrieve the answer options for the question
			$answer_query = "SELECT * FROM answers WHERE question_id={$row['question_id']}";
			$answer_result = $conn->query($answer_query);
			
			$answers = array();
			while ($answer_row = $answer_result->fetch_assoc()) {
				$answers[] = $answer_row['answer_text'];
			}
			shuffle($answers);
			// Display the question and answer options
			echo '<div class="question">';
			echo '<h3>' . $row['question_text'] . '</h3>';
			foreach ($answers as $answer) {
				echo '<div class="answer">';
				echo '<input type="radio" id ="'.$answer.'" name="answer[' . $row['question_id'] . ']" value="' . $answer . '" required> ';
				echo "<label style='display:inline-block;' for='$answer'>$answer</label>";
				echo '</div>';
			}
		}
		// Close the database connection
		echo '<input type="submit" name="submit" value="Check">';
		echo '</form>';
	?>
</body>
</html>