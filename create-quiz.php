<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styleinput.css" type="text/css">
		<title>Add your own quiz!</title>
	</head>
	
	<body>
		<form action="postQuiz.php" method="post">
			<div id="quiz">
		<!-- This part is only needed once per quiz	-->
				<div id="quiz-options">
					<label>Creator name: <input type="text" name="creator" id="creator" value="Syl" required></label><br>
					<label for="level">Difficulty level (1-5):</label>
					<input type="text" name="level" id="level" required><br>
					<label for="category">Category:</label>
					<select name="category" id="category">
						<option value="Vocabulary">Vocabulary</option>
						<option value="Grammar">Grammar</option>
						<option value="Conversation">Conversation</option>
						<option value="General">General</option>
						<option value="Idioms">Idioms</option>
						<option value="Spelling">Spelling</option>
					</select><br>
					<label for="title">Title:</label>
					<input type="text" name="title" id="title" required><br><br>
					<label for="timed">Timed:</label>
					<input type="checkbox" name="timed" id="timed" value="1"><br>
					<label for="timeLimit">Time limit (0 = not timed):</label>
					<input type="number" name="timeLimit" id="timeLimit" value="0" max="9" min="1" disabled> minutes<br><br>
					<label for="randomPs">Randomize problem order:</label>
					<input type="checkbox" name="randomPs" id="randomPs" value="1" checked><br>
					<label for="randomAs">Randomize answer order:</label>
					<input type="checkbox" name="randomAs" id="randomAs" value="1" checked><br><br>
				</div> <!-- quiz-options -->
		<!--	This part is needed for each problem added to the quiz	-->
				<div id="problem" class="problem">
					<p>Problem #1</p>
					Question: <textarea type="text" name="question[]" required cols="50" rows="3" id="qText1" onfocus="this.focus();this.select()"></textarea><br>
					Answer A: <textarea type="text" name="answerA[]" required cols="50" rows="3" id="aText1" onfocus="this.focus();this.select()"></textarea><br>
					Answer B: <textarea type="text" name="answerB[]" required cols="50" rows="3" id="bText1" onfocus="this.focus();this.select()"></textarea><br>
					Answer C: <textarea type="text" name="answerC[]" required cols="50" rows="3" id="cText1" onfocus="this.focus();this.select()"></textarea><br>
					Answer D: <textarea type="text" name="answerD[]" required cols="50" rows="3" id="dText1" onfocus="this.focus();this.select()"></textarea><br>
					Correct Answer (0-3): <input type="text" name="corrAns[]" required><br><br>
					Notes (optional): <input type="text" name="notes[]"><br>
					Image URL (optional): <input type="text" name="picUrl[]"><br>
					Audio URL (optional): <input type="text" name="audUrl[]"><br>
					YouTube video URL (optional): <input type="text" name="vidUrl[]"><br>
				</div> <!-- problem -->
			</div> <!-- quiz -->
			<button type="button" id="addQuestion">Add question</button>
			<br><br>
			<input type="submit" value="submit quiz"><br><br><br><br><br><br><br><br><br><br><br><br>
		</form>
		<script src="script-addQ.js"></script>
	</body>
</html>