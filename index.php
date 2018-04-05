<?php
	include "header.php";
?>

		<div class="wrapper quiz-list">
			<div class="filters-bar">
				<div class="filters-btn">
					<p>Category/Level Filters</p>
				</div>
			</div>

			<div class="filters-box hide">
				<div class="filters-box-inner">
					<div class="x-close">X</div>
					<div class="categories-div group">
						<h2>Select categories</h2>
						<ul>
							<li class="category-btn">Vocabulary</li>
							<li class="category-btn">Grammar</li>
							<li class="category-btn">Pronunciation</li>
							<li class="category-btn">Conversation</li>
							<li class="category-btn">Idioms</li>
							<li class="category-btn">Spelling</li>
						</ul>
					</div>

					<div class="levels-div group">
						<h2>Select a level</h2>
						<ul>
							<li class="level-btn">Level 1 (basic)</li>
							<li class="level-btn">Level 2 (easy)</li>
							<li class="level-btn">Level 3 (medium)</li>
							<li class="level-btn">Level 4 (hard)</li>
							<li class="level-btn">Level 5 (native)</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="quiz-previews" id="quiz-previews"></div>

			<footer>
				<p>ESL Quiz Site 2017 All right reserved</p>
			</footer>
		</div>
		
		<div id="problem">
			<div id="questionNumber"></div>
			<div class="categoryDiv"></div>
			<div class="quiz-title"></div>
			<div id="mediaContainer"></div>
			<div class="questionDiv">
				<p class="questionText"></p>
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
<!--
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
-->
		</div>
		<div class="quizReview hide"></div>
		
		<script src="script.js"></script>
	</body>
	
</html>


