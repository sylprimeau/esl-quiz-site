<?php
	include "header.php";
?>

  	<div class="levelSelectScreen">
			<div class="levelInstructions">Select the level you want to start at</div>
			<div class="levels">
				<div class="levelButton noselect">Level 1</div>
				<div class="levelButton noselect">Level 2</div>
				<div class="levelButton noselect">Level 3</div>
				<div class="levelButton noselect">Level 4</div>
				<div class="levelButton noselect">Level 5</div>
			</div>
			<hr>
			<div class="categoryInstructions">Select the categories you want</div>
			<div class="categories">
				<div class="categoryButton noselect">Vocabulary</div>
				<div class="categoryButton noselect">Grammar</div>
				<div class="categoryButton noselect">Conversation</div>
				<div class="categoryButton noselect">Pronunciation</div>
				<div class="categoryButton noselect">Idioms</div>
			</div>
			<button type="button" class="startButton">Start!</button>
  	</div>
  	
		<div id="problem">
			<div class="categoryDiv">Quiz Category</div>
			<div id="questionNumber"></div>
			<div id="mediaContainer"></div>
			<div class="questionDiv">
				<p class="questionText">The question goes here</p>
			</div>
			<div class="answers">
				<div class="answerButton noselect">
					<p id="0" class="answerText"></p>
				</div>
				<div class="answerButton noselect">
					<p id="1" class="answerText"></p>
				</div>
				<div class="answerButton noselect">
					<p id="2" class="answerText"></p>
				</div>
				<div class="answerButton noselect">
					<p id="3" class="answerText"></p>
				</div>
			</div>
			<div id="avgScore"></div>
			<div id="timesTaken"></div>
			<div class="ratingStars">
				<span class="starsTooltip">Click to rate!</span>
				<div id="star1" class="ratingStar"></div>
				<div id="star2" class="ratingStar"></div>
				<div id="star3" class="ratingStar"></div>
				<div id="star4" class="ratingStar"></div>
				<div id="star5" class="ratingStar"></div>
			</div>
		</div>
		<div class="quizReview hide"></div>
	<script src="script.js"></script>

</body>

</html>






